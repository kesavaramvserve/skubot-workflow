<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Client;
use App\Models\ClientPrice;
use App\Models\Website;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::where('id','!=',1)->orderBy('id','DESC')->paginate(5);
        return view('super_admin.user.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::where('name','!=','Super Admin')->where('name','!=','Client')->get();
        $tls    = User::role('Team Lead')->get();
        // dd($tls);
        return view('super_admin.user.create',compact('roles','tls'));
    }

    public function create_client()
    {
        $pm_list    = User::role('Operation')->get();
        return view('super_admin.user.create_client',compact('pm_list'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);
    
        $input = $request->all();
        $input['password']      = Hash::make($input['password']);
        $input['first_name']    = $input['name'];
        if($request->tl_id){
            $input['tl_id']     = $input['tl_id'];
        }
        
        $user = User::create($input); 
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('users.index')
                        ->with('success','User created successfully');
    }

    public function store_client(Request $request)
    {
        // dd($request);
        // Data Validation
        $this->validate($request, [
            'first_name'    => 'required|min:3',
            'email'         => 'required|email|unique:users,email',
            'company_name'  => 'required',
            'website'       => 'required',
            'pm_id'         => 'required'
        ],
        [
            'pm_id.required' => 'This Project Manager field is required',
        ]);

        // Date Reset
        $password               = '12345678';
        $input                  = $request->all();
        $input['password']      = Hash::make($password);
        $input['first_name']    = $request->first_name;
        $input['last_name']     = $input['last_name'];
    
        // Date Store
        DB::beginTransaction();
        try {

            $user = User::create($input);
            $user->assignRole(3);

            $client = Client::create([
                'user_id'       => $user->id,
                'company_name'  => $request->company_name,
                'website'       => $request->website
            ]);

            $website = Website::create([
                'client_id'     => $client->id,
                'pm_id'         => $request->pm_id,
                'vserve_status' => 'New',
                'client_status' => 'New',
                'website'       => $request->website,
            ]);

            // Set Default Price
            $content_id = 1;
            $range_id = 0;
            for($i=1;$i<=25;$i++){
                $range_id++;
                if($i==6 || $i==11 || $i==16 || $i==21 || $i==26){
                    $content_id++;
                    $range_id = 1;
                }
                $client_price = ClientPrice::create([
                    'client_id'     => $client->id,
                    'website_id'    => $website->id,
                    'content_id'    => $content_id,
                    'range_id'      => $range_id,
                    'price'         => 1
                ]);
            } 
            
        } catch (\Exception $e) {
            DB::rollback();
        }

        DB::commit();

        return redirect()->route('users.index')->with('success','Client Created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id     = Crypt::decryptString($id);
        $user = User::find($id);
        $roles = Role::where('name','!=','Super Admin')->get();
        // $roles = Role::pluck('name','name')->where('name','!=','Super Admin')->where('name','!=','Client')->all();
        $userRole = $user->roles[0]->name;
        return view('super_admin.user.edit',compact('user','roles','userRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);
    
        $input = $request->all();
        $input['first_name'] = $input['name'];

        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));    
        }
    
        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
    
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('users.index')
                        ->with('success','User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
