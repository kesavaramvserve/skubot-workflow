<?php

namespace App\Http\Controllers\QC;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Website;
use App\Models\WebsiteData;
use App\Models\WebsiteEnhanceData;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use DB;
use Carbon\Carbon;

class QCController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $qc_id = auth()->user()->id;
        $datas = WebsiteData::select('*','batch_id', DB::raw('count(*) as total'))->where('qc_done',0)->orWhere('qc_done',3)->where('qc_id', $qc_id)->orderBy('total', 'desc')->groupBy('batch_id')->get();
        // dd($datas);
        return view('qc.index',compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('qc.upload');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        set_time_limit(180000000);
		ini_set('memory_limit', -1);

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
        $err            = 0;
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

                    // dd($sheetData);
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
                       $caption_error_index         == false ||
                       $manf_error_index            == false ||
                       $image_error_index           == false ||
                       $path_error_index            == false ||
                       $other_error_index           == false ||
                       $tag_index                   == false){
                        return redirect()->back()->with('error','Invalid File');
                    }
                    
                }else{
                    if($sheetData[$name_error_index]    == true ||
                    $sheetData[$caption_error_index]    == true ||
                    $sheetData[$manf_error_index]       == true ||
                    $sheetData[$image_error_index]      == true ||
                    $sheetData[$path_error_index]       == true ||
                    $sheetData[$other_error_index]      == true ){
                        WebsiteData::where('id',$sheetData[$db_id_index])->update([
                            'pa_done'       => 3, // PA Error
                            'qc_done'       => 1,
                            'name_error'    => $sheetData[$name_error_index],
                            'caption_error' => $sheetData[$caption_error_index],
                            'manf_error'    => $sheetData[$manf_error_index],
                            'image_error'   => $sheetData[$image_error_index],
                            'path_error'    => $sheetData[$path_error_index],
                            'other_error'   => $sheetData[$other_error_index],
                            'summary'       => $sheetData[$summary_index],
                            'rework'        => $sheetData[$rework_index],
                        ]);
                    }else{
                        WebsiteData::where('id',$sheetData[$db_id_index])->update([
                            'name_error'        => $sheetData[$name_error_index],
                            'caption_error'     => $sheetData[$caption_error_index],
                            'manf_error'        => $sheetData[$manf_error_index],
                            'image_error'       => $sheetData[$image_error_index],
                            'path_error'        => $sheetData[$path_error_index],
                            'other_error'       => $sheetData[$other_error_index],
                            'summary'           => $sheetData[$summary_index],
                            'rework'            => $sheetData[$rework_index],
                            // 'pa_done'           => 1, // PA Done
                            'qa_done'           => 0, // QC Request
                            'qc_done'           => 1,
                            'pa_approved_at'    => Carbon::now(),
                        ]);
                    }

                }
            }
            
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

    public function qa_reject()
    {
        $qc_id = auth()->user()->id;
        $datas = WebsiteData::select('*','batch_id', DB::raw('count(*) as total'))->where('qc_id',$qc_id)->where('qc_done',3)->orderBy('total', 'desc')->groupBy('batch_id')->get();
        return view('qc.qa_reject',compact('datas'));
    }

    public function qc_complete()
    {
        $qc_id = auth()->user()->id;
        $datas = WebsiteData::select('*','batch_id', DB::raw('count(*) as total'))->where('qc_id',$qc_id)->where('qc_done',1)->orderBy('total', 'desc')->groupBy('batch_id')->get();
        return view('qc.qc_complete',compact('datas'));
    }
}
