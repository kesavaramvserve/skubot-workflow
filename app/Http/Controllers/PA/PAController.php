<?php

namespace App\Http\Controllers\PA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Website;
use App\Models\WebsiteEnhanceData;
use App\Models\WebsiteEnhanceFeature;
use App\Models\WebsiteEnhanceSpecification;
use App\Models\WebsiteEnhanceImage;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use DB;
use Carbon\Carbon;

class PAController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pa_id = auth()->user()->id;
        $datas = WebsiteEnhanceData::select('*','batch_id', DB::raw('count(*) as total'))->where('pa_id',$pa_id)->where('pa_done',0)->orWhere('pa_done',3)->orderBy('total', 'desc')->groupBy('batch_id')->get();
        return view('pa.index',compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pa.upload');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        set_time_limit(180000000);
		ini_set('memory_limit', -1);

        // $batch_id = $request->batch_id;
        // $website_id = WebsiteEnhanceData::where('batch_id',$batch_id)->value('website_id');
        

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

        // dd($sheetDatas[1][0]);
        DB::beginTransaction();
        try {
            foreach($sheetDatas as $key => $sheetData){
                if($key == 0){
                    $db_id_index                = array_search("db_id",$sheetData);
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
                    $name_error_index           = array_search("name_error",$sheetData);
                    $caption_error_index        = array_search("caption_error",$sheetData);
                    $manf_error_index           = array_search("manf_error",$sheetData);
                    $image_error_index          = array_search("image_error",$sheetData);
                    $path_error_index           = array_search("path_error",$sheetData);
                    $other_error_index          = array_search("other_error",$sheetData);
                    $summary_index              = array_search("summary",$sheetData);
                    $rework_index               = array_search("rework",$sheetData);

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
                    $website_data = WebsiteEnhanceData::where('id',$sheetData[$db_id_index])->where('pa_done',0)->orWhere('pa_done',3)->update([
                        'title'                     => $sheetData[$title_index],
                        'description'               => $sheetData[$description_index],
                        'title_character_count'     => $title_character_count,
                        'description_word_count'    => $description_word_count,
                        'feature_count'             => $feature_count,
                        'specification_count'       => $specification_count,
                        'image_count'               => $image_count,
                        'pa_done'                   => 1,
                        'qc_done'                   => 0,
                    ]);

                    $website_id = WebsiteEnhanceData::where('id',$sheetData[$db_id_index])->value('website_id');
                    WebsiteEnhanceFeature::where('website_enhance_data_id',$sheetData[$db_id_index])->delete();
                    WebsiteEnhanceSpecification::where('website_enhance_data_id',$sheetData[$db_id_index])->delete();
                    WebsiteEnhanceImage::where('website_enhance_data_id',$sheetData[$db_id_index])->delete();

                    // Feature Count Check
                    foreach($feature_keys as $res => $feature_key){ 
                        if(strlen($sheetData[$feature_key]) > 0){ 
                            WebsiteEnhanceFeature::create([
                                'website_id'                => $website_id,
                                'website_enhance_data_id'   => $sheetData[$db_id_index],
                                'feature'                   => $sheetData[$feature_key]
                            ]);
                        }
                    }

                    // Specification Count Check
                    foreach($specification_keys as $res => $specification_key){ 
                        if(strlen($sheetData[$specification_key]) > 0){ 
                            WebsiteEnhanceSpecification::create([
                                'website_id'                    => $website_id,
                                'website_enhance_data_id'       => $sheetData[$db_id_index],
                                'specification_head'            => $sheetData[$specification_key - 1],
                                'specification_value'           => $sheetData[$specification_key]
                            ]);
                        }
                    }

                    // Image Count Check
                    foreach($image_keys as $res => $image_key){ 
                        if(strlen($sheetData[$image_key]) > 0){ 
                            WebsiteEnhanceImage::create([
                                'website_id'                => $website_id,
                                'website_enhance_data_id'   => $sheetData[$db_id_index],
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
            //     'website_id'    => $website_id,
            //     'action'        => 'Enhance file imported'
            // ]);
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return redirect()->back()->with('error','Invalid File');
        }

        DB::commit();
        
        return redirect()->back()->with('success','File Imported successfully');
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

    public function qc_reject()
    {
        $pa_id = auth()->user()->id;
        $datas = WebsiteEnhanceData::select('*','batch_id', DB::raw('count(*) as total'))->where('pa_id',$pa_id)->where('pa_done',3)->orderBy('total', 'desc')->groupBy('batch_id')->get();
        return view('pa.qc_reject',compact('datas'));
    }

    public function pa_complete()
    {
        $pa_id = auth()->user()->id;
        $datas = WebsiteEnhanceData::select('*','batch_id', DB::raw('count(*) as total'))->where('pa_id',$pa_id)->where('pa_done',1)->orderBy('total', 'desc')->groupBy('batch_id')->get();
        return view('pa.pa_complete',compact('datas'));
    }
}
