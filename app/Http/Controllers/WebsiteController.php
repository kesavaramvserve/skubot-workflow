<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Website;
use App\Models\Note;
use App\Models\ClientPrice;
use App\Models\Client;
use App\Models\User;
use App\Models\WebsiteData;
use App\Models\DataHistory;
use App\Models\ProjectUser;
use Response;
use DB;
use DataTables;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use App\Exports\CommonSkuExport;
use Excel;
use Illuminate\Support\Collection;

class WebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // if($request->order_by == 'website' || $request->order_by == 'created_at'){
        //     $datas = Website::orderBy($request->order_by,$request->order_type)->paginate(5);
        //     return view('website.index',compact('datas')); 
        // }elseif($request->order_by == 'company_name'){
        //     $order_type = $request->order_type;
        //     $datas = Website::with(['getClient' => function($query){
        //           $query->orderBy('company_name','DESC');
        //       }])->paginate(5);
        //     return view('website.index',compact('datas'));
        // }else{
        //     $datas = Website::orderBy('id','DESC')->paginate(5);
        //     return view('website.index',compact('datas')); 
        // }
        $team_lead_list = User::role('Team Lead')->get();
        $other_user_list = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'Team Lead');
        })->whereDoesntHave('roles', function ($query) {
            $query->where('name', 'Client');
        })->whereDoesntHave('roles', function ($query) {
            $query->where('name', 'Operation');
        })->whereDoesntHave('roles', function ($query) {
            $query->where('name', 'Super Admin');
        })->get();
        $team_lead_list = $team_lead_list->merge($other_user_list);

        if ($request->ajax()) {
            $data = Website::select('*');
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
                    
                    ->editColumn('import_status', function ($data) {
                        if($data->getCronStatus){
                            if($data->getCronStatus->status==0)
                                $import_status = 'New';
                            elseif($data->getCronStatus->status==1)
                                $import_status = 'In Progress';
                            elseif($data->getCronStatus->status==2)
                                $import_status = 'Imported';
                            elseif($data->getCronStatus->status==3)
                                $import_status = 'In Issue';
                        }
                        else{
                            $import_status = '-';
                        }
                            
                        return $import_status;
                    })
                    ->editColumn('validation_status', function ($data) {
                        if($data->validation_status != null){
                            if($data->validation_status == 'Valid'){
                                $validation_status = '<span class="badge bg-success">Valid</span>';
                            }else{
                                $validation_status = '<span class="badge bg-danger">Invalid</span>';
                            }
                        }
                        else{
                            $validation_status = '-';
                        }                            
                        return $validation_status;
                    })
                    ->editColumn('data_history', function ($data) {
                        $data_history = '<a href="javascript:void(0)" class="data-history" data-id="'. $data->id .'"><img src="'.asset('images/view.png').'" alt="Data History" title="Data History"></a>';
                        return $data_history;
                    })
                    ->editColumn('created_at', function ($data) {
                        $created_at = date('d-m-Y h:i:s A', strtotime($data->created_at));
                        return $created_at;
                    })
                    ->addColumn('action', function($data){
                            $enc_id = Crypt::encryptString($data->id);
                            $btns = '';
                            $select = '<select name="action-select" class="action-select" id="action-select"><option value="">Select</option>';
                            if($data->status == 1 && $data->enhance_status == 0){   
                                // Set Price 
                                $select .= '<option value="set_price'.$data->id.'">Set Price</option>';
                                $btns .= '<a href="' . route('support.show', $enc_id) . '" class="action-button" ><img id="set_price'.$data->id.'" src="' . asset('client/images/price.png') . '" alt="price" title="Set Price"></a>';
                                // $btns .= '<a href="javascript:void(0)" class="import" data-id="'. $data->id .'"><img src="'.asset('client/images/import.png').'" alt="import" title="Import Scraped Data"></a>';
                                //  Upload Scrap File
                                if(blank($data->getScrapeData)){
                                    $select .= '<option value="upload_scrape_file'.$data->id.'">Upload Scrape File</option>';
                                    $btns .= '<a href="javascript:void(0)" class="upload action-button"  data-id="'. $data->id .'"><img id="upload_scrape_file'.$data->id.'" src="'.asset('client/images/import.png').'" alt="Upload" title="Upload Scraped Data"></a>';
                                }else{
                                    $select .= '<option value="download_scrape_file'.$data->id.'">Download Scrape File</option>';
                                    $btns .= '<a href="'.asset('scraper-data/'.$data->getScrapeData->path).'" class="action-button" ><img id="download_scrape_file'.$data->id.'" src="'.asset('client/images/download.png').'" alt="download" title="Download Scraped Data"></a>';
                                }
                                //  Clent View
                                if(!blank($data->getWebsiteData)){
                                    $select .= '<option value="view_report'.$data->id.'">View Report</option>';
                                    $btns .= '<a href="'.route('set_range',$enc_id).'" class="action-button" ><img id="view_report'.$data->id.'" src="'.asset('client/images/view.png').'" alt="view" title="view"></a>';
                                    // // Assign TL
                                    // $btns .= '<a href="javascript:void(0)" class="assign_tl" data-id="'. $data->id .'" data-tl-id="'. $data->tl_id .'" ><img src="'.asset('client/images/user.png').'" alt="Assign TL" title="Assign TL"></a>';
                                }
                                
                                if(!blank($data->getClientRequiremnet)){
                                    if(!blank($data->getClientRequestData)){
                                        //  Download Client Selected SKUs File
                                        $select .= '<option value="download_requiremnet_file'.$data->id.'">Download Requiremnet File</option>';
                                        $btns .= '<a href="'.route('download_client_data',$enc_id).'" class="action-button" ><img id="download_requiremnet_file'.$data->id.'" src="'.asset('client/images/download.png').'" alt="download" title="Download Client Requirement"></a>';
                                        // $btns .= '<a href="javascript:void(0)" class="enhance-import" data-id="'. $data->id .'"><img src="'.asset('client/images/import.png').'" alt="import" title="Import Enhanced Data"></a>';
                                        // Assign TL
                                        $select .= '<option value="assign_tl'.$data->id.'">Assign TL</option>';
                                        $btns .= '<a href="javascript:void(0)" class="assign_tl action-button" data-id="'. $data->id .'" data-tl-id="'. $data->tl_id .'" ><img id="assign_tl'.$data->id.'" src="'.asset('client/images/user.png').'" alt="Assign TL" title="Assign TL"></a>';
                                        if(!blank($data->getWebsiteEnhancedData)){
                                            // $btns .= '<a href="'.route('enhance_result',$enc_id).'" ><img src="'.asset('client/images/view.png').'" alt="view" title="view"></a>';
                                        }
                                    }
                                }
                                if($data->parent_id == null){
                                    $select .= '<option value="add_more'.$data->id.'">Add More</option>';
                                    $btns .= '<a href="javascript:void(0)" class="add_more action-button"  data-id="'. $data->id .'"><img id="add_more'.$data->id.'" src="'.asset('client/images/add-more.png').'" alt="Add More" title="Add More"></a>';
                                }
                                
                            }
                            else if($data->enhance_status == 1){
                                // Assign TL
                                $select .= '<option value="assign_tl'.$data->id.'">Assign TL</option>';
                                $btns .= '<a href="javascript:void(0)" class="assign_tl action-button" data-id="'. $data->id .'" data-tl-id="'. $data->tl_id .'" ><img id="assign_tl'.$data->id.'" src="'.asset('client/images/user.png').'" alt="Assign TL" title="Assign TL"></a>';
                                // Project Settings
                                $select .= '<option value="project_settings'.$data->id.'">Project Settings</option>';
                                $btns .= '<a href="javascript:void(0)" class="project_settings action-button" 
                                            data-id="'. $data->id .'"
                                            data-platform="'. $data->platform .'"
                                            data-workflow-settings="'. $data->workflow_settings .'"
                                            data-platform-details="'. $data->platform_details .'"
                                            data-project-status="'. $data->project_status .'" 
                                            data-reason="'. $data->reason .'"
                                            data-download-image="'. $data->download_image .'"
                                            data-download-asset="'. $data->download_asset .'"
                                            data-time-track="'. $data->time_track .'"
                                            data-project-name="'. $data->website .'" ><img id="project_settings'.$data->id.'" src="'.asset('client/images/user.png').'" alt="project_settings" title="project_settings"></a>';
                            }
                            else{
                                $select .= '<option value="validate_site'.$data->id.'">Validate Site</option>';
                                $btns .= '<a href="javascript:void(0)" class="validate action-button"  data-id="'. $data->id .'" data-vs="'. $data->validation_status .'" data-remark="'. $data->remark .'"><img id="validate_site'.$data->id.'" src="'.asset('client/images/validate.png').'" alt="Valiate" title="Valiate"></a>';
                            }

                            $select .= '</select>';
                            $select .= $btns;
      
                            return $select;
                    })
                    ->filter(function ($instance) use ($request) {
                        if (!empty($request->get('search'))) {
                             $instance->where(function($w) use($request){
                                $search = $request->get('search');
                                $search_type = $request->get('search_type_filter');

                                if(!empty($search_type)){ // Particular column search
                                    if($search_type=='client_name'){
                                        $user_table = User::where('first_name', 'LIKE', "%$search%")->orWhere('last_name', 'LIKE', "%$search%")->get();
                                        if(!blank($user_table)){
                                            foreach($user_table as $user_tables){
                                                $w->orWhere('user_id',$user_tables->id);
                                            }
                                        }else{
                                            $w->orWhere('user_id',0);
                                        }
                                    }
                                    if($search_type=='client_email'){
                                        $user_table = User::where('email', 'LIKE', "%$search%")->get();
                                        if(!blank($user_table)){
                                            foreach($user_table as $user_tables){
                                                $w->orWhere('user_id',$user_tables->id);
                                            }
                                        }else{
                                            $w->orWhere('user_id',0);
                                        }
                                    }
                                    if($search_type=='company_name'){
                                        $client_table = Client::where('company_name', 'LIKE', "%$search%")->get();
                                        if(!blank($client_table)){
                                            foreach($client_table as $client_tables){
                                                $w->orWhere('client_id',$client_tables->id);
                                            }
                                        }else{
                                            $w->orWhere('client_id',0);
                                        }
                                    }
                                    if($search_type=='website'){
                                        $w->orWhere('website', 'LIKE', "%$search%");
                                    }
                                }else{ // All search
                                    $client_table = Client::Where('company_name', 'LIKE', "%$search%")->get();
                                    $user_table = User::Where('first_name', 'LIKE', "%$search%")->orWhere('last_name', 'LIKE', "%$search%")->orWhere('email', 'LIKE', "%$search%")->get();
                                    if(!blank($client_table)){
                                        foreach($client_table as $client_tables){
                                            $w->orWhere('client_id',$client_tables->id);
                                        }
                                    }elseif(!blank($user_table)){
                                        foreach($user_table as $user_tables){
                                            $w->orWhere('user_id',$user_tables->id);
                                        }
                                    }else{
                                        $w->orWhere('website', 'LIKE', "%$search%");
                                    }
                                }
                                
                            });
                        }
                        if (!empty($request->get('validation_status_filter'))) {
                            $instance->where(function($w) use($request){
                                $validation_status = $request->get('validation_status_filter');
                                $w->orWhere('validation_status',$validation_status);
                            });
                        }
                        if (!empty($request->get('show'))) {
                            $instance->where(function($w) use($request){
                                $show = $request->get('show');
                                $w->limit($show);
                            });
                        }
                    })
                    
                    // ->orderColumn('company_name', function ($query, $order) {
                        // dd($order);
                        // $client_table = Client::orderBy('company_name',$order)->get();
                        // foreach($client_table as $client_tables){
                        //     $query->orWhere('client_id',$client_tables->id);
                        // }
                        // $query->with(['getClient' => function($query) use ($order) {
                        //     $query->orderBy('company_name',$order);
                        // }]);
                        // $query->where(function($w) use($order){
                        //     $client_table = Client::orderBy('company_name',$order)->get();
                        //     foreach($client_table as $client_tables){
                        //         $w->orWhere('client_id',$client_tables->id);
                        //     }
                        // });
                    // })
                    ->rawColumns(['action','validation_status','data_history'])
                    ->make(true);
        }

        return view('website.index',compact('team_lead_list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('website.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'website_name' => 'required|min:3',
        ]);
        
        Website::create([
            'website_name' => $request->website_name,
            'description'  => $request->description
        ]);

        return redirect()->route('website.index');
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
        //
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
        //
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

    public function data_history(Request $request)
    {
        $website_id = $request->id;
        $data = DataHistory::where('website_id',$website_id)->get();
        return Response::json($data);
    }
    public function save_notes(Request $request)
    {
        // dd($request);
        $website_id             = $request->website_id;
        $internal_notes         = $request->internal_notes;
        $client_notes           = $request->client_notes;
        $title_notes            = $request->title_notes;
        $description_notes      = $request->description_notes;
        $feature_notes          = $request->feature_notes;
        $specification_notes    = $request->specification_notes;
        $image_notes            = $request->image_notes;
        $overall_notes          = $request->overall_notes;

        $data  = Note::where('website_id',$website_id)->get();

        if(blank($data)){
            $notes = Note::create([
                'website_id'            => $website_id,
                'internal_notes'        => $internal_notes,
                'client_notes'          => $client_notes,
                'title_notes'           => $title_notes,
                'description_notes'     => $description_notes,
                'feature_notes'         => $feature_notes,
                'specification_notes'   => $specification_notes,
                'image_notes'           => $image_notes,
                'overall_notes'         => $overall_notes,
            ]);
        }else{
            $notes = Note::where('website_id',$website_id)->update([
                'internal_notes'        => $internal_notes,
                'client_notes'          => $client_notes,
                'title_notes'           => $title_notes,
                'description_notes'     => $description_notes,
                'feature_notes'         => $feature_notes,
                'specification_notes'   => $specification_notes,
                'image_notes'           => $image_notes,
                'overall_notes'         => $overall_notes,
            ]);
        }

        return redirect()->back();
    }
    
    public function data_import()
    {
        \Artisan::call('schedule:run');
    }

    public function validate_website(Request $request)
    {
        $website_id         = $request->website_id;
        $validation_status  = $request->validation_status;
        $remark             = $request->remark;

        if($validation_status == 'Valid'){
            Website::where('id',$website_id)->update([
                'status'            => 1,
                'validation_status' => $validation_status,
                'remark'            => $remark,
            ]);
        }elseif($validation_status == 'Invalid'){
            Website::where('id',$website_id)->update([
                'status'            => 2,
                'validation_status' => $validation_status,
                'remark'            => $remark,
            ]);
        }
        // Add Data History
        $user_id = auth()->user()->id;
        $data_history = DataHistory::create([
            'user_id'       => $user_id,
            'website_id'    => $website_id,
            'action'        => 'Site Validated'
        ]);
        return redirect()->route('website.index')->with('success','Website details updated Successfully');
    }


    public function add_more(Request $request)
    {
        $website_id     = $request->website_id;
        $website        = $request->website;
        $parent_data    = Website::where('id',$website_id)->get();
        $user_id        = auth()->user()->id;

        DB::beginTransaction();
        try {
            // Insert Data Into website Table
            $website = Website::create([
                'user_id'           => $parent_data[0]->user_id,
                'client_id'         => $parent_data[0]->client_id,
                'first_name'        => $parent_data[0]->first_name,
                'last_name'         => $parent_data[0]->last_name,
                'company_email'     => $parent_data[0]->company_email,
                'company_name'      => $parent_data[0]->company_name,
                'website'           => $website,
                'status'            => 1,
                'validation_status' => 'Valid',
                'parent_id'         => $website_id,
            ]);

            // Set Default Price
            $content_id = 1;
            $range_id = 0;
            $price = 6;
            for($i=1;$i<=25;$i++){
                $range_id++;
                $price--;
                if($i==6 || $i==11 || $i==16 || $i==21 || $i==26){
                    $content_id++;
                    $range_id = 1;
                    $price = 5;
                }
                $client_price = ClientPrice::create([
                    'client_id'     => $parent_data[0]->client_id,
                    'website_id'    => $website->id,
                    'content_id'    => $content_id,
                    'range_id'      => $range_id,
                    'price'         => $price
                ]);
            }   

            // Add Data History
            $data_history = DataHistory::create([
                'user_id'       => $user_id,
                'website_id'    => $website->id,
                'action'        => 'Added New website'
            ]);
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('website.index')->with('error','Something went Wrong');
            DB::rollback();
        }

        DB::commit();

        return redirect()->route('website.index')->with('success','New Website Added Successfully');
    }

    public function add_data_history(Request $request)
    {
        $website_id = $request->id;
        // Add Data History
        $data = DataHistory::create([
            'website_id'    => $website_id,
            'action'        => 'Client Downloaded the enhanced data'
        ]);
        return Response::json($data);
    }
    
    public function assign_tl(Request $request)
    {
        // dd($request);
        $website_id = $request->website_id;
        $tl_id = $request->tl;

        $exist_data = ProjectUser::where('website_id',$website_id)->where('user_role','Team Lead')->get();

        if(!blank($exist_data)){
            $data = ProjectUser::where('website_id',$website_id)->where('user_role','Team Lead')->update([
                'user_id'   => $tl_id,
            ]);
        }else{
            $data = ProjectUser::create([
                'website_id'=> $website_id,
                'user_role' => 'Team Lead',
                'user_id'   => $tl_id,
            ]);
        }
        
        // $data = Website::where('id',$website_id)->update([
        //     'tl_id'             => $tl_id,
        //     'tl_assigned_at'    => Carbon::now(),
        // ]);
        // WebsiteData::where('website_id',$website_id)->update([
        //     'tl_id' => $tl_id,
        // ]);
        // dd($website_id);
        if($data){
            return redirect()->route('website.index')->with('success','TL Assigned successfully');
        }else{
            return redirect()->route('website.index')->with('error','Something Went Wrong');
        }
        
    }

    public function common_sku_export($id){
        $data_arr = explode("_",$id);
        $range = $data_arr[0];
        $website_id = $data_arr[1];
        
        $filename = uniqid().'.xlsx';
        return Excel::download(new CommonSkuExport($range,$website_id),$filename, \Maatwebsite\Excel\Excel::XLSX);
    }

    public function project_settings(Request $request)
    {
        // dd($request);
        Website::where('id',$request->website_id)->update([
            'platform'          => $request->platform,
            'platform_details'  => $request->platform_details,
            'workflow_settings' => $request->workflow_settings,
            'project_status'    => $request->project_status,
            'reason'            => $request->reason,
            'download_image'    => $request->download_image,
            'download_asset'    => $request->download_asset,
            'time_track'        => $request->time_track,
        ]);

        return redirect()->back()->with('success','Project Settings Updated Successfully');
    }

    public function get_scrapper_list(Request $request)
    {
        if($request->key1){
            $client_file_id = $request->key1;
            $website_id     = $request->key2;
            $data           = ProjectUser::where('website_id',$website_id)->where('user_role','Scrapper')->where('client_file_id',$client_file_id)->pluck('user_id');
        }else{
            $website_id     = $request->key2;
            $data           = ProjectUser::where('website_id',$website_id)->where('user_role','Scrapper')->pluck('user_id');
        }
        return response()->json($data);
    }

    public function get_pa_list(Request $request)
    {
        if($request->key1){
            $client_file_id = $request->key1;
            $website_id     = $request->key2;
            $data           = ProjectUser::where('website_id',$website_id)->where('user_role','PA')->where('client_file_id',$client_file_id)->pluck('user_id');
        }else{
            $website_id     = $request->key2;
            $data           = ProjectUser::where('website_id',$website_id)->where('user_role','PA')->pluck('user_id');
        }
        return response()->json($data);
    }

    public function get_qc_list(Request $request)
    {
        if($request->key1){
            $client_file_id = $request->key1;
            $website_id     = $request->key2;
            $data           = ProjectUser::where('website_id',$website_id)->where('user_role','QC')->where('client_file_id',$client_file_id)->pluck('user_id');
        }else{
            $website_id     = $request->key2;
            $data           = ProjectUser::where('website_id',$website_id)->where('user_role','QC')->pluck('user_id');
        }
        return response()->json($data);
    }

    public function get_qa_list(Request $request)
    {
        if($request->key1){
            $client_file_id = $request->key1;
            $website_id     = $request->key2;
            $data           = ProjectUser::where('website_id',$website_id)->where('user_role','QA')->where('client_file_id',$client_file_id)->pluck('user_id');
        }else{
            $website_id     = $request->key2;
            $data           = ProjectUser::where('website_id',$website_id)->where('user_role','QA')->pluck('user_id');
        }
        return response()->json($data);
    }
    
}
