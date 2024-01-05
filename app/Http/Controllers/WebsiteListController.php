<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WebsiteEnhanceData;
use App\Models\Website;
use App\Models\Client;
use App\Models\User;
use App\Models\ScraperData;
use App\Models\ClientRequestData;
use App\Models\ProjectUser;
use DB;
use DataTables; 
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;

class WebsiteListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user_id    = auth()->user()->id;
        $user_role  = auth()->user()->getrole->name;
        $user_where_id = $user_role.'_id';
        $website_ids = ProjectUser::where('user_id',$user_id)->pluck('website_id');

        if($user_role == 'Client'){
            if(auth()->user()->plan == '$49'){
                $sku_count = 500;
            }else if(auth()->user()->plan == '$249'){
                $sku_count = 5000;
            }else if(auth()->user()->plan == '$699'){
                $sku_count = '5000 - 20k';
            }else{
                $sku_count = '20k';
            }
            $plan = auth()->user()->plan;
            if(auth()->user()->payment_status != 1 && auth()->user()->plan != 'Custom Pricing'){
                return view('client.payment',compact('plan','sku_count'));
            }
            if(auth()->user()->sku_selection_status != 1){
                return view('client.sku_upload',compact('sku_count'));
            }
        }
        if($user_role == 'Scrapper'){
            $user_projects = ProjectUser::where('user_id',$user_id)->where('user_role','!=','Scrapper')->get();
            if(blank($user_projects)){
                $project_role = 'Scrapper';
                $defult_scrapper = true;
                $datas  = ClientRequestData::whereIn('website_id',$website_ids)->orderBy('id','desc')->paginate(10);
                return view('client_file',compact('project_role','datas','defult_scrapper'));
            }
        }

        $other_user_list = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'Team Lead');
        })->whereDoesntHave('roles', function ($query) {
            $query->where('name', 'Client');
        })->whereDoesntHave('roles', function ($query) {
            $query->where('name', 'Operation');
        })->whereDoesntHave('roles', function ($query) {
            $query->where('name', 'Super Admin');
        })->get();
        // if($user_role == 'Team Lead'){
        //     $datas = Website::where('tl_id',$user_id)->paginate(5);
        // }else if($user_role == 'Client'){
        //     if(auth()->user()->plan == '$49'){
        //         $sku_count = 500;
        //     }else if(auth()->user()->plan == '$249'){
        //         $sku_count = 5000;
        //     }else if(auth()->user()->plan == '$699'){
        //         $sku_count = '5000 - 20k';
        //     }else{
        //         $sku_count = '20k';
        //     }
        //     if(auth()->user()->payment_status != 1){
        //         return view('client.payment',compact('sku_count'));
        //     }
        //     if(auth()->user()->sku_selection_status != 1){
        //         return view('client.sku_upload',compact('sku_count'));
        //     }
        //     $client_id = Client::where('user_id',$user_id)->value('id');
        //     $datas = Website::where('user_id',$user_id)->paginate(5);
        // }
        // else{
        //     $datas = WebsiteEnhanceData::with('getWebsite')->select('*')->where($user_where_id , $user_id)->groupBy('website_id')->paginate(5);
        // }
        // return view('website_list',compact('datas'));
        // $website_ids = ProjectUser::where('user_id',$user_id)->pluck('website_id');
        // $data = Website::whereIn('id',$website_ids)->get();

        //     dd($user_id);
        
        if ($request->ajax()) {
            $data = Website::whereIn('id',$website_ids)->orderBy('id','DESC');
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('client_name', function ($data) {
                    $client_name = $data->first_name." ".$data->last_name;
                    return $client_name;
                })
                ->editColumn('client_email', function ($data) {
                    $client_email = $data->getClient->getUser->email;
                    return $client_email;
                })
                ->editColumn('company_name', function ($data) {
                    $company_name = $data->getClient->company_name;
                    return $company_name;
                })
                ->editColumn('role', function ($data) {
                    $role = ProjectUser::where('website_id',$data->id)->where('user_id',auth()->user()->id)->value('user_role');
                    return $role;
                })
                ->editColumn('updated_at', function ($data) {
                    $updated_at = $data->updated_at;
                    return $updated_at;
                })
                ->addColumn('action', function($data){
                        $enc_id = Crypt::encryptString($data->id);
                        $btns = '';
                        $project_role = ProjectUser::where('website_id',$data->id)->where('user_id',auth()->user()->id)->value('user_role');
                        // $select = '<select name="action-select" class="action-select" id="action-select"><option value="">Select</option>';
                        if($project_role == 'Team Lead'){
                            // if(!$data->getClientRequestData){
                            //     //  Import Client File
                            //     $select .= '<option value="import_client_file'.$data->id.'">Import Client File</option>';
                            //     $btns .= '<a href="javascript:void(0)" class="import_client_file action-button" data-id="'. $data->id .'" ><img id="import_client_file'.$data->id.'" src="'.asset('client/images/user.png').'" alt="import_client_file" title="import_client_file"></a>';
                            // }else{
                            //     //  Download Client File
                            //     $select .= '<option value="download_requiremnet_file'.$data->id.'">Download Client File</option>';
                            //     $btns .= '<a href="'.route('download_client_file',$enc_id).'" class="action-button" ><img id="download_requiremnet_file'.$data->id.'" src="'.asset('client/images/download.png').'" alt="download" title="Download Client Requirement"></a>';
                            // }
                            //  Import Client File
                            // $select .= '<option value="import_client_file'.$data->id.'">Import Client File</option>';
                            // $btns .= '<a href="javascript:void(0)" class="import_client_file" data-id="'. $data->id .'" ><img id="import_client_file'.$data->id.'" src="'.asset('client/images/import.png').'" alt="import_client_file" title="import_client_file"></a>';
                            //  Assign Users
                            // $select .= '<option value="assign_users'.$data->id.'">Assign Users</option>';
                            // $btns .= '<a href="javascript:void(0)" class="assign_users" data-id="'. $data->id .'" ><img id="assign_users'.$data->id.'" src="'.asset('client/images/users.png').'" alt="assign_users" title="assign_users"></a>';
                            // Project Aettings
                            // $btns .= '<a href="javascript:void(0)" class="project_settings" 
                            //                 data-id="'. $data->id .'"
                            //                 data-platform="'. $data->platform .'"
                            //                 data-workflow-settings="'. $data->workflow_settings .'"
                            //                 data-platform-details="'. $data->platform_details .'"
                            //                 data-project-status="'. $data->project_status .'" 
                            //                 data-reason="'. $data->reason .'"
                            //                 data-download-image="'. $data->download_image .'"
                            //                 data-download-asset="'. $data->download_asset .'"
                            //                 data-time-track="'. $data->time_track .'"
                            //                 data-project-name="'. $data->website .'" ><img id="project_settings'.$data->id.'" src="'.asset('client/images/setting.png').'" alt="project_settings" title="project_settings"></a>';
                            // if($data->getClientRequestData){
                                // $select .= '<option value="view_client_file'.$data->id.'">View Client File</option>';
                                // $btns .= '<a href="'.route('website_list.view_client_files',$enc_id).'" class="view_client_file" data-id="'. $data->id .'" ><img id="view_client_file'.$data->id.'" src="'.asset('client/images/folder.png').'" alt="view_client_file" title="view_client_file"></a>';
                            // }
                            // if($data->getEnhancedData){
                                // $select .= '<option value="view_client_file'.$data->id.'">View Client File</option>';
                                $btns .= '<a href="'.route('batch_list.show',$enc_id).'" class="view_client_file" data-id="'. $data->id .'" ><img id="view_client_file'.$data->id.'" src="'.asset('client/images/view.png').'" alt="view_menu" title="view_menu"></a>';
                            // }
                        }
                        if($project_role == 'Scrapper'){
                            
                            // if($data->getClientRequestData){
                            //     //  Download Client File
                            //     $select .= '<option value="download_requiremnet_file'.$data->id.'">Download Client File</option>';
                            //     $btns .= '<a href="'.route('download_client_file',$enc_id).'" class="action-button" ><img id="download_requiremnet_file'.$data->id.'" src="'.asset('client/images/download.png').'" alt="download" title="Download Client Requirement"></a>';
                            // }
                            // //  Import Scrapped File
                            // $select .= '<option value="import_scrapped_file'.$data->id.'">Import scrapped File</option>';
                            // $btns .= '<a href="javascript:void(0)" class="import_scrapped_file action-button" data-id="'. $data->id .'" ><img id="import_scrapped_file'.$data->id.'" src="'.asset('client/images/user.png').'" alt="import_scrapped_file" title="import_scrapped_file"></a>';
                            // if($data->getClientRequestData){
                                $btns .= '<a href="'.route('website_list.view_client_files',$enc_id).'" class="view_client_file" data-id="'. $data->id .'" ><img id="view_client_file'.$data->id.'" src="'.asset('client/images/folder.png').'" alt="view_client_file" title="view_client_file"></a>';
                            // }
                        }
                        if($project_role == 'PA' || $project_role == 'QC' || $project_role == 'QA'){
                           
                            if($data->getEnhancedData){
                                // dd($project_role);
                                $btns .= '<a href="'.route('batch_list.show',$enc_id).'" class="view_client_file" data-id="'. $data->id .'" ><img id="view_client_file'.$data->id.'" src="'.asset('client/images/view.png').'" alt="view_menu" title="view_menu"></a>';
                            }
                        }
                        
  
                        // $select .= '</select>';
                        // $select .= $btns;

                        return $btns;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        // if ($request->ajax()) {
        //     if($user_role == 'Team Lead'){ // Team Lead
        //         $data = Website::where('tl_id',$user_id)->get();
        //         return Datatables::of($data)
        //             ->addIndexColumn()
        //             ->editColumn('client_name', function ($data) {
        //                 $client_name = $data->first_name." ".$data->last_name;
        //                 return $client_name;
        //             })
        //             ->editColumn('client_email', function ($data) {
        //                 $client_email = $data->getClient->getUser->email;
        //                 return $client_email;
        //             })
        //             ->editColumn('company_name', function ($data) {
        //                 $company_name = $data->getClient->company_name;
        //                 return $company_name;
        //             })
        //             ->addColumn('action', function($data){
        //                     $enc_id = Crypt::encryptString($data->id);
        //                     $btns = '';
        //                     $select = '<select name="action-select" class="action-select" id="action-select"><option value="">Select</option>';
        //                     if(!blank($data->getWebsiteEnhancedData)){
        //                         // Split SKU's 
        //                         $select .= '<option value="split_sku'.$data->id.'">Split SKU</option>';
        //                         $btns .= '<a href="'.route('split_sku',$enc_id).'" class="action-button" ><img id="split_sku'.$data->id.'" src="'.asset('client/images/split.png').'" alt="Create Batch" title="Create Batch"></a>';
        //                         // Batches
        //                         $select .= '<option value="batch_list'.$data->id.'">Batch List</option>';
        //                         $btns .= '<a href="'.route('batch_list.show',$enc_id).'" class="action-button"><img id="batch_list'.$data->id.'" src="'.asset('client/images/batch.png').'" alt="batch" title="batches"></a>';
        //                     }else{
        //                         $select .= '<option value="import_enhance_data'.$data->id.'">Import Enhance Data</option>';
        //                         $btns .= '<a href="javascript:void(0)" class="enhance-import action-button" data-id="'. $data->id .'"><img id="import_enhance_data'.$data->id.'" src="'.asset('client/images/import.png').'" alt="import" title="Import Enhanced Data"></a>';
        //                     }
      
        //                     $select .= '</select>';
        //                     $select .= $btns;

        //                     return $select;
        //             })
        //             ->rawColumns(['action'])
        //             ->make(true);
        //     }else if($user_role == 'Client'){ // Client
        //         $data = Website::where('user_id',$user_id)->orderBy('id', 'desc');
        //         return Datatables::of($data)
        //             ->addIndexColumn()
        //             ->editColumn('client_name', function ($data) {
        //                 $client_name = $data->first_name." ".$data->last_name;
        //                 return $client_name;
        //             })
        //             ->editColumn('client_email', function ($data) {
        //                 $client_email = $data->getClient->getUser->email;
        //                 return $client_email;
        //             })
        //             ->editColumn('company_name', function ($data) {
        //                 $company_name = $data->getClient->company_name;
        //                 return $company_name;
        //             })
        //             ->addColumn('action', function($data){
        //                     $enc_id = Crypt::encryptString($data->id);
        //                     $btns = '';
        //                     $option = 0;
        //                     $select = '<select name="action-select" class="action-select" id="action-select"><option value="">Select</option>';
        //                     if(!blank($data->getWebsiteData) && blank($data->getClientRequiremnet) && !blank($data->getNotes)){
        //                         $select .= '<option value="view_report'.$data->id.'">View Report</option>';
        //                         $btns .= '<a href="'.route('client',$enc_id).'" class="action-button"><img id="view_report'.$data->id.'" src="'.asset('client/images/view.png').'" alt="Scrape Report" title="Scrape Report"></a>';
        //                         $option = $option + 1;
        //                     }elseif(!blank($data->getClientRequiremnet)){
        //                         $select .= '<option value="batches'.$data->id.'">Batches</option>';
        //                         $btns .= '<a href="'.route('batch_list.show',$enc_id).'" class="action-button"><img id="batches'.$data->id.'" src="'.asset('client/images/batch.png').'" alt="batch" title="batches"></a>';
        //                         $option = $option + 1;
        //                     }

        //                     $select .= '</select>';
        //                     $select .= $btns;

        //                     if($option > 0){
        //                         return $select;
        //                     }
                            
        //             })
        //             ->filter(function ($instance) use ($request) {
        //                 if (!empty($request->get('search'))) {
        //                      $instance->where(function($w) use($request){
        //                         $search = $request->get('search');
        //                         $w->orWhere('website', 'LIKE', "%$search%");                                
        //                     });
        //                 }
        //                 if (!empty($request->get('show'))) {
        //                     $instance->where(function($w) use($request){
        //                        $show = $request->get('show');
        //                        $w->limit($show);                                
        //                    });
        //                }
        //             })
        //             ->rawColumns(['action'])
        //             ->make(true);
        //     }else{ // Others
        //         $data = WebsiteEnhanceData::with('getWebsite')->select('*')->where($user_where_id , $user_id)->groupBy('website_id')->get();
        //         return Datatables::of($data)
        //             ->addIndexColumn()
        //             ->editColumn('client_name', function ($data) {
        //                 $client_name = $data->getWebsite->first_name;
        //                 return $client_name;
        //             })
        //             ->editColumn('client_email', function ($data) {
        //                 $client_email = $data->getWebsite->email;
        //                 return $client_email;
        //             })
        //             ->editColumn('company_name', function ($data) {
        //                 $company_name = $data->getWebsite->company_name;
        //                 return $company_name;
        //             })
        //             ->editColumn('website', function ($data) {
        //                 $website = $data->getWebsite->website;
        //                 return $website;
        //             })
        //             ->addColumn('action', function($data){
        //                     $enc_id = Crypt::encryptString($data->website_id);
        //                     $btns = '';
        //                     $select = '<select name="action-select" class="action-select" id="action-select"><option value="">Select</option>';
        //                     // Batches
        //                     $select .= '<option value="batches'.$data->id.'">Batches</option>';
        //                     $btns .= '<a href="'.route('batch_list.show',$enc_id).'" class="action-button" data-id="'. $data->website_id .'"><img id="batches'.$data->id.'" src="'.asset('client/images/batch.png').'" alt="batch" title="batches"></a>';
        //                     // Upload Enhance Data
        //                     $select .= '<option value="import_enhance_data'.$data->id.'">Import Enhance Data</option>';
        //                     $btns .= '<a href="'.route('batch_list.create').'" class="action-button" data-id=""><img id="import_enhance_data'.$data->id.'" src="'.asset('client/images/import.png').'" alt="import" title="Import Enhanced Data"></a>';
      
        //                     $select .= '</select>';
        //                     $select .= $btns;

        //                     return $select;
        //             })
        //             ->rawColumns(['action'])
        //             ->make(true);
        //     }
        // }
        
        return view('website_list',compact('other_user_list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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

    public function import_client_file(Request $request)
    {
        $this->validate($request, [
            'file' => 'required',
        ]);

        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        $filename = uniqid().'.'.$extension;

        $destinationPath = 'client-sku-files';
        $file->move($destinationPath,$filename);

        $scraper = ClientRequestData::create([
            'website_id'        => $request->website_id,
            'notes'             => $request->notes,
            'path'              => $filename,
        ]);

        return redirect()->back()->with('success','Client File Uploaded successfully');
    }

    public function download_client_file($id)
    {
        if(!empty($request->website_id)){
            $website_id = $request->id;
        }else{
            $website_id = Crypt::decryptString($id);
        }

        $data = Website::with('getClientRequestData')->where('id',$website_id)->get();

        $file_name = $data[0]->getClientRequestData->path;
        $file = public_path(). '/client-sku-files/'.$file_name;

        return response()->download($file, $file_name, ['content-type' => 'text/cvs']);
        
    }

    public function assign_users(Request $request)
    {
        // dd($request);
        $website_id = $request->website_id;
        
        // Assign Scrapper
        if(!blank($request->scrapper)){

            $scrapper_ids = $request->scrapper;
            $exist_data = ProjectUser::where('website_id',$website_id)->where('user_role','Scrapper')->get();

            if(!blank($exist_data)){
                ProjectUser::where('website_id',$website_id)->where('user_role','Scrapper')->delete();
            }

            foreach($scrapper_ids as $scrapper_id){
                $data = ProjectUser::create([
                    'website_id'=> $website_id,
                    'user_role' => 'Scrapper',
                    'user_id'   => $scrapper_id,
                ]);
            }

        }

        // Assign PA
        if(!blank($request->pa)){

            $pa_ids = $request->pa;
            $exist_data = ProjectUser::where('website_id',$website_id)->where('user_role','PA')->get();

            if(!blank($exist_data)){
                ProjectUser::where('website_id',$website_id)->where('user_role','PA')->delete();
            }

            foreach($pa_ids as $pa_id){
                $data = ProjectUser::create([
                    'website_id'=> $website_id,
                    'user_role' => 'PA',
                    'user_id'   => $pa_id,
                ]);
            }

        }

        // Assign Qc
        if(!blank($request->qc)){

            $qc_ids = $request->qc;
            $exist_data = ProjectUser::where('website_id',$website_id)->where('user_role','QC')->get();

            if(!blank($exist_data)){
                ProjectUser::where('website_id',$website_id)->where('user_role','QC')->delete();
            }

            foreach($qc_ids as $qc_id){
                $data = ProjectUser::create([
                    'website_id'=> $website_id,
                    'user_role' => 'QC',
                    'user_id'   => $qc_id,
                ]);
            }

        }

        // Assign QA
        if(!blank($request->qa)){

            $qa_ids = $request->qa;
            $exist_data = ProjectUser::where('website_id',$website_id)->where('user_role','QA')->get();

            if(!blank($exist_data)){
                ProjectUser::where('website_id',$website_id)->where('user_role','QA')->delete();
            }

            foreach($qa_ids as $qa_id){
                $data = ProjectUser::create([
                    'website_id'=> $website_id,
                    'user_role' => 'QA',
                    'user_id'   => $qa_id,
                ]);
            }

        }
        
       
        return redirect()->back()->with('success','Users Assigned successfully');
       
        
    }

    public function assign_file_users(Request $request)
    {
        $website_id = $request->website_id;
        $file_id    = $request->file_id;
        
        // Assign File to Scrapper
        if(!blank($request->scrapper)){

            $scrapper_ids = $request->scrapper;
            $exist_data = ProjectUser::where('website_id',$website_id)->where('user_role','Scrapper')->get();

            if(!blank($exist_data)){
                ProjectUser::where('website_id',$website_id)->where('user_role','Scrapper')->update([
                    'client_file_id' => null, 
                ]);
            }

            foreach($scrapper_ids as $scrapper_id){
                ProjectUser::where('website_id',$website_id)->where('user_role','Scrapper')->where('user_id',$scrapper_id)->update([
                    'client_file_id' => $file_id,
                ]);
            }

        }

        // Assign File to PA
        if(!blank($request->pa)){

            $pa_ids = $request->pa;
            $exist_data = ProjectUser::where('website_id',$website_id)->where('user_role','PA')->get();

            if(!blank($exist_data)){
                ProjectUser::where('website_id',$website_id)->where('user_role','PA')->update([
                    'client_file_id' => null, 
                ]);
            }

            foreach($pa_ids as $pa_id){
                ProjectUser::where('website_id',$website_id)->where('user_role','PA')->where('user_id',$pa_id)->update([
                    'client_file_id' => $file_id,
                ]);
            }

        }

        // Assign File to QC
        if(!blank($request->qc)){

            $qc_ids = $request->qc;
            $exist_data = ProjectUser::where('website_id',$website_id)->where('user_role','QC')->get();

            if(!blank($exist_data)){
                ProjectUser::where('website_id',$website_id)->where('user_role','QC')->update([
                    'client_file_id' => null, 
                ]);
            }

            foreach($qc_ids as $qc_id){
                ProjectUser::where('website_id',$website_id)->where('user_role','QC')->where('user_id',$qc_id)->update([
                    'client_file_id' => $file_id,
                ]);
            }

        }

        // Assign File to QA
        if(!blank($request->qa)){

            $qa_ids = $request->qa;
            $exist_data = ProjectUser::where('website_id',$website_id)->where('user_role','QA')->get();

            if(!blank($exist_data)){
                ProjectUser::where('website_id',$website_id)->where('user_role','QA')->update([
                    'client_file_id' => null, 
                ]);
            }

            foreach($qa_ids as $qa_id){
                ProjectUser::where('website_id',$website_id)->where('user_role','QA')->where('user_id',$qa_id)->update([
                    'client_file_id' => $file_id,
                ]);
            }

        }        
        $enc_id = Crypt::encryptString($website_id);
        return redirect()->route('website_list.view_client_files',$enc_id)->with('success','Users Assigned successfully');
       
        
    }

    public function view_client_files($id)
    {
        $user_id            = auth()->user()->id;
        $website_id         = Crypt::decryptString($id);
        $datas              = ClientRequestData::where('website_id',$website_id)->paginate(10);
        $project_name       = Website::where('id',$website_id)->value('website');
        $project_role       = ProjectUser::where('website_id',$website_id)->where('user_id',$user_id)->value('user_role');
        $scrapper_user_id   = Projectuser::where('website_id',$website_id)->where('user_role','Scrapper')->pluck('user_id');
        $pa_user_id         = Projectuser::where('website_id',$website_id)->where('user_role','PA')->pluck('user_id');
        $qc_user_id         = Projectuser::where('website_id',$website_id)->where('user_role','QC')->pluck('user_id');
        $qa_user_id         = Projectuser::where('website_id',$website_id)->where('user_role','QA')->pluck('user_id');
        $scrapper_list      = User::whereIn('id', $scrapper_user_id)->get();
        $pa_list            = User::whereIn('id', $pa_user_id)->get();
        $qc_list            = User::whereIn('id', $qc_user_id)->get();
        $qa_list            = User::whereIn('id', $qa_user_id)->get();
        $defult_scrapper    = false;
        
        return view('client_file',compact('defult_scrapper','project_role','datas','project_name','scrapper_list','pa_list','qc_list','qa_list','website_id'));
    }

}
