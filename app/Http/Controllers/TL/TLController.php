<?php

namespace App\Http\Controllers\TL;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Website;
use App\Models\User;
use App\Models\ProjectUser;
use App\Models\WebsiteEnhanceData;
use App\Models\WebsiteFeature;
use App\Models\WebsiteSpecification;
use App\Models\WebsiteImage;
use App\Models\WebsiteEnhanceFeature;
use App\Models\WebsiteEnhanceSpecification;
use App\Models\WebsiteEnhanceImage;
use Illuminate\Support\Facades\Crypt;
use DB;
use Carbon\Carbon;

class TLController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tl_id = auth()->user()->id;
        $datas = Website::where('tl_id',$tl_id)->paginate(5);
        return view('tl.dashboard',compact('datas'));
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

    public function split_sku(Request $request, $id)
    {
        if(!empty($request->website_id)){
            $website_id = Crypt::decryptString($request->id);
        }else{
            $website_id = Crypt::decryptString($id);
        }
        if($request->split_type == 'brand'){
            $split_type = 'brand';
            $datas = WebsiteEnhanceData::select('brand', DB::raw('count(*) as total'))->where('website_id',$website_id)->where('batch_id',null)->orderBy('total', 'desc')->groupBy('brand')->get();
        }else{
            $split_type = 'category';
            $datas = WebsiteEnhanceData::select('category', DB::raw('count(*) as total'))->where('website_id',$website_id)->where('batch_id',null)->orderBy('total', 'desc')->groupBy('category')->get();
        }
        
        return view('tl.split_sku',compact('datas','split_type','website_id'));
    }

    public function create_batch(Request $request)
    {
        $split_type = $request->split_type;
        $website_id = $request->website_id;
        $batch      = $request->batch;
        if($split_type == 'category'){
            foreach($batch as $batchs){
                $batch_id = time();
                WebsiteEnhanceData::where('website_id',$website_id)->where('category',$batchs)->update([
                    'batch_id'      => $batch_id,
                    'supplier_type' => $batchs,
                ]);
            }
        }else{
            foreach($batch as $batchs){
                $batch_id = time();
                WebsiteEnhanceData::where('website_id',$website_id)->where('brand',$batchs)->update([
                    'batch_id'      => $batch_id,
                    'supplier_type' => $batchs,
                ]);
            }
        }

        return redirect()->back()->with('success','Batch Created Successfully!');
    }

    public function batches(Request $request, $id)
    {
        if(!empty($request->website_id)){
            $website_id = Crypt::decryptString($request->id);
        }else{
            $website_id = Crypt::decryptString($id);
        }
        $tl_id = auth()->user()->id;
        $datas = WebsiteEnhanceData::with('getTL','getPA','getQC','getDA','getQA')->select('*','batch_id', DB::raw('count(*) as total'))->where('website_id',$website_id)->where('batch_id','!=',null)->orderBy('total', 'desc')->groupBy('batch_id')->get();
        $pa_lists = User::where('tl_id',$tl_id)->role('PA')->get();
        $qc_lists = User::where('tl_id',$tl_id)->role('QC')->get();
        $da_lists = User::where('tl_id',$tl_id)->role('DA')->get();
        $qa_lists = User::where('tl_id',$tl_id)->role('QA')->get();
        // dd($datas);
        return view('tl.batches',compact('datas','pa_lists','qc_lists','da_lists','qa_lists','website_id'));
    }

    public function unassign_batches(Request $request, $id)
    {
        if(!empty($request->website_id)){
            $website_id = Crypt::decryptString($request->id);
        }else{
            $website_id = Crypt::decryptString($id);
        }
        $tl_id = auth()->user()->id;
        $datas = WebsiteEnhanceData::select('batch_id', DB::raw('count(*) as total'))->where('website_id',$website_id)->where('pa_id','!=',null)->where('batch_id','!=',null)->orderBy('total', 'desc')->groupBy('batch_id')->get();
        $pa_lists = User::where('tl_id',$tl_id)->role('PA')->get();
        $qc_lists = User::where('tl_id',$tl_id)->role('QC')->get();
        $da_lists = User::where('tl_id',$tl_id)->role('DA')->get();
        $qa_lists = User::where('tl_id',$tl_id)->role('QA')->get();
        return view('tl.unassign_batches',compact('datas','pa_lists','qc_lists','da_lists','qa_lists','website_id'));
    }

    public function split_skus(Request $request)
    {
        $batch_id       = $request->batch_id;
        $split_count    = $request->split_count;
        $datas = WebsiteEnhanceData::where('batch_id',$batch_id)->take($split_count)->get();
        $update_batch_id = time();
        foreach($datas as $data){
            WebsiteEnhanceData::where('id',$data->id)->update([
                'batch_id' => $update_batch_id,
            ]);
        }
        return redirect()->back()->with('success','Batch Splitted Successfully!');
    }

    public function single_assign_users(Request $request)
    {
        // dd($request);
        $batchs         = $request->batch;
        $website_id     = $request->website_id;
        $website_name   = Website::where('id',$website_id)->value('website');
        $user_id        = auth()->user()->id;
        $workflow       = $request->workflow;
        $status         = $request->batch_status;
        $pa_id          = $request->pa_id;
        $qc_id          = $request->qc_id;
        $da_id          = $request->da_id;
        $qa_id          = $request->qa_id;
        $sku_count          = "";

        if($workflow == 'bulk'){
            foreach($batchs as $batch){

                if($request->pa_id){
                    // Assign PA
                    if($status == 'inqueue'){
                        $res = WebsiteEnhanceData::where('batch_id',$batch)->where('pa_done',null)->update([
                            'pa_id'             => $pa_id,
                            'pa_done'           => 0,
                            'pa_assigned_at'    => Carbon::now(),
                        ]);
                    }
                    // Re-Assign PA
                    if($status == 'inprogress'){
                        $res = WebsiteEnhanceData::where('batch_id',$batch)->where('pa_done',0)->update([
                            'pa_id'             => $pa_id,
                            'pa_assigned_at'    => Carbon::now(),
                        ]);
                    }
                }
    
                if($request->qc_id){
                    // WebsiteEnhanceData::where('batch_id',$batch)->where('qc_done','!=',1)->update([
                    //     'qc_id'             => $qc_id,
                    //     'qc_assigned_at'    => Carbon::now(),
                    // ]);
                    // Assign QC
                    if($status == 'inqueue'){
                        $res = WebsiteEnhanceData::where('batch_id',$batch)->where('qc_done',0)->update([
                            'qc_id'             => $qc_id,
                            'qc_assigned_at'    => Carbon::now(),
                        ]);
                    }
                    // Re-Assign QC
                    if($status == 'inprogress'){
                        $res = WebsiteEnhanceData::where('batch_id',$batch)->where('qc_done',0)->update([
                            'qc_id'             => $qc_id,
                            'qc_assigned_at'    => Carbon::now(),
                        ]);
                    }
                }
    
                if($request->da_id){
                    // WebsiteEnhanceData::where('batch_id',$batch)->where('da_done','!=',1)->update([
                    //     'da_id'             => $da_id,
                    //     'da_assigned_at'    => Carbon::now(),
                    // ]);
                    // Assign DA
                    if($status == 'inqueue'){
                        $res = WebsiteEnhanceData::where('batch_id',$batch)->where('da_done',0)->update([
                            'da_id'             => $da_id,
                            'da_assigned_at'    => Carbon::now(),
                        ]);
                    }
                    // Re-Assign DA
                    if($status == 'inprogress'){
                        $res = WebsiteEnhanceData::where('batch_id',$batch)->where('da_done',0)->update([
                            'da_id'             => $da_id,
                            'da_assigned_at'    => Carbon::now(),
                        ]);
                    }
                }
    
                if($request->qa_id){
                    // WebsiteEnhanceData::where('batch_id',$batch)->where('qa_done','!=',1)->update([
                    //     'qa_id'             => $qa_id,
                    //     'qa_assigned_at'    => Carbon::now(),
                    // ]);
    
                    // Assign QA
                    if($status == 'inqueue'){
                        $res = WebsiteEnhanceData::where('batch_id',$batch)->where('qa_done',0)->update([
                            'qa_id'             => $qa_id,
                            'qa_assigned_at'    => Carbon::now(),
                        ]);
                    }
                    // Re-Assign QA
                    if($status == 'inprogress'){
                        $res = WebsiteEnhanceData::where('batch_id',$batch)->where('qa_done',0)->update([
                            'qa_id'             => $qa_id,
                            'qa_assigned_at'    => Carbon::now(),
                        ]);
                    }
                }
            }
        }
        if($workflow == 'single'){
            foreach($batchs as $batch){

                if($request->pa_id){
                    // Assign PA
                    if($status == 'inqueue'){
                        // dd($pa_id);
                        $res = WebsiteEnhanceData::where('id',$batch)->where('pa_done',null)->update([
                            'pa_id'             => $pa_id,
                            'pa_done'           => 0,
                            'pa_assigned_at'    => Carbon::now(),
                        ]);
                    }
                    // Re-Assign PA
                    if($status == 'inprogress'){
                        $res = WebsiteEnhanceData::where('id',$batch)->where('pa_done',0)->update([
                            'pa_id'             => $pa_id,
                            'pa_assigned_at'    => Carbon::now(),
                        ]);
                    }
                }
    
                if($request->qc_id){
                    // WebsiteEnhanceData::where('id',$batch)->where('qc_done','!=',1)->update([
                    //     'qc_id'             => $qc_id,
                    //     'qc_assigned_at'    => Carbon::now(),
                    // ]);
                    // Assign QC
                    if($status == 'inqueue'){
                        $res = WebsiteEnhanceData::where('id',$batch)->where('qc_done',0)->update([
                            'qc_id'             => $qc_id,
                            'qc_assigned_at'    => Carbon::now(),
                        ]);
                    }
                    // Re-Assign QC
                    if($status == 'inprogress'){
                        $res = WebsiteEnhanceData::where('id',$batch)->where('qc_done',0)->update([
                            'qc_id'             => $qc_id,
                            'qc_assigned_at'    => Carbon::now(),
                        ]);
                    }
                }
    
                if($request->da_id){
                    // WebsiteEnhanceData::where('id',$batch)->where('da_done','!=',1)->update([
                    //     'da_id'             => $da_id,
                    //     'da_assigned_at'    => Carbon::now(),
                    // ]);
                    // Assign DA
                    if($status == 'inqueue'){
                        $res = WebsiteEnhanceData::where('id',$batch)->where('da_done',0)->update([
                            'da_id'             => $da_id,
                            'da_assigned_at'    => Carbon::now(),
                        ]);
                    }
                    // Re-Assign DA
                    if($status == 'inprogress'){
                        $res = WebsiteEnhanceData::where('id',$batch)->where('da_done',0)->update([
                            'da_id'             => $da_id,
                            'da_assigned_at'    => Carbon::now(),
                        ]);
                    }
                }
    
                if($request->qa_id){
                    // WebsiteEnhanceData::where('id',$batch)->where('qa_done','!=',1)->update([
                    //     'qa_id'             => $qa_id,
                    //     'qa_assigned_at'    => Carbon::now(),
                    // ]);
    
                    // Assign QA
                    if($status == 'inqueue'){
                        $res = WebsiteEnhanceData::where('id',$batch)->where('qa_done',0)->update([
                            'qa_id'             => $qa_id,
                            'qa_assigned_at'    => Carbon::now(),
                        ]);
                    }
                    // Re-Assign QA
                    if($status == 'inprogress'){
                        $res = WebsiteEnhanceData::where('id',$batch)->where('qa_done',0)->update([
                            'qa_id'             => $qa_id,
                            'qa_assigned_at'    => Carbon::now(),
                        ]);
                    }
                }
            }
        }

        $user_role          = ProjectUser::where('website_id',$website_id)->where('user_id',$user_id)->value('user_role');
        // dd($user_role);
        if($user_role == 'Team Lead'){
            $role               = $request->role;
            $current_role       = $role;
            $user_where_id      = $role.'_id';
            $user_where_done    = $role.'_done';
            $tl_id              = auth()->user()->id;
            
            if($status == 'inqueue'){
                $heading = strtoupper($role)." InQueue";
                // dd($role);
                if($workflow == 'bluk'){                
                    if($role == 'PA'){
                        $datas = WebsiteEnhanceData::select('*','batch_id', DB::raw('count(*) as total'))->where('website_id',$website_id)->where('batch_id','!=',null)->where($user_where_id,null)->orderBy('total', 'desc')->groupBy('batch_id')->paginate(10);
                        $sku_count = WebsiteEnhanceData::select('*','batch_id', DB::raw('count(*) as total'))->where('website_id',$website_id)->where('batch_id','!=',null)->where($user_where_id,null)->orderBy('total', 'desc')->groupBy('batch_id')->count();

                    }elseif($role == 'QC'){
                        $datas = WebsiteEnhanceData::select('*','batch_id', DB::raw('count(*) as total'))->where('website_id',$website_id)->where('batch_id','!=',null)->where($user_where_id,null)->where('pa_done',1)->orderBy('total', 'desc')->groupBy('batch_id')->paginate(10);
                        $sku_count = WebsiteEnhanceData::select('*','batch_id', DB::raw('count(*) as total'))->where('website_id',$website_id)->where('batch_id','!=',null)->where($user_where_id,null)->where('pa_done',1)->orderBy('total', 'desc')->groupBy('batch_id')->count();

                    }elseif($role == 'QA'){
                        $datas = WebsiteEnhanceData::select('*','batch_id', DB::raw('count(*) as total'))->where('website_id',$website_id)->where('batch_id','!=',null)->where($user_where_id,null)->where('qc_done',1)->orderBy('total', 'desc')->groupBy('batch_id')->paginate(10);
                        $sku_count = WebsiteEnhanceData::select('*','batch_id', DB::raw('count(*) as total'))->where('website_id',$website_id)->where('batch_id','!=',null)->where($user_where_id,null)->where('qc_done',1)->orderBy('total', 'desc')->groupBy('batch_id')->count();

                    }
                }
                if($workflow == 'single'){
                    if($role == 'PA'){
                        $datas = WebsiteEnhanceData::where('website_id',$website_id)->where('batch_id','!=',null)->where($user_where_id,null)->paginate(10);
                        $sku_count = WebsiteEnhanceData::where('website_id',$website_id)->where('batch_id','!=',null)->where($user_where_id,null)->count();

                    }elseif($role == 'QC'){
                        $datas = WebsiteEnhanceData::where('website_id',$website_id)->where('batch_id','!=',null)->where($user_where_id,null)->where('pa_done',1)->paginate(10);
                        $sku_count = WebsiteEnhanceData::where('website_id',$website_id)->where('batch_id','!=',null)->where($user_where_id,null)->where('pa_done',1)->count();

                    }elseif($role == 'QA'){
                        $datas = WebsiteEnhanceData::where('website_id',$website_id)->where('batch_id','!=',null)->where($user_where_id,null)->where('qc_done',1)->paginate(10);
                        $sku_count = WebsiteEnhanceData::where('website_id',$website_id)->where('batch_id','!=',null)->where($user_where_id,null)->where('qc_done',1)->count();

                    }
                }
            }
            if($status == 'inprogress'){
                $heading = strtoupper($role)." InProgress";
                if($workflow == 'bluk'){
                    if($user_role == 'pa'){
                        $datas = WebsiteEnhanceData::select('*','batch_id', DB::raw('count(*) as total'))->where('website_id',$website_id)->where('batch_id','!=',null)->where($user_where_done,0)->orWhere('reject_status',1)->orderBy('total', 'desc')->groupBy('batch_id')->paginate(10);
                        $sku_count = WebsiteEnhanceData::select('*','batch_id', DB::raw('count(*) as total'))->where('website_id',$website_id)->where('batch_id','!=',null)->where($user_where_done,0)->orWhere('reject_status',1)->orderBy('total', 'desc')->groupBy('batch_id')->count();

                    }else{
                        $datas = WebsiteEnhanceData::select('*','batch_id', DB::raw('count(*) as total'))->where('website_id',$website_id)->where('batch_id','!=',null)->where($user_where_id,'!=',null)->where($user_where_done,0)->orderBy('total', 'desc')->groupBy('batch_id')->paginate(10);
                        $sku_count = WebsiteEnhanceData::select('*','batch_id', DB::raw('count(*) as total'))->where('website_id',$website_id)->where('batch_id','!=',null)->where($user_where_id,'!=',null)->where($user_where_done,0)->orderBy('total', 'desc')->groupBy('batch_id')->count();

                    }
                }
                if($workflow == 'single'){               
                    if($user_role == 'pa'){
                        $datas = WebsiteEnhanceData::where('website_id',$website_id)->where('batch_id','!=',null)->where($user_where_done,0)->orWhere('reject_status',1)->paginate(10);
                        $sku_count = WebsiteEnhanceData::where('website_id',$website_id)->where('batch_id','!=',null)->where($user_where_done,0)->orWhere('reject_status',1)->count();

                    }else{
                        $datas = WebsiteEnhanceData::where('website_id',$website_id)->where('batch_id','!=',null)->where($user_where_id,'!=',null)->where($user_where_done,0)->paginate(10);
                        $sku_count = WebsiteEnhanceData::where('website_id',$website_id)->where('batch_id','!=',null)->where($user_where_id,'!=',null)->where($user_where_done,0)->count();

                    }
                }
            }
            if($status == 'rejected'){
                $heading = "QC Rejected";
                if($workflow == 'bluk'){
                    $datas = WebsiteEnhanceData::select('*','batch_id', DB::raw('count(*) as total'))->where('website_id',$website_id)->where('batch_id','!=',null)->where($user_where_done,0)->where('reject_status',1)->orderBy('total', 'desc')->groupBy('batch_id')->paginate(10);
                    $sku_count = WebsiteEnhanceData::select('*','batch_id', DB::raw('count(*) as total'))->where('website_id',$website_id)->where('batch_id','!=',null)->where($user_where_done,0)->where('reject_status',1)->orderBy('total', 'desc')->groupBy('batch_id')->count();

                }
                if($workflow == 'single'){                
                    $datas = WebsiteEnhanceData::where('website_id',$website_id)->where('batch_id','!=',null)->where($user_where_done,0)->where('reject_status',1)->paginate(10);
                    $sku_count = WebsiteEnhanceData::where('website_id',$website_id)->where('batch_id','!=',null)->where($user_where_done,0)->where('reject_status',1)->count();

                }
            }
            if($status == 'reworked'){
                $heading = "Rework Done";
                if($workflow == 'bluk'){
                    $datas = WebsiteEnhanceData::select('*','batch_id', DB::raw('count(*) as total'))->where('website_id',$website_id)->where('batch_id','!=',null)->where($user_where_done,1)->where('reject_status',1)->orderBy('total', 'desc')->groupBy('batch_id')->paginate(10);
                    $sku_count = WebsiteEnhanceData::select('*','batch_id', DB::raw('count(*) as total'))->where('website_id',$website_id)->where('batch_id','!=',null)->where($user_where_done,1)->where('reject_status',1)->orderBy('total', 'desc')->groupBy('batch_id')->count();

                }
                if($workflow == 'single'){
                    $datas = WebsiteEnhanceData::where('website_id',$website_id)->where('batch_id','!=',null)->where($user_where_done,1)->where('reject_status',1)->paginate(10);
                    $sku_count = WebsiteEnhanceData::where('website_id',$website_id)->where('batch_id','!=',null)->where($user_where_done,1)->where('reject_status',1)->count();

                }
            }
            if($status == 'completed'){
                // $heading = strtoupper($role)." Completed";
                $heading = "Completed Queue";
                if($workflow == 'bluk'){
                    $datas = WebsiteEnhanceData::select('*','batch_id', DB::raw('count(*) as total'))->where('website_id',$website_id)->where('batch_id','!=',null)->where('live_updated_at',null)->where($user_where_done,1)->orderBy('total', 'desc')->groupBy('batch_id')->paginate(10);
                    $sku_count = WebsiteEnhanceData::select('*','batch_id', DB::raw('count(*) as total'))->where('website_id',$website_id)->where('batch_id','!=',null)->where('live_updated_at',null)->where($user_where_done,1)->orderBy('total', 'desc')->groupBy('batch_id')->count();

                }
                if($workflow == 'single'){
                    $datas = WebsiteEnhanceData::where('website_id',$website_id)->where('batch_id','!=',null)->where('live_updated_at',null)->where($user_where_done,1)->paginate(10);
                    $sku_count = WebsiteEnhanceData::where('website_id',$website_id)->where('batch_id','!=',null)->where('live_updated_at',null)->where($user_where_done,1)->count();

                }
            }
            if($status == 'updated'){
                $heading = "Live Updated";
                if($workflow == 'bluk'){
                    $datas = WebsiteEnhanceData::select('*','batch_id', DB::raw('count(*) as total'))->where('website_id',$website_id)->where('batch_id','!=',null)->where('live_updated_at','!=',null)->orderBy('total', 'desc')->groupBy('batch_id')->paginate(10);
                    $sku_count = WebsiteEnhanceData::select('*','batch_id', DB::raw('count(*) as total'))->where('website_id',$website_id)->where('batch_id','!=',null)->where('live_updated_at','!=',null)->orderBy('total', 'desc')->groupBy('batch_id')->count();

                }
                if($workflow == 'single'){
                    $datas = WebsiteEnhanceData::where('website_id',$website_id)->where('batch_id','!=',null)->where('live_updated_at','!=',null)->paginate(10);
                    $sku_count = WebsiteEnhanceData::where('website_id',$website_id)->where('batch_id','!=',null)->where('live_updated_at','!=',null)->count();

                }
            }
            // dd($datas);
            $pa_lists = User::where('tl_id',$tl_id)->role('PA')->get();
            $qc_lists = User::where('tl_id',$tl_id)->role('QC')->get();
            $da_lists = User::where('tl_id',$tl_id)->role('DA')->get();
            $qa_lists = User::where('tl_id',$tl_id)->role('QA')->get();
            return view('batch_list',compact('datas','sku_count','pa_lists','qc_lists','da_lists','qa_lists','website_id','status','heading','website_name','role','current_role','user_role','workflow'))->with('success','Users Assigned Successfully!');
        }
        
        // return redirect()->back()->with('success','Users Assigned Successfully!');
    }

    public function enhance_data(Request $request)
    {
        set_time_limit(180000000);
		ini_set('memory_limit', -1);

        $title_character_count=0;
        $description_word_count=0;

        $arr_file = explode('.', $_FILES['file']['name']);
        $extension = end($arr_file);
        
        if('csv' == $extension) {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        } else {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }
        $reader->setReadDataOnly(true);
        $reader->setReadEmptyCells(false);
        $spreadsheet    = $reader->load($_FILES['file']['tmp_name']);
        
        $sheetDatas     = $spreadsheet->getActiveSheet()->toArray();
        
        DB::beginTransaction();
        try {
            foreach($sheetDatas as $key => $sheetData){
                if($key == 0){
                    $title_index                = array_search("NAME",$sheetData);
                    $brand_index                = array_search("BRAND",$sheetData);
                    $category_index             = array_search("CATEGORY",$sheetData);
                    $description_index          = array_search("OVERVIEW",$sheetData);
                    $feature_start_index        = array_search("FEATURE_1",$sheetData);
                    $feature_end_index          = array_search("FEATURE_51",$sheetData);
                    $specification_start_index  = array_search("SPEC_VALUE_1",$sheetData);
                    $specification_end_index    = array_search("SPEC_VALUE_28",$sheetData);
                    $image_start_index          = array_search("IMG_SRC_1",$sheetData);
                    $image_end_index            = array_search("IMG_SRC_60",$sheetData);
                    $url_index                  = array_search("URL",$sheetData);
                    $p_id_index                 = array_search("ID",$sheetData);
                    $mpn_index                  = array_search("MPN",$sheetData);
                    $tag_index                  = array_search("TAG",$sheetData);

                    // Column Name Validation
                    if($title_index                 == false ||
                       $brand_index                 == false ||
                       $category_index              == false ||
                       $description_index           == false ||
                       $feature_start_index         == false ||
                       $feature_end_index           == false ||
                       $specification_start_index   == false ||
                       $specification_end_index     == false ||
                       $image_start_index           == false ||
                       $image_end_index             == false ||
                       $p_id_index                  == false ||
                       $mpn_index                   == false ||
                       $tag_index                   == false){
                        return redirect()->back()->with('error','Invalid File');
                    }
                    
                    // Feature
                    for($i=$feature_start_index;$i<=$feature_end_index;$i++){
                        $feature_keys[] = $i;
                    }

                    // Specification
                    for($i=$specification_start_index;$i<=$specification_end_index;$i++){
                        if($i % 2 == 0) {
                            $specification_keys[] = $i;
                        }
                    }

                    // Image
                    for($i=$image_start_index;$i<=$image_end_index;$i++){
                        $image_keys[] = $i;
                    }
                    
                }else{
                    // Title Character Count Check
                    if($sheetData[$title_index]){ 
                        $title_character_count = strlen($sheetData[$title_index]);
                    }
                    
                    // Description Word Count Check
                    if($sheetData[$description_index]){ 
                        // $description_word_count = str_word_count($sheetData[$description_index]); 
                        $str_arr = explode(" ",$sheetData[$description_index]);
                        $description_word_count=count($str_arr);
                    }

                    // Feature Count Check
                    $feature_count = 0;
                    foreach($feature_keys as $res => $feature_key){ 
                        if(strlen($sheetData[$feature_key]) > 0){ 
                            $feature_count++;
                        }
                    }
                    
                    // Specification Count Check
                    $specification_count = 0;
                    foreach($specification_keys as $res => $specification_key){ 
                        if(strlen($sheetData[$specification_key]) > 0){ 
                            $specification_count++;
                        }
                    }
                    
                    // Image Count Check
                    $image_count = 0;
                    foreach($image_keys as $res => $image_key){ 
                        if(strlen($sheetData[$image_key]) > 0){ 
                            $image_count++;
                        }
                    }
                    
                    // Category
                    if(strlen($sheetData[$category_index]) > 0){ 
                        $category = $sheetData[$category_index];
                    }else{
                        $category = 'Uncategory';
                    }

                    // Data Insert into WebsiteEnhanceData table
                    $website_data = WebsiteEnhanceData::create([
                        'website_id'                => $request->website_id,
                        'title'                     => $sheetData[$title_index],
                        'description'               => $sheetData[$description_index],
                        'brand'                     => $sheetData[$brand_index],
                        'category'                  => $category,
                        'title_character_count'     => $title_character_count,
                        'description_word_count'    => $description_word_count,
                        'feature_count'             => $feature_count,
                        'specification_count'       => $specification_count,
                        'image_count'               => $image_count,
                        'url'                       => $sheetData[$url_index],
                        'p_id'                      => $sheetData[$p_id_index],
                        'tl_id'                     => auth()->user()->id,
                        'mpn'                       => $sheetData[$mpn_index],
                        'tag'                       => $sheetData[$tag_index],
                    ]);

                    // Feature Count Check
                    foreach($feature_keys as $res => $feature_key){ 
                        if(strlen($sheetData[$feature_key]) > 0){ 
                            WebsiteEnhanceFeature::create([
                                'website_id'                => $request->website_id,
                                'website_enhance_data_id'   => $website_data->id,
                                'feature'                   => $sheetData[$feature_key]
                            ]);
                        }
                    }
                    
                    // Specification Count Check
                    foreach($specification_keys as $res => $specification_key){ 
                        if(strlen($sheetData[$specification_key]) > 0){ 
                            WebsiteEnhanceSpecification::create([
                                'website_id'                => $request->website_id,
                                'website_enhance_data_id'   => $website_data->id,
                                'specification_head'        => $sheetData[$specification_key - 1],
                                'specification_value'       => $sheetData[$specification_key]
                            ]);
                        }
                    }
                    
                    // Image Count Check
                    foreach($image_keys as $res => $image_key){ 
                        if(strlen($sheetData[$image_key]) > 0){ 
                            WebsiteEnhanceImage::create([
                                'website_id'                => $request->website_id,
                                'website_enhance_data_id'   => $website_data->id,
                                'image'                     => $sheetData[$image_key]
                            ]);
                        }
                    }
                }
            }
            // Add Data History
            $user_id = auth()->user()->id;
            // $data_history = DataHistory::create([
            //     'user_id'       => $user_id,
            //     'website_id'    => $request->website_id,
            //     'action'        => 'Support Import'
            // ]);
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return redirect()->back()->with('error','Invalid File');
        }

        DB::commit();

        return redirect()->back()->with('success','File Imported Sucessfully!');
    }

    public function update_to_live(Request $request)
    {
        $website_id = $request->website_id;
        $batchs     = $request->batch;
        $workflow   = Website::where('id',$website_id)->value('workflow_settings');

        if($workflow == 'single'){
            foreach($batchs as $batch){
                WebsiteEnhanceData::where('id',$batch)->update([
                    'live_updated_at'    => Carbon::now(),
                ]);
            }
        }

        if($workflow == 'bulk'){
            foreach($batchs as $batch){
                WebsiteEnhanceData::where('batch_id',$batch)->update([
                    'live_updated_at'    => Carbon::now(),
                ]);
            }
        }

        return redirect()->back()->with('success','Batch Updated Successfully!');
    }

}
