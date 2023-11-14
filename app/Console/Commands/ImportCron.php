<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use Session;
use App\Models\CronJob;
use App\Models\ScraperData;
use App\Models\Website;
use App\Models\WebsiteData;
use App\Models\ClientPrice;
use App\Models\ClientRequirement;
use App\Models\ClientRequestData;
use App\Models\EnhancedData;
use App\Models\DataHistory;
use App\Models\WebsiteEnhanceData;
use DB;
use Illuminate\Support\Facades\Crypt;
use App\Mail\EnhancedEmail;
use Illuminate\Support\Facades\Mail;
use App\Exports\DataExport;
use Excel;
use App\Models\WebsiteFeature;
use App\Models\WebsiteSpecification;
use App\Models\WebsiteImage;
use App\Mail\ClientViewEmail;
use App\Mail\NotificationMail;
use App\Mail\ImportStatusEmail;

class ImportCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */


    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        // Continue Scrapping
        $exist_cron = CronJob::where('status',1)->get()->first();  
        if(!blank($exist_cron)){
            $website_id         = $exist_cron->website_id;
            $scrappe_file_id    = $exist_cron->scrappe_file_id;
            $scrappe_file       = ScraperData::where('id',$scrappe_file_id)->value('path');
            $arr_file = explode('.', $scrappe_file);
            $extension = end($arr_file);
            
            if('csv' == $extension) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }
            $spreadsheet        = $reader->load(public_path('scraper-data/'.$scrappe_file));
            $sheetDatas         = $spreadsheet->getActiveSheet()->toArray();
            $file_data_count    = count($sheetDatas);
            $db_data_count      = WebsiteData::where('website_id',$website_id)->count();
            $start              = $db_data_count+1;
            $end                = $start+10000;
            if($end >= $file_data_count){
                $end = $file_data_count;
            }

            if($db_data_count == $file_data_count-1){
                CronJob::where('website_id',$website_id)->update([
                    'status' => 2,
                ]);
                $email = "testing@vserve.co"; 
                // $email2 = "kesavaram@vservesolution.com";
                $website = Website::where('id',$website_id)->value('website');
                $mailData = [
                    'content'   => 'Your Requested to import for '.$website.' is Done.',
                ];
                Mail::to($email)->send(new ImportStatusEmail($mailData));
                // Mail::to($email2)->send(new ClientViewEmail($mailData));
            }else{
                \Log::info("Enter existing import");
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
                        $img_dimension_index        = array_search("image_dimensions",$sheetData);
                        $img_size_index             = array_search("image_sizes",$sheetData);
                        $img_alt_index              = array_search("image_alt",$sheetData);
                        $title_metadata_index       = array_search("title_metadata",$sheetData);
                        $description_metadata_index = array_search("description_metadata",$sheetData);
                        $keywords_metadata_index    = array_search("keywords_metadata",$sheetData);
                        $rating_index               = array_search("star_rating",$sheetData);
                        $rating_count_index         = array_search("total_rating_count",$sheetData);
                        $qa_count_index             = array_search("total_qa_count",$sheetData);

                        // Column Name Validation
                        if($title_index                 == false ||
                        $brand_index                    == false ||
                        $category_index                 == false ||
                        $description_index              == false ||
                        $feature_start_index            == false ||
                        $feature_end_index              == false ||
                        $specification_start_index      == false ||
                        $specification_end_index        == false ||
                        $image_start_index              == false ||
                        $image_end_index                == false ||
                        $p_id_index                     == false ||
                        $mpn_index                      == false ||
                        $img_dimension_index            == false ||
                        $img_size_index                 == false ||
                        $img_alt_index                  == false ||
                        $title_metadata_index           == false ||
                        $description_metadata_index     == false ||
                        $keywords_metadata_index        == false ||
                        $rating_index                   == false ||
                        $rating_count_index             == false ||
                        $qa_count_index                 == false ||
                        $tag_index                   == false){
                            $email = "testing@vserve.co"; 
                            $website = Website::where('id',$website_id)->value('website');
                            CronJob::where('website_id',$website_id)->update([
                                'status' => 3,
                            ]);
                            $mailData = [
                                'content'   => 'Your Requested to import for '.$website.' has Invalid Column.',
                            ];
                            Mail::to($email)->send(new ImportStatusEmail($mailData));
                            \Log::info("Invalid Column");
                            exit;
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
                        
                    }elseif($key >= $start && $key < $end){

                        // Generate Image Dimension Array
                        $image_jsonString = $sheetData[$img_dimension_index];
                        $image_array = explode(",", $image_jsonString);
                        $width_arr = [];
                        $height_arr = [];
        
                        foreach($image_array as $arrays){
                            $newString = str_replace("[", "", $arrays);
                            $newString = str_replace("'", "", $newString);
                            $newString = str_replace("]", "", $newString);
                            $new_array = explode("x", $newString);
                            $width = $new_array[0];
                            $height = $new_array[1];
                            array_push($width_arr, $width);
                            array_push($height_arr, $height);                    
                        }

                        // Generate Image Size Array
                        $jsonString = $sheetData[$img_size_index];
                        $array = explode(",", $jsonString);
                        $size_arr = [];
        
                        foreach($array as $arrays){
                            $newString = str_replace("[", "", $arrays);
                            $newString = str_replace("'", "", $newString);
                            $newString = str_replace("]", "", $newString);
                            
                            array_push($size_arr, $newString);
                        }

                        $string = $sheetData[$img_alt_index];
                        $alt_arr = json_decode($string, true);
                        
                        if ($alt_arr === null) {
                            // Handle JSON decoding error
                            \Log::info("Error decoding JSON string");
                            
                        } else {
                            \Log::info($alt_arr[0]);
                            // print_r($array);
                        }

                        if(strlen($sheetData[$url_index]) > 0){
                            // Title Character Count Check
                            $title_character_count = 0;
                            if($sheetData[$title_index]){ 
                                $title_character_count = strlen($sheetData[$title_index]);
                            }
                            
                            // Description Word Count Check
                            $description_word_count = 0;
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
                                    //     'website_id'        => $website_id,
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
                                    //     'website_id'            => $website_id,
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
                                    //     'website_id'        => $website_id,
                                    //     'website_data_id'   => $data_id,
                                    //     'image'             => $sheetData[$image_key]
                                    // ]);
                                }
                            }

                            // title_metadata length Check
                            $title_metadata_length = 0;
                            if($sheetData[$title_metadata_index]){ 
                                $title_metadata_length = strlen($sheetData[$title_metadata_index]);
                            }

                            // description_metadata length Check
                            $description_metadata_length = 0;
                            if($sheetData[$description_metadata_index]){ 
                                $description_metadata_length = strlen($sheetData[$description_metadata_index]);
                            }

                            // keywords_metadata Count Check
                            $keywords_metadata_count = 0;
                            if($sheetData[$keywords_metadata_index]){ 
                                $str_arr = explode(",",$sheetData[$keywords_metadata_index]);
                                $keywords_metadata_count=count($str_arr);
                                // $keywords_metadata_count = strlen($sheetData[$keywords_metadata_index]);
                            }
                            
                            // Category
                            if(strlen($sheetData[$category_index]) > 0){ 
                                $category = $sheetData[$category_index];
                            }else{
                                $category = 'Uncategory';
                            }

                            // Rating
                            if($sheetData[$rating_index] === null){
                                $rating = 0;
                            }else{
                                $rating = $sheetData[$rating_index];
                            }

                            // Rating Count
                            if($sheetData[$rating_count_index] === null){
                                $rating_count = 0;
                            }else{
                                $rating_count = $sheetData[$rating_count_index];
                            }

                            // QA Count
                            if($sheetData[$qa_count_index] === null){
                                $qa_count = 0;
                            }else{
                                $qa_count = $sheetData[$qa_count_index];
                            }
                            
                            // Data Insert into WebsiteData table
                            $website_data = WebsiteData::create([
                                'website_id'                    => $website_id,
                                'title'                         => $sheetData[$title_index],
                                'description'                   => $sheetData[$description_index],
                                'title_metadata'                => $sheetData[$title_metadata_index],
                                'description_metadata'          => $sheetData[$description_metadata_index],
                                'keywords_metadata'             => $sheetData[$keywords_metadata_index],
                                'title_metadata_length'         => $title_metadata_length,
                                'description_metadata_length'   => $description_metadata_length,
                                'keywords_metadata_length'      => $keywords_metadata_count,
                                'rating'                        => $rating,
                                'rating_count'                  => $rating_count,
                                'qa_count'                      => $qa_count,
                                'brand'                         => $sheetData[$brand_index],
                                'category'                      => $category,
                                'title_character_count'         => $title_character_count,
                                'description_word_count'        => $description_word_count,
                                'feature_count'                 => $feature_count,
                                'specification_count'           => $specification_count,
                                'image_count'                   => $image_count,
                                'url'                           => $sheetData[$url_index],
                                'p_id'                          => $sheetData[$p_id_index],
                                'mpn'                           => $sheetData[$mpn_index],
                                'tag'                           => $sheetData[$tag_index],
                            ]);

                            // Insert Feature to website_features Table
                            foreach($feature_keys as $res => $feature_key){ 
                                if(strlen($sheetData[$feature_key]) > 0){ 
                                    WebsiteFeature::create([
                                        'website_id'        => $website_id,
                                        'website_data_id'   => $website_data->id,
                                        'feature'           => $sheetData[$feature_key]
                                    ]);
                                }
                            }
                            
                            // Insert Specification to website_specifications Table
                            foreach($specification_keys as $res => $specification_key){ 
                                if(strlen($sheetData[$specification_key]) > 0){ 
                                    WebsiteSpecification::create([
                                        'website_id'            => $website_id,
                                        'website_data_id'       => $website_data->id,
                                        'specification_head'    => $sheetData[$specification_key - 1],
                                        'specification_value'   => $sheetData[$specification_key]
                                    ]);
                                }
                            }
                            
                            // Insert Image to website_images Table
                            foreach($image_keys as $res => $image_key){ 
                                if(strlen($sheetData[$image_key]) > 0){ 
                                    WebsiteImage::create([
                                        'website_id'        => $website_id,
                                        'website_data_id'   => $website_data->id,
                                        'image'             => $sheetData[$image_key],
                                        'width'             => $width_arr[$res],
                                        'height'            => $height_arr[$res],
                                        'size'              => $size_arr[$res],
                                        'alt'               => $alt_arr[$res],
                                    ]);
                                }
                            }
                        }
                        \Log::info($key." "."Added");
                    } 
                }
            }
        }
        
        // Initial Scrapping
        $new_cron = CronJob::where('status',0)->get()->first();
        \Log::info("Not Enter");
        if(!blank($new_cron)){
            \Log::info("Enter new");
            $website_id         = $new_cron->website_id;
            $scrappe_file_id    = $new_cron->scrappe_file_id;
            $scrappe_file       = ScraperData::where('id',$scrappe_file_id)->value('path');
            
            $arr_file = explode('.', $scrappe_file);
            $extension = end($arr_file);
            \Log::info("before reading");
            if('csv' == $extension) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }
            $spreadsheet        = $reader->load(public_path('scraper-data/'.$scrappe_file));
            $sheetDatas         = $spreadsheet->getActiveSheet()->toArray();
            $file_data_count    = count($sheetDatas);
            \Log::info($file_data_count);
            if($file_data_count<=10000){
                \Log::info("Enter below 10000");
                CronJob::where('website_id',$website_id)->update([
                    'status' => 1
                ]);
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
                        $img_dimension_index        = array_search("image_dimensions",$sheetData);
                        $img_size_index             = array_search("image_sizes",$sheetData);
                        $img_alt_index              = array_search("image_alt",$sheetData);
                        $title_metadata_index       = array_search("title_metadata",$sheetData);
                        $description_metadata_index = array_search("description_metadata",$sheetData);
                        $keywords_metadata_index    = array_search("keywords_metadata",$sheetData);
                        $rating_index               = array_search("star_rating",$sheetData);
                        $rating_count_index         = array_search("total_rating_count",$sheetData);
                        $qa_count_index             = array_search("total_qa_count",$sheetData);
                        
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
                        $img_dimension_index            == false ||
                        $img_size_index                 == false ||
                        $img_alt_index                  == false ||
                        $title_metadata_index           == false ||
                        $description_metadata_index     == false ||
                        $keywords_metadata_index        == false ||
                        $rating_index                   == false ||
                        $rating_count_index             == false ||
                        $qa_count_index                 == false ||
                        $tag_index                   == false){
                            // \Log::info("Invalid Column");
                            // $email = "kesavaram@vservesolution.com";
                            // $website = Website::where('id',$website_id)->value('website');
                            // $mailData = [
                            //     'website'   => $website
                            // ];
                            // Mail::to($email)->send(new NotificationMail($mailData));
                            // exit;
                            $email = "testing@vserve.co"; 
                            $website = Website::where('id',$website_id)->value('website');
                            CronJob::where('website_id',$website_id)->update([
                                'status' => 3,
                            ]);
                            $mailData = [
                                'content'   => 'Your Requested to import for '.$website.' has Invalid Column.',
                            ];
                            Mail::to($email)->send(new ImportStatusEmail($mailData));
                            \Log::info("Invalid Column");
                            exit;
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

                        // Generate Image Dimension Array
                        $image_jsonString = $sheetData[$img_dimension_index];
                        $image_array = explode(",", $image_jsonString);
                        $width_arr = [];
                        $height_arr = [];
        
                        foreach($image_array as $arrays){
                            $newString = str_replace("[", "", $arrays);
                            $newString = str_replace("'", "", $newString);
                            $newString = str_replace("]", "", $newString);
                            $new_array = explode("x", $newString);
                            $width = $new_array[0];
                            $height = $new_array[1];
                            array_push($width_arr, $width);
                            array_push($height_arr, $height);                    
                        }

                        // Generate Image Size Array
                        $jsonString = $sheetData[$img_size_index];
                        $array = explode(",", $jsonString);
                        $size_arr = [];
        
                        foreach($array as $arrays){
                            $newString = str_replace("[", "", $arrays);
                            $newString = str_replace("'", "", $newString);
                            $newString = str_replace("]", "", $newString);
                            
                            array_push($size_arr, $newString);
                        }

                        // Image alt array generate
                        $string = $sheetData[$img_alt_index];
                        $alt_arr = json_decode($string, true);
                        
                        if ($alt_arr === null) {
                            // Handle JSON decoding error
                            \Log::info("Error decoding JSON string");
                            
                        } else {
                            \Log::info($alt_arr[0]);
                            // print_r($array);
                        }


                        if(strlen($sheetData[$url_index]) > 0){
                            // Title Character Count Check
                            $title_character_count = 0;
                            if($sheetData[$title_index]){ 
                                $title_character_count = strlen($sheetData[$title_index]);
                            }
                            
                            // Description Word Count Check
                            $description_word_count = 0;
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

                            // title_metadata length Check
                            $title_metadata_length = 0;
                            if($sheetData[$title_metadata_index]){ 
                                $title_metadata_length = strlen($sheetData[$title_metadata_index]);
                            }

                            // description_metadata length Check
                            $description_metadata_length = 0;
                            if($sheetData[$description_metadata_index]){ 
                                $description_metadata_length = strlen($sheetData[$description_metadata_index]);
                            }

                            // keywords_metadata Count Check
                            $keywords_metadata_count = 0;
                            if($sheetData[$keywords_metadata_index]){ 
                                $str_arr = explode(",",$sheetData[$keywords_metadata_index]);
                                $keywords_metadata_count=count($str_arr);
                                // $keywords_metadata_count = strlen($sheetData[$keywords_metadata_index]);
                            }
                            
                            // Category
                            if(strlen($sheetData[$category_index]) > 0){ 
                                $category = $sheetData[$category_index];
                            }else{
                                $category = 'Uncategory';
                            }

                            // Rating
                            if($sheetData[$rating_index] === null){
                                $rating = 0;
                            }else{
                                $rating = $sheetData[$rating_index];
                            }

                            // Rating Count
                            if($sheetData[$rating_count_index] === null){
                                $rating_count = 0;
                            }else{
                                $rating_count = $sheetData[$rating_count_index];
                            }

                            // QA Count
                            if($sheetData[$qa_count_index] === null){
                                $qa_count = 0;
                            }else{
                                $qa_count = $sheetData[$qa_count_index];
                            }
        
                            
                            // Data Insert into WebsiteData table
                            $website_data = WebsiteData::create([
                                'website_id'                    => $website_id,
                                'title'                         => $sheetData[$title_index],
                                'description'                   => $sheetData[$description_index],
                                'title_metadata'                => $sheetData[$title_metadata_index],
                                'description_metadata'          => $sheetData[$description_metadata_index],
                                'keywords_metadata'             => $sheetData[$keywords_metadata_index],
                                'title_metadata_length'         => $title_metadata_length,
                                'description_metadata_length'   => $description_metadata_length,
                                'keywords_metadata_length'      => $keywords_metadata_count,
                                'rating'                        => $rating,
                                'rating_count'                  => $rating_count,
                                'qa_count'                      => $qa_count,
                                'brand'                         => $sheetData[$brand_index],
                                'category'                      => $category,
                                'title_character_count'         => $title_character_count,
                                'description_word_count'        => $description_word_count,
                                'feature_count'                 => $feature_count,
                                'specification_count'           => $specification_count,
                                'image_count'                   => $image_count,
                                'url'                           => $sheetData[$url_index],
                                'p_id'                          => $sheetData[$p_id_index],
                                'mpn'                           => $sheetData[$mpn_index],
                                'tag'                           => $sheetData[$tag_index],
                            ]);
        
                            // Insert Feature to website_features Table
                            foreach($feature_keys as $res => $feature_key){ 
                                if(strlen($sheetData[$feature_key]) > 0){ 
                                    WebsiteFeature::create([
                                        'website_id'        => $website_id,
                                        'website_data_id'   => $website_data->id,
                                        'feature'           => $sheetData[$feature_key]
                                    ]);
                                }
                            }
                            
                            // Insert Specification to website_specifications Table
                            foreach($specification_keys as $res => $specification_key){ 
                                if(strlen($sheetData[$specification_key]) > 0){ 
                                    WebsiteSpecification::create([
                                        'website_id'            => $website_id,
                                        'website_data_id'       => $website_data->id,
                                        'specification_head'    => $sheetData[$specification_key - 1],
                                        'specification_value'   => $sheetData[$specification_key]
                                    ]);
                                }
                            }
                            
                            // Insert Image to website_images Table
                            foreach($image_keys as $res => $image_key){ 
                                if(strlen($sheetData[$image_key]) > 0){ 
                                    WebsiteImage::create([
                                        'website_id'        => $website_id,
                                        'website_data_id'   => $website_data->id,
                                        'image'             => $sheetData[$image_key],
                                        'width'             => $width_arr[$res],
                                        'height'            => $height_arr[$res],
                                        'size'              => $size_arr[$res],
                                        'alt'               => $alt_arr[$res],
                                    ]);
                                }
                            }
                            \Log::info($key. " "."Added");
                        }
                    }
                } // End Foreach
                
                // Delete cron job after importing
                $db_data_count = WebsiteData::where('website_id',$website_id)->count();
                if($db_data_count == $file_data_count-1){
                    CronJob::where('website_id',$website_id)->update([
                        'status' => 2,
                    ]);
                    // Add Data History
                    $data_history = DataHistory::create([
                        'website_id'    => $website_id,
                        'action'        => 'Cron Job is Done'
                    ]);
                    $email = "testing@vserve.co"; 
                    $website = Website::where('id',$website_id)->value('website');
                    $mailData = [
                        'content'   => 'Your Requested to import for '.$website.' is Done.',
                    ];
                    Mail::to($email)->send(new ImportStatusEmail($mailData));
                    // $email1 = "nandhini@vservesolution.com";
                    // $email2 = "kesavaram@vservesolution.com";
                    // $website = Website::where('id',$website_id)->value('website');
                    // $mailData = [
                    //     'website'   => $website
                    // ];
                    // Mail::to($email1)->send(new ClientViewEmail($mailData));
                    // Mail::to($email2)->send(new ClientViewEmail($mailData));
                }
            }else{
                \Log::info("Enter above 10000 loop");
                // Update cron job status
                CronJob::where('website_id',$website_id)->update([
                    'status' => 1
                ]);
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
                        $img_dimension_index        = array_search("image_dimensions",$sheetData);
                        $img_size_index             = array_search("image_sizes",$sheetData);
                        $img_alt_index              = array_search("image_alt",$sheetData);
                        $title_metadata_index       = array_search("title_metadata",$sheetData);
                        $description_metadata_index = array_search("description_metadata",$sheetData);
                        $keywords_metadata_index    = array_search("keywords_metadata",$sheetData);
                        $rating_index               = array_search("star_rating",$sheetData);
                        $rating_count_index         = array_search("total_rating_count",$sheetData);
                        $qa_count_index             = array_search("total_qa_count",$sheetData);

                        // Column Name Validation
                        if($title_index                 == false ||
                        $brand_index                    == false ||
                        $category_index                 == false ||
                        $description_index              == false ||
                        $feature_start_index            == false ||
                        $feature_end_index              == false ||
                        $specification_start_index      == false ||
                        $specification_end_index        == false ||
                        $image_start_index              == false ||
                        $image_end_index                == false ||
                        $p_id_index                     == false ||
                        $mpn_index                      == false ||
                        $img_dimension_index            == false ||
                        $img_size_index                 == false ||
                        $img_alt_index                  == false ||
                        $title_metadata_index           == false ||
                        $description_metadata_index     == false ||
                        $keywords_metadata_index        == false ||
                        $rating_index                   == false ||
                        $rating_count_index             == false ||
                        $qa_count_index                 == false ||
                        $tag_index                   == false){
                            $email = "testing@vserve.co"; 
                            $website = Website::where('id',$website_id)->value('website');
                            CronJob::where('website_id',$website_id)->update([
                                'status' => 3,
                            ]);
                            $mailData = [
                                'content'   => 'Your Requested to import for '.$website.' has Invalid Column.',
                            ];
                            Mail::to($email)->send(new ImportStatusEmail($mailData));
                            \Log::info("Invalid Column");
                            exit;
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
                        
                    }elseif($key <= 10000){
                        // Generate Image Dimension Array
                        $image_jsonString = $sheetData[$img_dimension_index];
                        $image_array = explode(",", $image_jsonString);
                        $width_arr = [];
                        $height_arr = [];
        
                        foreach($image_array as $arrays){
                            $newString = str_replace("[", "", $arrays);
                            $newString = str_replace("'", "", $newString);
                            $newString = str_replace("]", "", $newString);
                            $new_array = explode("x", $newString);
                            $width = $new_array[0];
                            $height = $new_array[1];
                            array_push($width_arr, $width);
                            array_push($height_arr, $height);                    
                        }

                        // Generate Image Size Array
                        $jsonString = $sheetData[$img_size_index];
                        $array = explode(",", $jsonString);
                        $size_arr = [];
        
                        foreach($array as $arrays){
                            $newString = str_replace("[", "", $arrays);
                            $newString = str_replace("'", "", $newString);
                            $newString = str_replace("]", "", $newString);
                            
                            array_push($size_arr, $newString);
                        }

                        $string = $sheetData[$img_alt_index];
                        $alt_arr = json_decode($string, true);
                        
                        if ($alt_arr === null) {
                            // Handle JSON decoding error
                            \Log::info("Error decoding JSON string");
                            
                        } else {
                            \Log::info($alt_arr[0]);
                            // print_r($array);
                        }


                        if(strlen($sheetData[$url_index]) > 0){
                            // Title Character Count Check
                            $title_character_count = 0;
                            if($sheetData[$title_index]){ 
                                $title_character_count = strlen($sheetData[$title_index]);
                            }
                            
                            // Description Word Count Check
                            $description_word_count = 0;
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

                            
                            // title_metadata length Check
                            $title_metadata_length = 0;
                            if($sheetData[$title_metadata_index]){ 
                                $title_metadata_length = strlen($sheetData[$title_metadata_index]);
                            }

                            // description_metadata length Check
                            $description_metadata_length = 0;
                            if($sheetData[$description_metadata_index]){ 
                                $description_metadata_length = strlen($sheetData[$description_metadata_index]);
                            }

                            // keywords_metadata Count Check
                            $keywords_metadata_count = 0;
                            if($sheetData[$keywords_metadata_index]){ 
                                $str_arr = explode(",",$sheetData[$keywords_metadata_index]);
                                $keywords_metadata_count=count($str_arr);
                                // $keywords_metadata_count = strlen($sheetData[$keywords_metadata_index]);
                            }
                            
                            // Category
                            if(strlen($sheetData[$category_index]) > 0){ 
                                $category = $sheetData[$category_index];
                            }else{
                                $category = 'Uncategory';
                            }

                            // Rating
                            if($sheetData[$rating_index] === null){
                                $rating = 0;
                            }else{
                                $rating = $sheetData[$rating_index];
                            }

                            // Rating Count
                            if($sheetData[$rating_count_index] === null){
                                $rating_count = 0;
                            }else{
                                $rating_count = $sheetData[$rating_count_index];
                            }

                            // QA Count
                            if($sheetData[$qa_count_index] === null){
                                $qa_count = 0;
                            }else{
                                $qa_count = $sheetData[$qa_count_index];
                            }

                            
                            // Data Insert into WebsiteData table
                            $website_data = WebsiteData::create([
                                'website_id'                    => $website_id,
                                'title'                         => $sheetData[$title_index],
                                'description'                   => $sheetData[$description_index],
                                'title_metadata'                => $sheetData[$title_metadata_index],
                                'description_metadata'          => $sheetData[$description_metadata_index],
                                'keywords_metadata'             => $sheetData[$keywords_metadata_index],
                                'title_metadata_length'         => $title_metadata_length,
                                'description_metadata_length'   => $description_metadata_length,
                                'keywords_metadata_length'      => $keywords_metadata_count,
                                'rating'                        => $rating,
                                'rating_count'                  => $rating_count,
                                'qa_count'                      => $qa_count,
                                'brand'                         => $sheetData[$brand_index],
                                'category'                      => $category,
                                'title_character_count'         => $title_character_count,
                                'description_word_count'        => $description_word_count,
                                'feature_count'                 => $feature_count,
                                'specification_count'           => $specification_count,
                                'image_count'                   => $image_count,
                                'url'                           => $sheetData[$url_index],
                                'p_id'                          => $sheetData[$p_id_index],
                                'mpn'                           => $sheetData[$mpn_index],
                                'tag'                           => $sheetData[$tag_index],
                            ]);

                            // Insert Feature to website_features Table
                            foreach($feature_keys as $res => $feature_key){ 
                                if(strlen($sheetData[$feature_key]) > 0){ 
                                    WebsiteFeature::create([
                                        'website_id'        => $website_id,
                                        'website_data_id'   => $website_data->id,
                                        'feature'           => $sheetData[$feature_key]
                                    ]);
                                }
                            }
                            
                            // Insert Specification to website_specifications Table
                            foreach($specification_keys as $res => $specification_key){ 
                                if(strlen($sheetData[$specification_key]) > 0){ 
                                    WebsiteSpecification::create([
                                        'website_id'            => $website_id,
                                        'website_data_id'       => $website_data->id,
                                        'specification_head'    => $sheetData[$specification_key - 1],
                                        'specification_value'   => $sheetData[$specification_key]
                                    ]);
                                }
                            }
                            
                            // Insert Image to website_images Table
                            foreach($image_keys as $res => $image_key){ 
                                if(strlen($sheetData[$image_key]) > 0){ 
                                    WebsiteImage::create([
                                        'website_id'        => $website_id,
                                        'website_data_id'   => $website_data->id,
                                        'image'             => $sheetData[$image_key],
                                        'width'             => $width_arr[$res],
                                        'height'            => $height_arr[$res],
                                        'size'              => $size_arr[$res],
                                        'alt'               => $alt_arr[$res],
                                    ]);
                                }
                            }
                            \Log::info($key." "."SKU added");
                        }
                    }
                } // End Foreach
            }

        }
        
    }
}
