<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ScraperData;
use App\Models\Website;
use App\Models\WebsiteData;
use App\Models\ClientPrice;
use App\Models\DataHistory;
use App\Models\ClientRequirement;
use App\Models\ClientRequestData;
use App\Models\EnhancedData;
use App\Models\WebsiteRange;
use App\Models\WebsiteEnhanceData;
use DB;
use Illuminate\Support\Facades\Crypt;
use App\Mail\ClientViewEmail;
use App\Mail\EnhancedEmail;
use Illuminate\Support\Facades\Mail;
use App\Exports\DataExport;
use Excel;
use App\Models\WebsiteFeature;
use App\Models\WebsiteSpecification;
use App\Models\WebsiteImage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv; 
use App\Models\Note;


class SupportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation
        $this->validate($request, [
            'title'         => 'required',
            'description'   => 'required',
            'feature'       => 'required',
            'specification' => 'required',
            'image'         => 'required',
        ]);
    
        // Declare Datas
        $website_id      = $request->website_id;
        $client_id       = Website::with('getClient')->where('id',$website_id)->get();
        $titles          = $request->title;
        $descriptions    = $request->description;
        $features        = $request->feature;
        $specifications  = $request->specification;
        $images          = $request->image;

        // Duplicate Validation
        $clientPrice = ClientPrice::where('website_id',$website_id)->get();
        if(!blank($clientPrice)){
            return redirect()->back()->with('error','This Website is already have Prices');
        }
        
        // Date Store
        DB::beginTransaction();
        try {
            // Insert Title Prices to client_prices Table
            $range_id = 1;
            foreach($titles as $key => $title){
                ClientPrice::create([
                    'client_id'     => $client_id[0]->getClient->id,
                    'website_id'    => $website_id,
                    'content_id'    => 1,
                    'range_id'      => $range_id,
                    'price'         => $title,
                ]);
                $range_id++;
            }

            // Insert Description Prices to client_prices Table
            $range_id = 1;
            foreach($descriptions as $key => $description){
                ClientPrice::create([
                    'client_id'     => $client_id[0]->getClient->id,
                    'website_id'    => $website_id,
                    'content_id'    => 2,
                    'range_id'      => $range_id,
                    'price'         => $description,
                ]);
                $range_id++;
            }

            // Insert Feature Prices to client_prices Table
            $range_id = 1;
            foreach($features as $key => $feature){
                ClientPrice::create([
                    'client_id'     => $client_id[0]->getClient->id,
                    'website_id'    => $website_id,
                    'content_id'    => 3,
                    'range_id'      => $range_id,
                    'price'         => $feature,
                ]);
                $range_id++;
            }

            // Insert Specification Prices to client_prices Table
            $range_id = 1;
            foreach($specifications as $key => $specification){
                ClientPrice::create([
                    'client_id'     => $client_id[0]->getClient->id,
                    'website_id'    => $website_id,
                    'content_id'    => 4,
                    'range_id'      => $range_id,
                    'price'         => $specification,
                ]);
                $range_id++;
            }

            // Insert Image Prices to client_prices Table
            $range_id = 1;
            foreach($images as $key => $image){
                ClientPrice::create([
                    'client_id'     => $client_id[0]->getClient->id,
                    'website_id'    => $website_id,
                    'content_id'    => 5,
                    'range_id'      => $range_id,
                    'price'         => $image,
                ]);
                $range_id++;
            }
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
        }

        DB::commit();
        return redirect()->back()->with('success','Set Prices Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = Crypt::decryptString($id);
        $website = Website::with('getClient')->where('id',$id)->get();
        $website_prices = ClientPrice::where('website_id',$id)->get();
        return view('support.set_price',compact('website','website_prices'));
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
        // Validation
        $this->validate($request, [
            'title'         => 'required',
            'description'   => 'required',
            'feature'       => 'required',
            'specification' => 'required',
            'image'         => 'required',
        ]);
    
        // Declare Datas
        $website_id         = $request->website_id;
        $titles             = $request->title;
        $descriptions       = $request->description;
        $features           = $request->feature;
        $specifications     = $request->specification;
        $images             = $request->image;
        $title_ids          = $request->title_id;
        $description_ids    = $request->description_id;
        $feature_ids        = $request->feature_id;
        $specification_ids  = $request->specification_id;
        $image_ids          = $request->image_id;
        
        // Date Update
        DB::beginTransaction();
        try {
            // Update Title Prices to client_prices Table
            foreach($titles as $key => $title){
                ClientPrice::where('id',$title_ids[$key])->update([
                    'price'         => $title,
                ]);
            }

            // Update Description Prices to client_prices Table
            foreach($descriptions as $key => $description){
                ClientPrice::where('id',$description_ids[$key])->update([
                    'price'         => $description,
                ]);
            }

            // Update Feature Prices to client_prices Table
            foreach($features as $key => $feature){
                ClientPrice::where('id',$feature_ids[$key])->update([
                    'price'         => $feature,
                ]);
            }

            // Update Specification Prices to client_prices Table
            foreach($specifications as $key => $specification){
                ClientPrice::where('id',$specification_ids[$key])->update([
                    'price'         => $specification,
                ]);
            }

            // Update Image Prices to client_prices Table
            foreach($images as $key => $image){
                ClientPrice::where('id',$image_ids[$key])->update([
                    'price'         => $image,
                ]);
            }

            // Add Data History
            $user_id = auth()->user()->id;
            $data_history = DataHistory::create([
                'user_id'       => $user_id,
                'website_id'    => $request->website_id,
                'action'        => 'Price Changed'
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
        }

        DB::commit();
        return redirect()->back()->with('success','Prices Updated Successfully');
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

    public function import_scrape_data(Request $request)
    {
        // dd($request->website_id);
        set_time_limit(180000000);
		ini_set('memory_limit', -1);

        // for($i=8;$i<59;$i++){
        //     $feature_keys[] = $i;
        // }
        // for($i=59;$i<87;$i++){
        //     if($i % 2 == 0) {
        //         $specification_keys[] = $i;
        //     }
        // }
        // for($i=145;$i<205;$i++){
        //     $image_keys[] = $i;
        // }
        
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
        // dd($sheetDatas);
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
                    if(strlen($sheetData[$url_index]) > 0){
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
                                // WebsiteFeature::create([
                                //     'website_id'        => $request->website_id,
                                //     'website_data_id'   => $data_id,
                                //     'feature'           => $sheetData[$feature_key]
                                // ]);
                            }
                        }
                        
                        // Specification Count Check
                        $specification_count = 0;
                        foreach($specification_keys as $res => $specification_key){ 
                            if(strlen($sheetData[$specification_key]) > 0){ 
                                $specification_count++;
                                // WebsiteSpecification::create([
                                //     'website_id'            => $request->website_id,
                                //     'website_data_id'       => $data_id,
                                //     'specification_head'    => $sheetData[$specification_key - 1],
                                //     'specification_value'   => $sheetData[$specification_key]
                                // ]);
                            }
                        }
                        
                        // Image Count Check
                        $image_count = 0;
                        foreach($image_keys as $res => $image_key){ 
                            if(strlen($sheetData[$image_key]) > 0){ 
                                $image_count++;
                                // WebsiteImage::create([
                                //     'website_id'        => $request->website_id,
                                //     'website_data_id'   => $data_id,
                                //     'image'             => $sheetData[$image_key]
                                // ]);
                            }
                        }
                        
                        // Category
                        if(strlen($sheetData[$category_index]) > 0){ 
                            $category = $sheetData[$category_index];
                        }else{
                            $category = 'Uncategory';
                        }

                        // Data Insert into WebsiteData table
                        $website_data = WebsiteData::create([
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
                            'mpn'                       => $sheetData[$mpn_index],
                            'tag'                       => $sheetData[$tag_index],
                        ]);

                        // Feature Count Check
                        foreach($feature_keys as $res => $feature_key){ 
                            if(strlen($sheetData[$feature_key]) > 0){ 
                                WebsiteFeature::create([
                                    'website_id'        => $request->website_id,
                                    'website_data_id'   => $website_data->id,
                                    'feature'           => $sheetData[$feature_key]
                                ]);
                            }
                        }
                        
                        // Specification Count Check
                        foreach($specification_keys as $res => $specification_key){ 
                            if(strlen($sheetData[$specification_key]) > 0){ 
                                WebsiteSpecification::create([
                                    'website_id'            => $request->website_id,
                                    'website_data_id'       => $website_data->id,
                                    'specification_head'    => $sheetData[$specification_key - 1],
                                    'specification_value'   => $sheetData[$specification_key]
                                ]);
                            }
                        }
                        
                        // Image Count Check
                        foreach($image_keys as $res => $image_key){ 
                            if(strlen($sheetData[$image_key]) > 0){ 
                                WebsiteImage::create([
                                    'website_id'        => $request->website_id,
                                    'website_data_id'   => $website_data->id,
                                    'image'             => $sheetData[$image_key]
                                ]);
                            }
                        }
                    }
                }
            }
            // Add Data History
            $user_id = auth()->user()->id;
            $data_history = DataHistory::create([
                'user_id'       => $user_id,
                'website_id'    => $request->website_id,
                'action'        => 'Support Import'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return redirect()->back()->with('error','Invalid File');
        }

        DB::commit();

        return redirect()->back()->with('success','File Imported Sucessfully!');
    }
    
    public function set_range(Request $request, $id){
        if(!empty($request->website_id)){
            $website_id = $request->id;
        }else{
            $website_id = Crypt::decryptString($id);
        }
        $content                    = ['title','description','feature','specification','image'];
        $title                      = [30,50,70,90,91];
        $description                = [30,60,80,100,101];
        $feature                    = [0,2,3,4,5];
        $specification              = [0,2,3,4,5];
        $image                      = [0,2,3,4,5];
        $website_range              = WebsiteRange::where('website_id',$website_id)->get();
        $data                       = Website::where('id',$website_id)->get();

        if(blank($website_range)){
            // Insert Title Ranges
            $website_range = WebsiteRange::create([
                'website_id' => $website_id,
                'content' => $content[0],
                'high_attention_required' => $title[0],
                'needs_improvement' => $title[1],
                'good_to_improve' => $title[2],
                'average_optimized' => $title[3],
                'optimized' => $title[4] 
            ]);
            // Insert Description Ranges
            $website_range = WebsiteRange::create([
                'website_id' => $website_id,
                'content' => $content[1],
                'high_attention_required' => $description[0],
                'needs_improvement' => $description[1],
                'good_to_improve' => $description[2],
                'average_optimized' => $description[3],
                'optimized' => $description[4] 
            ]);
            // Insert Feature Ranges
            $website_range = WebsiteRange::create([
                'website_id' => $website_id,
                'content' => $content[2],
                'high_attention_required' => $feature[0],
                'needs_improvement' => $feature[1],
                'good_to_improve' => $feature[2],
                'average_optimized' => $feature[3],
                'optimized' => $feature[4] 
            ]);
            // Insert Specification Ranges
            $website_range = WebsiteRange::create([
                'website_id' => $website_id,
                'content' => $content[3],
                'high_attention_required' => $specification[0],
                'needs_improvement' => $specification[1],
                'good_to_improve' => $specification[2],
                'average_optimized' => $specification[3],
                'optimized' => $specification[4] 
            ]);
            // Insert Image Ranges
            $website_range = WebsiteRange::create([
                'website_id' => $website_id,
                'content' => $content[4],
                'high_attention_required' => $image[0],
                'needs_improvement' => $image[1],
                'good_to_improve' => $image[2],
                'average_optimized' => $image[3],
                'optimized' => $image[4] 
            ]);
        }
        $website_title_range = WebsiteRange::where('website_id',$website_id)->where('content','title')->get();
        $website_description_range = WebsiteRange::where('website_id',$website_id)->where('content','description')->get();
        $website_feature_range = WebsiteRange::where('website_id',$website_id)->where('content','feature')->get();
        $website_specification_range = WebsiteRange::where('website_id',$website_id)->where('content','specification')->get();
        $website_image_range = WebsiteRange::where('website_id',$website_id)->where('content','image')->get();
        
        $title                      = [$website_title_range[0]->high_attention_required,$website_title_range[0]->needs_improvement,$website_title_range[0]->good_to_improve,$website_title_range[0]->average_optimized,$website_title_range[0]->optimized];
        $description                = [$website_description_range[0]->high_attention_required,$website_description_range[0]->needs_improvement,$website_description_range[0]->good_to_improve,$website_description_range[0]->average_optimized,$website_description_range[0]->optimized];
        $feature                    = [$website_feature_range[0]->high_attention_required,$website_feature_range[0]->needs_improvement,$website_feature_range[0]->good_to_improve,$website_feature_range[0]->average_optimized,$website_feature_range[0]->optimized];
        $specification              = [$website_specification_range[0]->high_attention_required,$website_specification_range[0]->needs_improvement,$website_specification_range[0]->good_to_improve,$website_specification_range[0]->average_optimized,$website_specification_range[0]->optimized];
        $image                      = [$website_image_range[0]->high_attention_required,$website_image_range[0]->needs_improvement,$website_image_range[0]->good_to_improve,$website_image_range[0]->average_optimized,$website_image_range[0]->optimized];
        $description_category       = Website::where('id',$website_id)->value('description');
        
        return view('support.set_range',compact('data','website_id','title','description','feature','specification','image','description_category'));
    }

    public function scrape_view(Request $request)
    {
        set_time_limit(180000000);
		ini_set('memory_limit', -1);
        
        
        if(!empty($request->website_id)){
            $website_id = $request->website_id;
        }
        // $title                      = [40,60,70,80,81];
        // $description                = [30,60,80,100,101];
        // $feature                    = [0,2,3,4,5];
        // $specification              = [0,2,3,4,5];
        // $image                      = [0,2,3,4,5];
        $id                         = $website_id;
        $title                      = $request->title;
        $description                = $request->description;
        $feature                    = $request->feature;
        $specification              = $request->specification;
        $image                      = $request->image;

        $width_limit = 200;
        $height_limit = 400;

        $total_data_count = WebsiteData::where('website_id',$website_id)->count();
        $total_image_count = WebsiteImage::where('website_id',$website_id)->count();
        $greater_width_count = WebsiteImage::where('website_id',$website_id)->where('width','>',$width_limit)->count();
        $lesser_width_count = WebsiteImage::where('website_id',$website_id)->where('width','<=',$width_limit)->count();
        $lesser_width_percentage = ($lesser_width_count / $total_image_count ) * 100;
        $string                         = floatval($lesser_width_percentage);
        $lesser_width_percentage        = number_format($string, 2, '.', '');
        $greater_height_count = WebsiteImage::where('website_id',$website_id)->where('height','>',$height_limit)->count();
        $lesser_height_count = WebsiteImage::where('website_id',$website_id)->where('height','<=',$height_limit)->count();

        // Image Alt Tag
        $img_alt_count      = WebsiteImage::where('website_id',$website_id)->where('alt','')->groupBy('website_data_id')->get();
        $img_alt_count      = count($img_alt_count);
        $img_alt_percentage = ($img_alt_count / $total_image_count ) * 100;
        $string             = floatval($img_alt_percentage);
        $img_alt_percentage = number_format($string, 2, '.', '');

        // title_metadata
        $title_metadata_count = WebsiteData::where('website_id',$website_id)->where('title_metadata','!=',null)->count();
        $title_metadata_length = WebsiteData::where('website_id',$website_id)->where('title_metadata_length','>',70)->count();
        $title_metadata_percentage = ($title_metadata_length / $total_data_count ) * 100;
        $string                         = floatval($title_metadata_percentage);
        $title_metadata_percentage      = number_format($string, 2, '.', '');

        // description_metadata
        $description_metadata_count = WebsiteData::where('website_id',$website_id)->where('description_metadata','!=',null)->count();
        $description_metadata_length = WebsiteData::where('website_id',$website_id)->where('description_metadata_length','>',170)->count();
        $description_metadata_percentage = ($description_metadata_length / $total_data_count ) * 100;
        $string                         = floatval($description_metadata_percentage);
        $description_metadata_percentage      = number_format($string, 2, '.', '');

        // keywords_metadata
        $keywords_metadata_count = WebsiteData::where('website_id',$website_id)->where('keywords_metadata','!=',null)->count();
        $keywords_metadata_length_count1 = WebsiteData::where('website_id',$website_id)->where('keywords_metadata_length',0)->count();
        $keywords_metadata_length_count2 = WebsiteData::where('website_id',$website_id)->where('keywords_metadata_length',1)->count();
        $keywords_metadata_length_count3 = WebsiteData::where('website_id',$website_id)->where('keywords_metadata_length',2)->count();
        $common_range1_skus = WebsiteData::where('website_id',$website_id)->where('title_character_count','>=',0)->where('title_character_count','<=',$request->title[0])
        ->where('description_word_count','>=',0)->where('description_word_count','<=',$request->description[0])
        ->where('feature_count','>=',0)->where('feature_count','<=',$request->feature[0])
        ->where('specification_count','>=',0)->where('specification_count','<=',$request->specification[0])
        ->where('image_count','>=',0)->where('image_count','<=',$request->image[0])->count();
        $keywords_metadata_length = WebsiteData::where('website_id',$website_id)->where('keywords_metadata_length','<',10)->count();
        $keywords_metadata_percentage = ($keywords_metadata_length / $total_data_count ) * 100;
        $string                         = floatval($keywords_metadata_percentage);
        $keywords_metadata_percentage      = number_format($string, 2, '.', '');

        // Manage Content
        if($request->filter_status != 1){
            Website::where('id',$website_id)->update([
                'title_status'          => $request->title_status,
                'description_status'    => $request->description_status,
                'feature_status'        => $request->feature_status,
                'specification_status'  => $request->specification_status,
                'image_status'          => $request->image_status,
            ]);
        }
        
        // Values From Database
        $website_title_range = WebsiteRange::where('website_id',$website_id)->where('content','title')->where('high_attention_required',$title[0])->where('needs_improvement',$title[1])->where('good_to_improve',$title[2])->where('average_optimized',$title[3])->where('optimized',$title[4])->get();
        $website_description_range = WebsiteRange::where('website_id',$website_id)->where('content','description')->where('high_attention_required',$description[0])->where('needs_improvement',$description[1])->where('good_to_improve',$description[2])->where('average_optimized',$description[3])->where('optimized',$description[4])->get();
        $website_feature_range = WebsiteRange::where('website_id',$website_id)->where('content','feature')->where('high_attention_required',$feature[0])->where('needs_improvement',$feature[1])->where('good_to_improve',$feature[2])->where('average_optimized',$feature[3])->where('optimized',$feature[4])->get();
        $website_specification_range = WebsiteRange::where('website_id',$website_id)->where('content','specification')->where('high_attention_required',$specification[0])->where('needs_improvement',$specification[1])->where('good_to_improve',$specification[2])->where('average_optimized',$specification[3])->where('optimized',$specification[4])->get();
        $website_image_range = WebsiteRange::where('website_id',$website_id)->where('content','image')->where('high_attention_required',$image[0])->where('needs_improvement',$image[1])->where('good_to_improve',$image[2])->where('average_optimized',$image[3])->where('optimized',$image[4])->get();
        
        
        // Update Description Category
        $description_category = Website::where('id',$website_id)->update([
            'description' => $request->description_category,
        ]);
        
        // Update Title Ranges
        $update_website_title_range = WebsiteRange::where('website_id',$website_id)->where('content','title')->update([
            'high_attention_required' => $title[0],
            'needs_improvement' => $title[1],
            'good_to_improve' => $title[2],
            'average_optimized' => $title[3],
            'optimized' => $title[4] 
        ]);
        // Update Description Ranges
        $update_website_description_range = WebsiteRange::where('website_id',$website_id)->where('content','description')->update([
            'high_attention_required' => $description[0],
            'needs_improvement' => $description[1],
            'good_to_improve' => $description[2],
            'average_optimized' => $description[3],
            'optimized' => $description[4] 
        ]);
        // Update Feature Ranges
        $update_website_feature_range = WebsiteRange::where('website_id',$website_id)->where('content','feature')->update([
            'high_attention_required' => $feature[0],
            'needs_improvement' => $feature[1],
            'good_to_improve' => $feature[2],
            'average_optimized' => $feature[3],
            'optimized' => $feature[4] 
        ]);
        // Update Specification Ranges
        $update_website_specification_range = WebsiteRange::where('website_id',$website_id)->where('content','specification')->update([
            'high_attention_required' => $specification[0],
            'needs_improvement' => $specification[1],
            'good_to_improve' => $specification[2],
            'average_optimized' => $specification[3],
            'optimized' => $specification[4] 
        ]);
        // Update Image Ranges
        $update_website_image_range = WebsiteRange::where('website_id',$website_id)->where('content','image')->update([
            'high_attention_required' => $image[0],
            'needs_improvement' => $image[1],
            'good_to_improve' => $image[2],
            'average_optimized' => $image[3],
            'optimized' => $image[4] 
        ]);
            
        $title_report               = [0,0,0,0,0];
        $description_report         = [0,0,0,0,0];
        $feature_report             = [0,0,0,0,0];
        $specification_report       = [0,0,0,0,0];
        $image_report               = [0,0,0,0,0];
        $title_pres_report          = [0,0,0,0,0];
        $description_pres_report    = [0,0,0,0,0];
        $feature_pres_report        = [0,0,0,0,0];
        $specification_pres_report  = [0,0,0,0,0];
        $image_pres_report          = [0,0,0,0,0];
        $score                      = [1,2,3,4,5];
        // $overall_data_count         = WebsiteData::where('website_id',$website_id)->count();
        $starter                    = 0;
        $categories                 = WebsiteData::select('category')->where('website_id',$website_id)->where('category','!=',null)->groupBy('category')->get();
        $category_count             = count($categories);
        $brands                     = WebsiteData::select('brand')->where('website_id',$website_id)->where('brand','!=',null)->groupBy('brand')->get();        
        $brand_count                = count($brands);
        $website_name               = Website::where('id',$website_id)->value('website');
        $req_category               = '';
        $req_brand                  = '';
        $price_status               = ClientPrice::where('website_id',$website_id)->get();
        $website_data               = Website::with('getNotes')->where('id',$website_id)->get();
        $data                       = Website::where('id',$website_id)->get();

        if(!empty($request->category)){
            $req_category = $request->category;
        }
        if(!empty($request->brand)){
            $req_brand = $request->brand;
        }

        $query = WebsiteData::where('website_id',$website_id);
        if(!empty($request->category)){
            $query->where('category',$request->category);
        }
        if(!empty($request->brand)){
            $query->where('brand',$request->brand);
        }
        $res_value = $query->count();

        // title
        foreach($title as $range_key => $range){
            $query = WebsiteData::where('website_id',$website_id);
            if($range_key == count( $title ) - 1){
                $query->where('title_character_count','>=',$range);
            }else{
                $query->where('title_character_count','>=',$starter)->where('title_character_count','<=',$range);
            }
            if(!empty($request->category)){
                $query->where('category',$request->category);
            }
            if(!empty($request->brand)){
                $query->where('brand',$request->brand);
            }
            $title_result                   = $query->count();
            $title_report[$range_key]       = $title_result;
            // $number                         = ( $title_result / $data_count ) * 100;
            // $string                         = floatval($number);
            // $pers_result                    = number_format($string, 2, '.', '');
            // $title_pres_report[$range_key]  = $pers_result;
            $starter                        = $range + 1;
        }
        // Title Percentage Calculation
        $data_count = array_sum($title_report);
        if($data_count != 0){
            foreach($title as $range_key => $range){
                $number                         = ( $title_report[$range_key] / $data_count ) * 100;
                $string                         = floatval($number);
                $pers_result                    = number_format($string, 2, '.', '');
                $title_pres_report[$range_key]  = $pers_result;
            }
        }
        // Title Score Calculation
        if($data_count != 0){
            foreach($title_report as $range_key => $title_reports){
                $title_score_arr[] = $title_reports * $score[$range_key];
            }
            $title_score = round(array_sum($title_score_arr) / $data_count, 2);
        }else{
            $title_score = 0.00;
        }
        
        // description
        $starter = 0;
        foreach($description as $range_key => $range){
            $query = WebsiteData::where('website_id',$website_id);
            if($range_key == count( $description ) - 1){
                $query->where('description_word_count','>=',$range);
            }else{
                $query->where('description_word_count','>=',$starter)->where('description_word_count','<=',$range);
            }
            if(!empty($request->category)){
                $query->where('category',$request->category);
            }
            if(!empty($request->brand)){
                $query->where('brand',$request->brand);
            }
            $description_result = $query->count();
            // $description_result = WebsiteData::where('website_id',$website_id)->where('description_word_count',[$starter,$range])->count();
            $description_report[$range_key]         = $description_result;
            // $number                                 = ( $description_result / $data_count ) * 100;
            // $string                                 = floatval($number);
            // $pers_result                            = number_format($string, 2, '.', '');
            // $description_pres_report[$range_key]    = $pers_result;
            $starter                                = $range + 1;
        }
        $data_count = array_sum($description_report);
        if($data_count != 0){
            foreach($description as $range_key => $range){
                $number                                 = ( $description_report[$range_key] / $data_count ) * 100;
                $string                                 = floatval($number);
                $pers_result                            = number_format($string, 2, '.', '');
                $description_pres_report[$range_key]    = $pers_result;
            }
        }
        // Description Score Calculation
        if($data_count != 0){
            foreach($description_report as $range_key => $description_reports){
                $description_score_arr[] = $description_reports * $score[$range_key];
            }
            $description_score = round(array_sum($description_score_arr) / $data_count, 2);
        }else{
            $description_score = 0.00;
        }
        
        // feature
        $starter = 0;
        foreach($feature as $range_key => $range){
            $query = WebsiteData::where('website_id',$website_id);
            if($range_key == count( $feature ) - 1){
                $query->where('feature_count','>=',$range);
            }else{
                $query->where('feature_count','>=',$starter)->where('feature_count','<=',$range);
            }
            if(!empty($request->category)){
                $query->where('category',$request->category);
            }
            if(!empty($request->brand)){
                $query->where('brand',$request->brand);
            }
            $feature_result = $query->count();
            // $feature_result = WebsiteData::where('website_id',$website_id)->where('feature_count',[$starter,$range])->count();
            $feature_report[$range_key]         = $feature_result;
            // $number                             = ( $feature_result / $data_count ) * 100;
            // $string                             = floatval($number);
            // $pers_result                        = number_format($string, 2, '.', '');
            // $feature_pres_report[$range_key]    = $pers_result;
            $starter                            = $range + 1;
        }
        $data_count = array_sum($feature_report);
        if($data_count != 0){
            foreach($feature as $range_key => $range){
                $number                             = ( $feature_report[$range_key] / $data_count ) * 100;
                $string                             = floatval($number);
                $pers_result                        = number_format($string, 2, '.', '');
                $feature_pres_report[$range_key]    = $pers_result;
            }
        }
        // Feature Score Calculation
        if($data_count != 0){
            foreach($feature_report as $range_key => $feature_reports){
                $feature_score_arr[] = $feature_reports * $score[$range_key];
            }
            $feature_score = round(array_sum($feature_score_arr) / $data_count, 2);
        }else{
            $feature_score = 0.00;
        }

        // specification
        $starter = 0;
        foreach($specification as $range_key => $range){
            $query = WebsiteData::where('website_id',$website_id);
            if($range_key == count( $specification ) - 1){
                $query->where('specification_count','>=',$range);
            }else{
                $query->where('specification_count','>=',$starter)->where('specification_count','<=',$range);
            }
            if(!empty($request->category)){
                $query->where('category',$request->category);
            }
            if(!empty($request->brand)){
                $query->where('brand',$request->brand);
            }
            $specification_result = $query->count();
            // $specification_result = WebsiteData::where('website_id',$website_id)->where('specification_count',[$starter,$range])->count();
            $specification_report[$range_key]       = $specification_result;
            // $number                                 = ( $specification_result / $data_count ) * 100;
            // $string                                 = floatval($number);
            // $pers_result                            = number_format($string, 2, '.', '');
            // $specification_pres_report[$range_key]  = $pers_result;
            $starter                                = $range + 1;
        }
        $data_count = array_sum($specification_report);
        if($data_count != 0){
            foreach($specification as $range_key => $range){
                $number                                 = ( $specification_report[$range_key] / $data_count ) * 100;
                $string                                 = floatval($number);
                $pers_result                            = number_format($string, 2, '.', '');
                $specification_pres_report[$range_key]  = $pers_result;
            }
        }
        // Specification Score Calculation
        if($data_count != 0){
            foreach($specification_report as $range_key => $specification_reports){
                $specification_score_arr[] = $specification_reports * $score[$range_key];
            }
            $specification_score = round(array_sum($specification_score_arr) / $data_count, 2);
        }else{
            $specification_score = 0.00;
        }

        // image
        $starter = 0;
        foreach($image as $range_key => $range){
            $query = WebsiteData::where('website_id',$website_id);
            if($range_key == count( $image ) - 1){
                $query->where('image_count','>=',$range);
            }else{
                $query->where('image_count','>=',$starter)->where('image_count','<=',$range);
            }
            if(!empty($request->category)){
                $query->where('category',$request->category);
            }
            if(!empty($request->brand)){
                $query->where('brand',$request->brand);
            }
            $image_result = $query->count();
            // $image_result = WebsiteData::where('website_id',$website_id)->where('image_count',[$starter,$range])->count();
            $image_report[$range_key]       = $image_result;
            // $number                         = ( $image_result / $data_count ) * 100;
            // $string                         = floatval($number);
            // $pers_result                    = number_format($string, 2, '.', '');
            // $image_pres_report[$range_key]  = $pers_result;
            $starter                        = $range + 1;
        }
        $data_count = array_sum($image_report);
        if($data_count != 0){
            foreach($image as $range_key => $range){
                $number                         = ( $image_report[$range_key] / $data_count ) * 100;
                $string                         = floatval($number);
                $pers_result                    = number_format($string, 2, '.', '');
                $image_pres_report[$range_key]  = $pers_result;
            }
        }
         // Image Score Calculation
        if($data_count != 0){
            foreach($image_report as $range_key => $image_reports){
                $image_score_arr[] = $image_reports * $score[$range_key];
            }
            $image_score = round(array_sum($image_score_arr) / $data_count, 2);
        }else{
            $image_score = 0.00;
        }

        $content_score = 0;
        $content_count = 0;
        if($data[0]->title_status == 1){
            $content_score = $content_score + $title_score;
            $content_count++;
        }
        if($data[0]->description_status == 1){
            $content_score = $content_score + $description_score;
            $content_count++;
        }
        if($data[0]->feature_status == 1){
            $content_score = $content_score + $feature_score;
            $content_count++;
        }
        if($data[0]->specification_status == 1){
            $content_score = $content_score + $specification_score;
            $content_count++;
        }
        if($data[0]->image_status == 1){
            $content_score = $content_score + $image_score;
            $content_count++;
        }
        // dd($data[0]->title_status);
        // Over All Score Calculation
        // $overall_score = ( $title_score + $description_score + $feature_score + $specification_score + $image_score ) / 5;
        $overall_score = $content_score / $content_count;
        $overall_score = round($overall_score, 2);
        // dd($content_count);
        $total_sku = array_sum($title_report);
        
        //Set SKU's
        $input_arr=array(
           'title'=>array(1=>$title_report[0], 2=>$title_report[1], 3=>$title_report[2], 4=>$title_report[3], 5=>$title_report[4]),
           'description'=>array(1=>$description_report[0], 2=>$description_report[1], 3=>$description_report[2], 4=>$description_report[3], 5=>$description_report[4]),
           'feature'=>array(1=>$feature_report[0], 2=>$feature_report[1], 3=>$feature_report[2], 4=>$feature_report[3], 5=>$feature_report[4]),
           'spec'=>array(1=>$specification_report[0], 2=>$specification_report[1], 3=>$specification_report[2], 4=>$specification_report[3], 5=>$specification_report[4]),
           'images'=>array(1=>$image_report[0], 2=>$image_report[1], 3=>$image_report[2], 4=>$image_report[3], 5=>$image_report[4]),
           'overall'=>array(1=>$overall_score),
        );

        $category = $request->description_category;
        $Chart_notes = Note::where('website_id',$website_id)->where('status',0)->where('category',$category)->get();
        // dd($website_id);
        if(blank($Chart_notes) || blank($website_title_range) || blank($website_description_range) || blank($website_feature_range) || blank($website_specification_range) || blank($website_image_range) || !blank($request->category) || !blank($request->brand)){
                            
            // Declare Title Notes
            if($title_report[0] > 0){
                $title_notes0 = "<li>".$title_report[0]." SKUs - High Attention Required: The character count of the title must be increased to effectively communicate vital information about these products and their usage. It will ensure they catch the eye of potential customers and provide essential information.";
            }else{
                $title_notes0 = "";
            }

            if($title_report[1] > 0){
                $title_notes1 = "<li> ".$title_report[1]." SKUs - Needs Improvement: These titles can be improved by adding important attributes. It's essential to edit them to ensure they are concise, informative, and optimized to increase the CTR of potential customers";
            }else{
                $title_notes1 = "";
            }

            if($title_report[2] > 0){
                $title_notes2 = "<li> ".$title_report[2]." SKUs - Good to Improve: These products have titles of acceptable length but must be edited for better clarity. Clear and attention-grabbing titles are crucial in effectively promoting products in this industry.";
            }else{
                $title_notes2 = "";
            }

            if($title_report[3] > 0){
                $title_notes3 = "<li> ".$title_report[3]." SKUs - Average Optimized: While these SKU titles meet the acceptable length criteria, there is an opportunity for enhancement. By highlighting key details about the product, potential buyers can be enticed to click on the product listings.";
            }else{
                $title_notes3 = "";
            }

            // Declare Description Notes
            if($description_report[0] > 0){
                $description_notes0 = "<li> ".$description_report[0]." SKUs - High attention required: Capture the essence of the item by employing descriptive language that brings it to life. Showcase its exceptional qualities, unique features, and how it can elevate the item to the customer. Ensuring that the descriptions are detailed and informative will assist potential customers in making well-informed decisions.";
            }else{
                $description_notes0 = "";
            }

            if($description_report[1] > 0){
                $description_notes1 = "<li> ".$description_report[1]." SKUs - Needs Improvement:  Increase the number of words used in the descriptions for these SKUs to ensure that they are further optimized and have the most impactful descriptions possible. By doing so, potential customers can make informed decisions through the information provided.";
            }else{
                $description_notes1 = "";
            }

            if($description_report[2] > 0){
                $description_notes2 = "<li> ".$description_report[2]." SKUs - Good to Improve: Enhancing these SKUs to be more informative and ensuring all necessary details about the product are included will make them stand out to potential customers.";
            }else{
                $description_notes2 = "";
            }

            if($description_report[3] > 0){
                $description_notes3 = "<li> ".$description_report[3]." SKUs - Average Optimized: Although these SKU descriptions meet the required length, their impact can be enhanced. Cover all essential product details so that potential customers can confidently make informed decisions.";
            }else{
                $description_notes3 = "";
            }

            // Declare Feature Notes
            if($feature_report[0] > 0){
                $feature_notes0 = "<li> ".$feature_report[0]." SKUs - High attention required: Break down the product's features and benefits into easy-to-read bullet points. This format helps customers quickly scan and grasp the essential information.";
            }else{
                $feature_notes0 = "";
            }

            if($feature_report[1] > 0){
                $feature_notes1 = "<li> ".$feature_report[1]." SKUs - Needs Improvement: The number of feature bullets for these SKUs should be increased. This helps potential consumers make informed judgments about the product by being given complete information.";
            }else{
                $feature_notes1 = "";
            }

            if($feature_report[2] > 0){
                $feature_notes2 = "<li> ".$feature_report[2]." SKUs - Good to Improve: Although the feature bullets for these SKUs are within the range, there is room for improvement. Additional features will make your products stand out from the competition and draw in new customers.";
            }else{
                $feature_notes2 = "";
            }

            if($feature_report[3] > 0){
                $feature_notes3 = "<li> ".$feature_report[3]." SKUs - Average Optimized: The feature bullet counts for these SKUs are within the required range. However, giving prospective customers all the facts about the product can assist them in making purchasing decisions.";
            }else{
                $feature_notes3 = "";
            }

            // Declare Specification Notes
            if($specification_report[0] > 0){
                $specification_notes0 = "<li> ".$specification_report[0]." SKUs - High Attention Required: Product specification adds value to the product page and helps customers to take quick purchase decision and improve customer satisfaction.";
            }else{
                $specification_notes0 = "";
            }

            if($specification_report[1] > 0){
                $specification_notes1 = "<li> ".$specification_report[1]." SKUs - Needs Improvement: These SKUs need more specifications added. When more specifications are provided, it increases the buyer's chances to buy the product and increases sales.";
            }else{
                $specification_notes1 = "";
            }

            if($specification_report[2] > 0){
                $specification_notes2 = "<li> ".$specification_report[2]." SKUs - Good to Improve: Increase specifications to be comprehensive and informative, incorporating crucial product details. This differentiation will attract potential customers and set the product apart from competitors.";
            }else{
                $specification_notes2 = "";
            }

            if($specification_report[3] > 0){
                $specification_notes3 = "<li> ".$specification_report[3]." SKUs - Average Optimized: The product specifications of these SKUs meet count criteria but can be improved for comprehensive information. This enables well-informed decisions by potential customers regarding the product.";
            }else{
                $specification_notes3 = "";
            }

            // Declare Image Notes
            if($image_report[0] > 0){
                $image_notes0 = "<li> ".$image_report[0]." SKUs - High Attention Required: It is critical to add product images for these SKUs. A visual depiction of your product is vital in online selling to ensure customers can make quick buying decisions.";
            }else{
                $image_notes0 = "";
            }

            if($image_report[1] > 0){
                $image_notes1 = "<li> ".$image_report[1]." SKUs - Needs improvement: Increase the number of images for these SKUs. Images create an instant visual impact and attract the attention of potential customers. They make the product page visually appealing and engaging, enticing visitors to explore further.";
            }else{
                $image_notes1 = "";
            }

            if($image_report[2] > 0){
                $image_notes2 = "<li> ".$image_report[2]." SKUs - Good to Improve: While there are acceptable image counts in SKUs, there is room for improvement. Prioritize high-quality images to make an impact on potential customers.";
            }else{
                $image_notes2 = "";
            }

            if($image_report[3] > 0){
                $image_notes3 = "<li> ".$image_report[3]." SKUs - Average Optimized: The image counts of these SKUs are satisfactory, but adding more images will support sales and improve your customers' impression of your e-store.";
            }else{
                $image_notes3 = "";
            }

            $title_notes            = $title_notes0.$title_notes1.$title_notes2.$title_notes3;
            $description_notes      = $description_notes0.$description_notes1.$description_notes2.$description_notes3;
            $feature_notes          = $feature_notes0.$feature_notes1.$feature_notes2.$feature_notes3;
            $specification_notes    = $specification_notes0.$specification_notes1.$specification_notes2.$specification_notes3;
            $image_notes            = $image_notes0.$image_notes1.$image_notes2.$image_notes3;
            $overall_notes          = "<li> ".$overall_score." SKU's - High Attention Required: These SKUs require the highest attention, as their overall rating is below the ideal. It is recommended to revise the title, description, features, specifications, and images in order to improve the overall rating.";
        
        
            $notes = Note::where('website_id',$website_id)->get();
            
            if(blank($request->filter_status)){

                if(blank($notes)){
                    Note::create([
                        'website_id'            => $website_id,
                        'title_notes'           => $title_notes,
                        'description_notes'     => $description_notes,
                        'feature_notes'         => $feature_notes,
                        'specification_notes'   => $specification_notes,
                        'image_notes'           => $image_notes,
                        'overall_notes'         => $overall_notes,
                        'category'              => $category,
                    ]);
                }else{
                    Note::where('website_id',$website_id)->update([
                        'title_notes'           => $title_notes,
                        'description_notes'     => $description_notes,
                        'feature_notes'         => $feature_notes,
                        'specification_notes'   => $specification_notes,
                        'image_notes'           => $image_notes,
                        'overall_notes'         => $overall_notes,
                        'category'              => $category,
                    ]);
                }
                
            }
            
        
        }else{
            $title_notes = $Chart_notes[0]->title_notes;

            $description_notes = $Chart_notes[0]->description_notes;

            $feature_notes = $Chart_notes[0]->feature_notes;

            $specification_notes = $Chart_notes[0]->specification_notes;

            $image_notes = $Chart_notes[0]->image_notes;

            $overall_notes = $Chart_notes[0]->overall_notes;
        }


        // Common SKUs
        $common_sku = [];
            $range1_query = WebsiteData::where('website_id',$website_id);
            $range1_entry = 0;
            if($title_report[0] > 0){
                $range1_entry = $range1_entry + 1;
                $range1_query->where('title_character_count','>=',0)->where('title_character_count','<=',$request->title[0]);
            }
            if($description_report[0] > 0){
                $range1_entry = $range1_entry + 1;
                $range1_query->where('description_word_count','>=',0)->where('description_word_count','<=',$request->description[0]);
            }
            if($feature_report[0] > 0){
                $range1_entry = $range1_entry + 1;
                $range1_query->where('feature_count','>=',0)->where('feature_count','<=',$request->feature[0]);
            }
            if($specification_report[0] > 0){
                $range1_entry = $range1_entry + 1;
                $range1_query->where('specification_count','>=',0)->where('specification_count','<=',$request->specification[0]);
            }
            if($image_report[0] > 0){
                $range1_entry = $range1_entry + 1;
                $range1_query->where('image_count','>=',0)->where('image_count','<=',$request->image[0]);
            }
            if($range1_entry > 0){
                $common_sku[] = $range1_query->count();
            }else{
                $common_sku[] = 0;
            }

            // Range2
            $range2_query = WebsiteData::where('website_id',$website_id);
            $range2_entry = 0;
            if($title_report[1] > 0){
                $range2_entry = $range2_entry + 1;
                $from = $request->title[0] +1;
                $range2_query->where('title_character_count','>=',$from)->where('title_character_count','<=',$request->title[1]);
            }
            if($description_report[1] > 0){
                $range2_entry = $range2_entry + 1;
                $from = $request->description[0] +1;
                $range2_query->where('description_word_count','>=',$from)->where('description_word_count','<=',$request->description[1]);
            }
            if($feature_report[1] > 0){
                $range2_entry = $range2_entry + 1;
                $from = $request->feature[0] +1;
                $range2_query->where('feature_count','>=',$from)->where('feature_count','<=',$request->feature[1]);
            }
            if($specification_report[1] > 0){
                $range2_entry = $range2_entry + 1;
                $from = $request->specification[0] +1;
                $range2_query->where('specification_count','>=',$from)->where('specification_count','<=',$request->specification[1]);
            }
            if($image_report[1] > 0){
                $range2_entry = $range2_entry + 1;
                $from = $request->image[0] +1;
                $range2_query->where('image_count','>=',$from)->where('image_count','<=',$request->image[1]);
            }
            if($range2_entry > 0){
                $common_sku[] = $range2_query->count();
            }else{
                $common_sku[] = 0;
            }
            

            // Range3
            $range3_query = WebsiteData::where('website_id',$website_id);
            $range3_entry = 0; 
            if($title_report[2] > 0){
                $range3_entry = $range3_entry + 1;
                $from = $request->title[1] +1;
                $range3_query->where('title_character_count','>=',$from)->where('title_character_count','<=',$request->title[2]);
            }
            if($description_report[2] > 0){
                $range3_entry = $range3_entry + 1;
                $from = $request->description[1] +1;
                $range3_query->where('description_word_count','>=',$from)->where('description_word_count','<=',$request->description[2]);
            }
            if($feature_report[2] > 0){
                $range3_entry = $range3_entry + 1;
                $from = $request->feature[1] +1;
                $range3_query->where('feature_count','>=',$from)->where('feature_count','<=',$request->feature[2]);
            }
            if($specification_report[2] > 0){
                $range3_entry = $range3_entry + 1;
                $from = $request->specification[1] +1;
                $range3_query->where('specification_count','>=',$from)->where('specification_count','<=',$request->specification[2]);
            }
            if($image_report[2] > 0){
                $range3_entry = $range3_entry + 1;
                $from = $request->image[1] +1;
                $range3_query->where('image_count','>=',$from)->where('image_count','<=',$request->image[2]);
            }
            if($range3_entry > 0){
                $common_sku[] = $range3_query->count();
            }else{
                $common_sku[] = 0;
            }


            // Range4
            $range4_query = WebsiteData::where('website_id',$website_id);
            $range4_entry = 0; 
            if($title_report[3] > 0){
                $range4_entry = $range4_entry + 1;
                $from = $request->title[2] +1;
                $range4_query->where('title_character_count','>=',$from)->where('title_character_count','<=',$request->title[3]);
            }
            if($description_report[3] > 0){
                $range4_entry = $range4_entry + 1;
                $from = $request->description[2] +1;
                $range4_query->where('description_word_count','>=',$from)->where('description_word_count','<=',$request->description[3]);
            }
            if($feature_report[3] > 0){
                $range4_entry = $range4_entry + 1;
                $from = $request->feature[2] +1;
                $range4_query->where('feature_count','>=',$from)->where('feature_count','<=',$request->feature[3]);
            }
            if($specification_report[3] > 0){
                $range4_entry = $range4_entry + 1;
                $from = $request->specification[2] +1;
                $range4_query->where('specification_count','>=',$from)->where('specification_count','<=',$request->specification[3]);
            }
            if($image_report[3] > 0){
                $range4_entry = $range4_entry + 1;
                $from = $request->image[2] +1;
                $range4_query->where('image_count','>=',$from)->where('image_count','<=',$request->image[3]);
            }
            if($range4_entry > 0){
                $common_sku[] = $range4_query->count();
            }else{
                $common_sku[] = 0;
            }

            // Range5
            $range5_query = WebsiteData::where('website_id',$website_id);
            $range5_entry = 0; 
            if($title_report[4] > 0){
                $range5_entry = $range5_entry + 1;
                $range5_query->where('title_character_count','>=',$request->title[4]);
            }
            if($description_report[4] > 0){
                $range5_entry = $range5_entry + 1;
                $range5_query->where('description_word_count','>=',$request->description[3]);
            }
            if($feature_report[4] > 0){
                $range5_entry = $range5_entry + 1;
                $range5_query->where('feature_count','>=',$request->feature[3]);
            }
            if($specification_report[4] > 0){
                $range5_entry = $range5_entry + 1;
                $range5_query->where('specification_count','>=',$request->specification[3]);
            }
            if($image_report[4] > 0){
                $range5_entry = $range5_entry + 1;
                $range5_query->where('image_count','>=',$request->image[3]);
            }
            if($range5_entry > 0){
                $common_sku[] = $range5_query->count();
            }else{
                $common_sku[] = 0;
            }
            
        
        // dd($common_sku);
        
        // Rating
        $rating = WebsiteData::where('website_id',$website_id)->where('rating','=',0)->count();
        $data_count = WebsiteData::where('website_id',$website_id)->count();
        $rating_per = ( $rating / $data_count ) * 100;
        // $rating2 = WebsiteData::where('website_id',$website_id)->where('rating','>',1)->where('rating','<=',2)->count();
        // $rating3 = WebsiteData::where('website_id',$website_id)->where('rating','>',2)->where('rating','<=',3)->count();
        // $rating4 = WebsiteData::where('website_id',$website_id)->where('rating','>',3)->where('rating','<=',4)->count();
        // $rating5 = WebsiteData::where('website_id',$website_id)->where('rating','>',4)->where('rating','<=',5)->count();

        // QA Count
        $faq = WebsiteData::where('website_id',$website_id)->where('qa_count','=',0)->count();
        $faq_per = ( $faq / $data_count ) * 100;
        // $qa_count2 = WebsiteData::where('website_id',$website_id)->where('qa_count','>=',1)->where('qa_count','<=',5)->count();
        // $qa_count3 = WebsiteData::where('website_id',$website_id)->where('qa_count','>=',6)->where('qa_count','<=',10)->count();
        // $qa_count4 = WebsiteData::where('website_id',$website_id)->where('qa_count','>',10)->count();

        // Round Off
        $lesser_width_percentage = round($lesser_width_percentage);
        $img_alt_percentage = round($img_alt_percentage);
        $title_metadata_percentage = round($title_metadata_percentage);
        $description_metadata_percentage = round($description_metadata_percentage);
        $keywords_metadata_percentage = round($keywords_metadata_percentage);
        $rating_per = round($rating_per);
        $faq_per = round($faq_per);

        return view('report.index',compact('id','title_report','description_report','feature_report','common_sku',
        'specification_report','image_report','title_pres_report','description_pres_report','website_data',
        'feature_pres_report','specification_pres_report','image_pres_report','total_sku','price_status',
        'categories','brands','website_id','title','description','feature','specification','image','img_alt_percentage',
        'req_category','req_brand','website_name','category_count','brand_count','title_score','title_metadata_percentage','description_metadata_percentage','keywords_metadata_percentage',
        'description_score','feature_score','specification_score','image_score','overall_score','res_value',
        'title_notes','description_notes','feature_notes','specification_notes','image_notes','overall_notes',
        'title','description','feature','specification','image','data','total_image_count','greater_width_count','lesser_width_count','greater_height_count','lesser_height_count','title_metadata_count','description_metadata_count','keywords_metadata_count','keywords_metadata_length_count1',
        'keywords_metadata_length_count2','keywords_metadata_length_count3','lesser_width_percentage',
        'rating_per','faq_per'));
    }

    public function send_mail($id)
    {
        $encrypted = Crypt::encryptString($id);
        $url = config('app.url').'public/client/'.$encrypted;

        // Send Mail to Client
        $website    = Website::where('id',$id)->get();
        $email      = $website[0]->getClient->getUser->email;
        $first_name = $website[0]->getClient->getUser->first_name;
        
        // $email = "kesavaram@vservesolution.com";
        $mailData = [
            'first_name'    => $first_name,
            'website'       => $website[0]->website,
        ];
        Mail::to($email)->send(new ClientViewEmail($mailData));

        // Add Data History
        $user_id = auth()->user()->id;
        $data_history = DataHistory::create([
            'user_id'    => $user_id,
            'website_id' => $id,
            'action'     => 'Sent scrape report to client mail'
        ]);

        return redirect()->route('website.index')->with('success','Mail sent Successfully');
    }

    public function enhance_data(Request $request)
    {
        set_time_limit(180000000);
		ini_set('memory_limit', -1);

        // $this->validate($request, [
        //     'file' => 'required',
        // ]);

        $file           = $request->file('file');
        $extension      = $file->getClientOriginalExtension();
        $filename       = uniqid().'.'.$extension;
        
        $destinationPath = 'enhance-data';
        $file->move($destinationPath,$filename);

        $enhance = EnhancedData::create([
            'website_id'        => $request->website_id,
            'path'              => $filename,
        ]);

        $title_character_count  =0;
        $description_word_count =0;
        $load_file = public_path($destinationPath . "/" . $filename);
        
        if('csv' == $extension) {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        } else {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }
    
        $spreadsheet    = $reader->load($load_file);
        
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
                            // WebsiteFeature::create([
                            //     'website_id'        => $request->website_id,
                            //     'website_data_id'   => $data_id,
                            //     'feature'           => $sheetData[$feature_key]
                            // ]);
                        }
                    }
                    
                    // Specification Count Check
                    $specification_count = 0;
                    foreach($specification_keys as $res => $specification_key){ 
                        if(strlen($sheetData[$specification_key]) > 0){ 
                            $specification_count++;
                            // WebsiteSpecification::create([
                            //     'website_id'            => $request->website_id,
                            //     'website_data_id'       => $data_id,
                            //     'specification_head'    => $sheetData[$specification_key - 1],
                            //     'specification_value'   => $sheetData[$specification_key]
                            // ]);
                        }
                    }
                    
                    // Image Count Check
                    $image_count = 0;
                    foreach($image_keys as $res => $image_key){ 
                        if(strlen($sheetData[$image_key]) > 0){ 
                            $image_count++;
                            // WebsiteImage::create([
                            //     'website_id'        => $request->website_id,
                            //     'website_data_id'   => $data_id,
                            //     'image'             => $sheetData[$image_key]
                            // ]);
                        }
                    }
                    
                    // Category
                    if(strlen($sheetData[$category_index]) > 0){ 
                        $category = $sheetData[$category_index];
                    }else{
                        $category = 'Uncategory';
                    }

                    // Data Insert into WebsiteData table
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
                        'mpn'                       => $sheetData[$mpn_index],
                        'tag'                       => $sheetData[$tag_index],
                    ]);

                    // Feature Count Check
                    // foreach($feature_keys as $res => $feature_key){ 
                    //     if(strlen($sheetData[$feature_key]) > 0){ 
                    //         WebsiteFeature::create([
                    //             'website_id'        => $request->website_id,
                    //             'website_data_id'   => $website_data->id,
                    //             'feature'           => $sheetData[$feature_key]
                    //         ]);
                    //     }
                    // }
                    
                    // Specification Count Check
                    // foreach($specification_keys as $res => $specification_key){ 
                    //     if(strlen($sheetData[$specification_key]) > 0){ 
                    //         WebsiteSpecification::create([
                    //             'website_id'            => $request->website_id,
                    //             'website_data_id'       => $website_data->id,
                    //             'specification_head'    => $sheetData[$specification_key - 1],
                    //             'specification_value'   => $sheetData[$specification_key]
                    //         ]);
                    //     }
                    // }
                    
                    // Image Count Check
                    // foreach($image_keys as $res => $image_key){ 
                    //     if(strlen($sheetData[$image_key]) > 0){ 
                    //         WebsiteImage::create([
                    //             'website_id'        => $request->website_id,
                    //             'website_data_id'   => $website_data->id,
                    //             'image'             => $sheetData[$image_key]
                    //         ]);
                    //     }
                    // }
                }
            }
            // Add Data History
            $user_id = auth()->user()->id;
            $data_history = DataHistory::create([
                'user_id'       => $user_id,
                'website_id'    => $request->website_id,
                'action'        => 'Enhance file imported'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error','Invalid File');
        }

        DB::commit();
        
        return redirect()->back()->with('success','File Imported successfully');
    }

    public function enhance_result(Request $request, $id)
    {
        set_time_limit(180000000);
		ini_set('memory_limit', -1);
        function chat_gpt_output($input_arr)
        {
           $apiKey='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';
           $url = 'https://api.openai.com/v1/completions';
           $org_id='org-xIH4uI6Z6TUfESgmLUS8QIEh';
           $headers = array(
              "Authorization: Bearer {$apiKey}",
              "OpenAI-Organization: {$org_id}",
              "Content-Type: application/json"
           );
        
           // Define messages
           $messages = array();
        
           // Define data
           $data = array();
        
           $data["model"] = 'text-davinci-003';//"gpt-3.5-turbo";//'text-davinci-003';// 'text-ada-001';//cheapest.. 
        
           $data["max_tokens"] = 2200;
        
           $data["temperature"] = 0.7;
        
           $data["top_p"] =  1;
        
           $data["frequency_penalty"] =  0;
        
           $data["presence_penalty"] =  0;
        
           $data['prompt']="I need a detailed written suggestion on below as bullet points under each category with the provided numbers,
           1. Title character rating
              <li> ".$input_arr['title'][1]." SKUS - High attention required
              <li> ".$input_arr['title'][2]." SKUs - Needs improvement
              <li> ".$input_arr['title'][3]." SKUs - Good to improve
              <li> ".$input_arr['title'][4]." SKUs - Average optimized
              <li> ".$input_arr['title'][5]." SKUs - Optimized
           2. Description words rating
              <li> ".$input_arr['description'][1]." SKUS - High attention required
              <li> ".$input_arr['description'][2]." SKUs - Needs improvement
              <li> ".$input_arr['description'][3]." SKUs - Good to improve
              <li> ".$input_arr['description'][4]." SKUs - Average optimized
              <li> ".$input_arr['description'][5]." SKUs - Optimized
           3. Feature bullet count rating
              <li> ".$input_arr['feature'][1]." SKUS - High attention required
              <li> ".$input_arr['feature'][2]." SKUs - Needs improvement
              <li> ".$input_arr['feature'][3]." SKUs - Good to improve
              <li> ".$input_arr['feature'][4]." SKUs - Average optimized
              <li> ".$input_arr['feature'][5]." SKUs - Optimized
           4. Product specification rating
              <li> ".$input_arr['spec'][1]." SKUS - High attention required
              <li> ".$input_arr['spec'][2]." SKUs - Needs improvement
              <li> ".$input_arr['spec'][3]." SKUs - Good to improve
              <li> ".$input_arr['spec'][4]." SKUs - Average optimized
              <li> ".$input_arr['spec'][5]." SKUs - Optimized
           5. Image count rating
              <li> ".$input_arr['images'][1]." SKUS - High attention required
              <li> ".$input_arr['images'][2]." SKUs - Needs improvement
              <li> ".$input_arr['images'][3]." SKUs - Good to improve
              <li> ".$input_arr['images'][4]." SKUs - Average optimized
              <li> ".$input_arr['images'][5]." SKUs - Optimized
            6. Overall rating 
              <li> ".$input_arr['overall'][1]." out of 5";
              
           $messages[] = array("role" => "user", "content" => $data["prompt"]);
        
           // init curl
           $curl = curl_init($url);
           curl_setopt($curl, CURLOPT_POST, 1);
           curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
           curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
           curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        
           $result = curl_exec($curl);
           if (curl_errno($curl)) {
              echo 'Error:' . curl_error($curl);
              $return = 'Error';
           } else {
              $json_obj=json_decode($result);
              
            //   print_r($json_obj);
              
              $return = $json_obj->choices[0]->text;
              
              $return=str_replace("\r\n", "<p>", $return);
           }
           curl_close($curl);
           return $return;
        }
        if(!empty($request->website_id)){
            $website_id = $request->id;
        }else{
            $website_id = Crypt::decryptString($id);
        }
        $title                      = [40,60,70,80,81];
        $description                = [30,60,80,100,101];
        $feature                    = [0,2,3,4,5];
        $specification              = [0,2,3,4,5];
        $image                      = [0,2,3,4,5];
        $title_report               = [0,0,0,0,0];
        $description_report         = [0,0,0,0,0];
        $feature_report             = [0,0,0,0,0];
        $specification_report       = [0,0,0,0,0];
        $image_report               = [0,0,0,0,0];
        $title_pres_report          = [0,0,0,0,0];
        $description_pres_report    = [0,0,0,0,0];
        $feature_pres_report        = [0,0,0,0,0];
        $specification_pres_report  = [0,0,0,0,0];
        $image_pres_report          = [0,0,0,0,0];
        $score                      = [1,2,3,4,5];
        // $overall_data_count         = WebsiteData::where('website_id',$website_id)->count();
        $starter                    = 0;
        $categories                 = WebsiteEnhanceData::select('category')->where('website_id',$website_id)->where('category','!=',null)->groupBy('category')->get();
        $category_count             = count($categories);
        $brands                     = WebsiteEnhanceData::select('brand')->where('website_id',$website_id)->where('brand','!=',null)->groupBy('brand')->get();        
        $brand_count                = count($brands);
        $website_name               = Website::where('id',$website_id)->value('website');
        $req_category               = '';
        $req_brand                  = '';
        $price_status               = ClientPrice::where('website_id',$website_id)->get();
        $website_data               = Website::with('getNotes')->where('id',$website_id)->get();

        if(!empty($request->category)){
            $req_category = $request->category;
        }
        if(!empty($request->brand)){
            $req_brand = $request->brand;
        }

        $query = WebsiteData::where('website_id',$website_id);
        if(!empty($request->category)){
            $query->where('category',$request->category);
        }
        if(!empty($request->brand)){
            $query->where('brand',$request->brand);
        }
        $res_value = $query->count();

        // title
        foreach($title as $range_key => $range){
            $query = WebsiteEnhanceData::where('website_id',$website_id);
            if($range_key == count( $title ) - 1){
                $query->where('title_character_count','>=',$range);
            }else{
                $query->where('title_character_count','>=',$starter)->where('title_character_count','<=',$range);
            }
            if(!empty($request->category)){
                $query->where('category',$request->category);
            }
            if(!empty($request->brand)){
                $query->where('brand',$request->brand);
            }
            $title_result                   = $query->count();
            $title_report[$range_key]       = $title_result;
            // $number                         = ( $title_result / $data_count ) * 100;
            // $string                         = floatval($number);
            // $pers_result                    = number_format($string, 2, '.', '');
            // $title_pres_report[$range_key]  = $pers_result;
            $starter                        = $range + 1;
        }
        // Title Percentage Calculation
        $data_count = array_sum($title_report);
        if($data_count != 0){
            foreach($title as $range_key => $range){
                $number                         = ( $title_report[$range_key] / $data_count ) * 100;
                $string                         = floatval($number);
                $pers_result                    = number_format($string, 2, '.', '');
                $title_pres_report[$range_key]  = $pers_result;
            }
        }
        // Title Score Calculation
        if($data_count != 0){
            foreach($title_report as $range_key => $title_reports){
                $title_score_arr[] = $title_reports * $score[$range_key];
            }
            $title_score = round(array_sum($title_score_arr) / $data_count, 2);
        }else{
            $title_score = 0.00;
        }
        
        // description
        $starter = 0;
        foreach($description as $range_key => $range){
            $query = WebsiteEnhanceData::where('website_id',$website_id);
            if($range_key == count( $description ) - 1){
                $query->where('description_word_count','>=',$range);
            }else{
                $query->where('description_word_count','>=',$starter)->where('description_word_count','<=',$range);
            }
            if(!empty($request->category)){
                $query->where('category',$request->category);
            }
            if(!empty($request->brand)){
                $query->where('brand',$request->brand);
            }
            $description_result = $query->count();
            // $description_result = WebsiteEnhanceData::where('website_id',$website_id)->where('description_word_count',[$starter,$range])->count();
            $description_report[$range_key]         = $description_result;
            // $number                                 = ( $description_result / $data_count ) * 100;
            // $string                                 = floatval($number);
            // $pers_result                            = number_format($string, 2, '.', '');
            // $description_pres_report[$range_key]    = $pers_result;
            $starter                                = $range + 1;
        }
        $data_count = array_sum($description_report);
        if($data_count != 0){
            foreach($description as $range_key => $range){
                $number                                 = ( $description_report[$range_key] / $data_count ) * 100;
                $string                                 = floatval($number);
                $pers_result                            = number_format($string, 2, '.', '');
                $description_pres_report[$range_key]    = $pers_result;
            }
        }
        // Description Score Calculation
        if($data_count != 0){
            foreach($description_report as $range_key => $description_reports){
                $description_score_arr[] = $description_reports * $score[$range_key];
            }
            $description_score = round(array_sum($description_score_arr) / $data_count, 2);
        }else{
            $description_score = 0.00;
        }

        // feature
        $starter = 0;
        foreach($feature as $range_key => $range){
            $query = WebsiteEnhanceData::where('website_id',$website_id);
            if($range_key == count( $feature ) - 1){
                $query->where('feature_count','>=',$range);
            }else{
                $query->where('feature_count','>=',$starter)->where('feature_count','<=',$range);
            }
            if(!empty($request->category)){
                $query->where('category',$request->category);
            }
            if(!empty($request->brand)){
                $query->where('brand',$request->brand);
            }
            $feature_result = $query->count();
            // $feature_result = WebsiteEnhanceData::where('website_id',$website_id)->where('feature_count',[$starter,$range])->count();
            $feature_report[$range_key]         = $feature_result;
            // $number                             = ( $feature_result / $data_count ) * 100;
            // $string                             = floatval($number);
            // $pers_result                        = number_format($string, 2, '.', '');
            // $feature_pres_report[$range_key]    = $pers_result;
            $starter                            = $range + 1;
        }
        $data_count = array_sum($feature_report);
        if($data_count != 0){
            foreach($feature as $range_key => $range){
                $number                             = ( $feature_report[$range_key] / $data_count ) * 100;
                $string                             = floatval($number);
                $pers_result                        = number_format($string, 2, '.', '');
                $feature_pres_report[$range_key]    = $pers_result;
            }
        }
        // Feature Score Calculation
        if($data_count != 0){
            foreach($feature_report as $range_key => $feature_reports){
                $feature_score_arr[] = $feature_reports * $score[$range_key];
            }
            $feature_score = round(array_sum($feature_score_arr) / $data_count, 2);
        }else{
            $feature_score = 0.00;
        }

        // specification
        $starter = 0;
        foreach($specification as $range_key => $range){
            $query = WebsiteEnhanceData::where('website_id',$website_id);
            if($range_key == count( $specification ) - 1){
                $query->where('specification_count','>=',$range);
            }else{
                $query->where('specification_count','>=',$starter)->where('specification_count','<=',$range);
            }
            if(!empty($request->category)){
                $query->where('category',$request->category);
            }
            if(!empty($request->brand)){
                $query->where('brand',$request->brand);
            }
            $specification_result = $query->count();
            // $specification_result = WebsiteEnhanceData::where('website_id',$website_id)->where('specification_count',[$starter,$range])->count();
            $specification_report[$range_key]       = $specification_result;
            // $number                                 = ( $specification_result / $data_count ) * 100;
            // $string                                 = floatval($number);
            // $pers_result                            = number_format($string, 2, '.', '');
            // $specification_pres_report[$range_key]  = $pers_result;
            $starter                                = $range + 1;
        }
        $data_count = array_sum($specification_report);
        if($data_count != 0){
            foreach($specification as $range_key => $range){
                $number                                 = ( $specification_report[$range_key] / $data_count ) * 100;
                $string                                 = floatval($number);
                $pers_result                            = number_format($string, 2, '.', '');
                $specification_pres_report[$range_key]  = $pers_result;
            }
        }
        // Specification Score Calculation
        if($data_count != 0){
            foreach($specification_report as $range_key => $specification_reports){
                $specification_score_arr[] = $specification_reports * $score[$range_key];
            }
            $specification_score = round(array_sum($specification_score_arr) / $data_count, 2);
        }else{
            $specification_score = 0.00;
        }

        // image
        $starter = 0;
        foreach($image as $range_key => $range){
            $query = WebsiteEnhanceData::where('website_id',$website_id);
            if($range_key == count( $image ) - 1){
                $query->where('image_count','>=',$range);
            }else{
                $query->where('image_count','>=',$starter)->where('image_count','<=',$range);
            }
            if(!empty($request->category)){
                $query->where('category',$request->category);
            }
            if(!empty($request->brand)){
                $query->where('brand',$request->brand);
            }
            $image_result = $query->count();
            // $image_result = WebsiteEnhanceData::where('website_id',$website_id)->where('image_count',[$starter,$range])->count();
            $image_report[$range_key]       = $image_result;
            // $number                         = ( $image_result / $data_count ) * 100;
            // $string                         = floatval($number);
            // $pers_result                    = number_format($string, 2, '.', '');
            // $image_pres_report[$range_key]  = $pers_result;
            $starter                        = $range + 1;
        }
        $data_count = array_sum($image_report);
        if($data_count != 0){
            foreach($image as $range_key => $range){
                $number                         = ( $image_report[$range_key] / $data_count ) * 100;
                $string                         = floatval($number);
                $pers_result                    = number_format($string, 2, '.', '');
                $image_pres_report[$range_key]  = $pers_result;
            }
        }
         // Image Score Calculation
        if($data_count != 0){
            foreach($image_report as $range_key => $image_reports){
                $image_score_arr[] = $image_reports * $score[$range_key];
            }
            $image_score = round(array_sum($image_score_arr) / $data_count, 2);
        }else{
            $image_score = 0.00;
        }

        // Over All Score Calculation
        $overall_score = ( $title_score + $description_score + $feature_score + $specification_score + $image_score ) / 5;
        $overall_score = round($overall_score, 2);

        $total_sku = array_sum($title_report);
        // Set SKU's
        $input_arr=array(
           'title'=>array(1=>$title_report[0], 2=>$title_report[1], 3=>$title_report[2], 4=>$title_report[3], 5=>$title_report[4]),
           'description'=>array(1=>$description_report[0], 2=>$description_report[1], 3=>$description_report[2], 4=>$description_report[3], 5=>$description_report[4]),
           'feature'=>array(1=>$feature_report[0], 2=>$feature_report[1], 3=>$feature_report[2], 4=>$feature_report[3], 5=>$feature_report[4]),
           'spec'=>array(1=>$specification_report[0], 2=>$specification_report[1], 3=>$specification_report[2], 4=>$specification_report[3], 5=>$specification_report[4]),
           'images'=>array(1=>$image_report[0], 2=>$image_report[1], 3=>$image_report[2], 4=>$image_report[3], 5=>$image_report[4]),
           'overall'=>array(1=>$overall_score),
        );
        $Chart_notes = Note::where('website_id',$website_id)->where('status',1)->get();
        if(blank($Chart_notes)){
        
            $chat_gpt_output=chat_gpt_output($input_arr);
            // dd($chat_gpt_output);
            $result_arr = explode("Rating",$chat_gpt_output);
            if(empty($result_arr)){
                $result_arr = explode("Rating:",$chat_gpt_output);
            }
            $title_notes = $result_arr[1];
            $description_notes = $result_arr[2];
            $feature_notes = $result_arr[3];
            $specification_notes = $result_arr[4];
            $image_notes = $result_arr[5];
            $overall_notes = $result_arr[6];
            
            $title_notes = str_replace("2. Description Words", ' ', $title_notes);
            $title_notes = str_replace("Description Words", ' ', $title_notes);
            
            $description_notes = str_replace("3. Feature Bullet Count", ' ', $description_notes);
            $description_notes = str_replace("Feature Bullet Count", ' ', $description_notes);
            
            $feature_notes = str_replace("4. Product Specification", ' ', $feature_notes);
            $feature_notes = str_replace("Product Specification", ' ', $feature_notes);
            
            $specification_notes = str_replace("5. Image Count", ' ', $specification_notes);
            $specification_notes = str_replace("Image Count", ' ', $specification_notes);

            $image_notes = str_replace("6. Overall", ' ', $image_notes);
            $image_notes = str_replace("Overall", ' ', $image_notes);
            
            $overall_notes = $overall_notes;
            $notes = Note::where('website_id',$website_id)->where('status',1)->get();
            if(blank($notes)){
                Note::create([
                    'website_id'            => $website_id,
                    'status'                => 1,
                    'title_notes'           => $title_notes,
                    'description_notes'     => $description_notes,
                    'feature_notes'         => $feature_notes,
                    'specification_notes'   => $specification_notes,
                    'image_notes'           => $image_notes,
                    'overall_notes'         => $overall_notes,
                ]);
            }else{
                Note::where('website_id',$website_id)->update([
                    'title_notes'           => $title_notes,
                    'description_notes'     => $description_notes,
                    'feature_notes'         => $feature_notes,
                    'specification_notes'   => $specification_notes,
                    'image_notes'           => $image_notes,
                    'overall_notes'         => $overall_notes,
                ]);
            }
            
        
        }else{
            $title_notes = $Chart_notes[0]->title_notes;

            $description_notes = $Chart_notes[0]->description_notes;

            $feature_notes = $Chart_notes[0]->feature_notes;

            $specification_notes = $Chart_notes[0]->specification_notes;

            $image_notes = $Chart_notes[0]->image_notes;

            $overall_notes = $Chart_notes[0]->overall_notes;
        }
        return view('report.index',compact('id','title_report','description_report','feature_report',
        'specification_report','image_report','title_pres_report','description_pres_report','website_data',
        'feature_pres_report','specification_pres_report','image_pres_report','total_sku','price_status',
        'categories','brands','website_id','title','description','feature','specification','image',
        'req_category','req_brand','website_name','category_count','brand_count','title_score',
        'description_score','feature_score','specification_score','image_score','overall_score','res_value',
        'title_notes','description_notes','feature_notes','specification_notes','image_notes','overall_notes'));
    }

    public function delete_scrape_data($id)
    {
        if(!empty($request->website_id)){
            $website_id = $request->id;
        }else{
            $website_id = Crypt::decryptString($id);
        }

        DB::beginTransaction();
        try {
            WebsiteData::where('website_id',$website_id)->delete();
            WebsiteFeature::where('website_id',$website_id)->delete();
            WebsiteSpecification::where('website_id',$website_id)->delete();
            WebsiteImage::where('website_id',$website_id)->delete();
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
        }

        DB::commit();

        return redirect()->route('website.index');
    }

    public function download_client_data($id)
    {
        if(!empty($request->website_id)){
            $website_id = $request->id;
        }else{
            $website_id = Crypt::decryptString($id);
        }

        // Add Data History
        $user_id = auth()->user()->id;
        $data_history = DataHistory::create([
            'user_id'    => $user_id,
            'website_id' => $website_id,
            'action'     => 'Support - download client selected data'
        ]);

        $data = Website::with('getClientRequestData')->where('id',$website_id)->get();

        $file_name = $data[0]->getClientRequestData->path;
        $file = public_path(). '/client-requirements/'.$file_name;

        return response()->download($file, $file_name, ['content-type' => 'text/cvs']);
        
    }
}
