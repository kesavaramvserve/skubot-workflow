<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Website;
use App\Models\WebsiteData;
use App\Models\ClientPrice;
use App\Models\DataHistory;
use App\Models\Note;
use App\Models\User;
use App\Models\Client;
use Response;
use DB;

class SuperAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ops_list    = User::role('PM')->get();
        $datas      = Website::with('getScrapeData','getClient')->orderBy('id','DESC')->paginate(5);
        return view('super_admin.website.index',compact('datas','ops_list')); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('super_admin.website.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $website_id = $request->website_id;
        $ops_id = $request->ops;

        Website::where('id',$website_id)->update([
            'ops_id' => $ops_id,
        ]);

        return redirect()->route('super-admin.index')
                        ->with('success','Operation Assigned successfully');
    }

    public function store_project(Request $request)
    {
        $this->validate($request, [
            'project_name'    => 'required|min:3'
        ],
        [
            'project_name.required' => 'This Project Name field is required',
        ]);
    
        // Date Store
        DB::beginTransaction();
        try {
            $client_id      = 1;
            $user_id        = 2;
            $first_name     = User::where('id',$user_id)->value('first_name');
            $last_name      = User::where('id',$user_id)->value('last_name');
            $email          = User::where('id',$user_id)->value('email');
            $company_name   = Client::where('id',$client_id)->value('company_name');

            $website = Website::create([
                'client_id'         => $client_id,
                'vserve_status'     => 'New',
                'client_status'     => 'New',
                'status'            => 1,
                'enhance_status'    => 1,
                'website'           => $request->project_name,
                'first_name'        => $first_name,
                'last_name'         => $last_name,
                'email'             => $email,
                'company_name'      => $company_name,
                'workflow_settings' => 'single',
                'project_status'    => 1,
                'download_image'    => 1,
                'download_asset'    => 1,
                'time_track'        => 1,
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
                    'client_id'     => $client_id,
                    'website_id'    => $website->id,
                    'content_id'    => $content_id,
                    'range_id'      => $range_id,
                    'price'         => 1
                ]);
            } 
            
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return redirect()->route('super-admin.index')
                        ->with('error','Something went wroung');
        }

        DB::commit();

        return redirect()->route('super-admin.index')
                        ->with('success','Project Added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function manage_content(Request $request)
    {
        $website_id = $request->website_id;
        Website::where('id',$website_id)->update([
            'title_status'          => $request->title_status,
            'description_status'    => $request->description_status,
            'feature_status'        => $request->feature_status,
            'specification_status'  => $request->specification_status,
            'image_status'          => $request->image_status,
        ]);

        return redirect()->back()->with('success','Content Updated successfully');
    }
}
