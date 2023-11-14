<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\ExportBatch;
use App\Models\ClientRequirement;
use App\Models\ClientRequestData;
use App\Models\Website;
use App\Models\WebsiteRange;
use App\Models\WebsiteEnhanceData;
use App\Models\ClientPrice;
use Excel;

class ExportController extends Controller
{
    public function download_batch(Request $request)
    {
        // dd($request->role);
        $batch_id   = $request->batch;
        $status     = $request->batch_status;
        $file_name  = uniqid().'.xlsx'; 
        
        if(auth()->user()->getrole->name == 'Team Lead'){
            $user_role = $request->role;
        }else{
            $user_role  = auth()->user()->getrole->name;
        }

        $title_sku1 = [];
        $title_sku2 = []; 
        $title_sku3 = [];
        $title_sku4 = [];
        $title_sku5 = [];
        $description_sku1 = [];
        $description_sku2 = [];
        $description_sku3 = [];
        $description_sku4 = [];
        $description_sku5 = [];
        $feature_sku1 = [];
        $feature_sku2 = [];
        $feature_sku3 = [];
        $feature_sku4 = [];
        $feature_sku5 = [];
        $specification_sku1 = [];
        $specification_sku2 = [];
        $specification_sku3 = [];
        $specification_sku4 = [];
        $specification_sku5 = [];
        $image_sku1 = [];
        $image_sku2 = [];
        $image_sku3 = [];
        $image_sku4 = [];
        $image_sku5 = [];

        $id = $request->website_id;

        $db_title           = WebsiteRange::where('website_id',$id)->where('content','title')->get();
        $db_description     = WebsiteRange::where('website_id',$id)->where('content','description')->get();
        $db_feature         = WebsiteRange::where('website_id',$id)->where('content','feature')->get();
        $db_specification   = WebsiteRange::where('website_id',$id)->where('content','specification')->get();
        $db_image           = WebsiteRange::where('website_id',$id)->where('content','image')->get();
        
        $title_range            = [$db_title[0]->high_attention_required,$db_title[0]->needs_improvement,$db_title[0]->good_to_improve,$db_title[0]->average_optimized,$db_title[0]->optimized];
        $description_range      = [$db_description[0]->high_attention_required,$db_description[0]->needs_improvement,$db_description[0]->good_to_improve,$db_description[0]->average_optimized,$db_description[0]->optimized];
        $feature_range          = [$db_feature[0]->high_attention_required,$db_feature[0]->needs_improvement,$db_feature[0]->good_to_improve,$db_feature[0]->average_optimized,$db_feature[0]->optimized];
        $specification_range    = [$db_specification[0]->high_attention_required,$db_specification[0]->needs_improvement,$db_specification[0]->good_to_improve,$db_specification[0]->average_optimized,$db_specification[0]->optimized];
        $image_range            = [$db_image[0]->high_attention_required,$db_image[0]->needs_improvement,$db_image[0]->good_to_improve,$db_image[0]->average_optimized,$db_image[0]->optimized];

        // dd($id);
        $client_requirements = ClientRequirement::where('website_id',$id)->get();

        foreach($client_requirements as $client_requirement){
            $client_prices[] = ClientPrice::where('id',$client_requirement->client_price_id)->get();
        }

        foreach($client_prices as  $key => $client_price){
            // Get Title SKU's
            if($client_price[0]->content_id == 1 && $client_price[0]->range_id == 1){
                // $title_sku1 = WebsiteData::where('website_id',$id)->where('title_character_count','>=',0)->where('title_character_count','<=',40)->get();
                $title_sku1 = WebsiteEnhanceData::where('website_id',$id)->where('title_character_count','>=',0)->where('title_character_count','<=',$title_range[0])->pluck('id')->toArray();
            }
            if($client_price[0]->content_id == 1 && $client_price[0]->range_id == 2){
                $title_sku2 = WebsiteEnhanceData::where('website_id',$id)->where('title_character_count','>=',++$title_range[0])->where('title_character_count','<=',$title_range[1])->pluck('id')->toArray();
            }
            if($client_price[0]->content_id == 1 && $client_price[0]->range_id == 3){
                $title_sku3 = WebsiteEnhanceData::where('website_id',$id)->where('title_character_count','>=',++$title_range[1])->where('title_character_count','<=',$title_range[2])->pluck('id')->toArray();
            }
            if($client_price[0]->content_id == 1 && $client_price[0]->range_id == 4){
                $title_sku4 = WebsiteEnhanceData::where('website_id',$id)->where('title_character_count','>=',++$title_range[2])->where('title_character_count','<=',$title_range[3])->pluck('id')->toArray();
            }
            if($client_price[0]->content_id == 1 && $client_price[0]->range_id == 5){
                $title_sku5 = WebsiteEnhanceData::where('website_id',$id)->where('title_character_count','>=',$title_range[4])->pluck('id')->toArray();
            }

            // Get Description SKU's
            if($client_price[0]->content_id == 2 && $client_price[0]->range_id == 1){
                $description_sku1 = WebsiteEnhanceData::where('website_id',$id)->where('description_word_count','>=',0)->where('description_word_count','<=',$description_range[0])->pluck('id')->toArray();
            }
            if($client_price[0]->content_id == 2 && $client_price[0]->range_id == 2){
                $description_sku2 = WebsiteEnhanceData::where('website_id',$id)->where('description_word_count','>=',++$description_range[0])->where('description_word_count','<=',$description_range[1])->pluck('id')->toArray();
            }
            if($client_price[0]->content_id == 2 && $client_price[0]->range_id == 3){
                $description_sku3 = WebsiteEnhanceData::where('website_id',$id)->where('description_word_count','>=',++$description_range[1])->where('description_word_count','<=',$description_range[2])->pluck('id')->toArray();
            }
            if($client_price[0]->content_id == 2 && $client_price[0]->range_id == 4){
                $description_sku4 = WebsiteEnhanceData::where('website_id',$id)->where('description_word_count','>=',++$description_range[2])->where('description_word_count','<=',$description_range[3])->pluck('id')->toArray();
            }
            if($client_price[0]->content_id == 2 && $client_price[0]->range_id == 5){
                $description_sku5 = WebsiteEnhanceData::where('website_id',$id)->where('description_word_count','>=',$description_range[4])->pluck('id')->toArray();
            }

            // Get Feature SKU's
            if($client_price[0]->content_id == 3 && $client_price[0]->range_id == 1){
                $feature_sku1 = WebsiteEnhanceData::where('website_id',$id)->where('feature_count','>=',0)->where('feature_count','<=',$feature_range[0])->pluck('id')->toArray();
            }
            if($client_price[0]->content_id == 3 && $client_price[0]->range_id == 2){
                $feature_sku2 = WebsiteEnhanceData::where('website_id',$id)->where('feature_count','>=',++$feature_range[0])->where('feature_count','<=',$feature_range[1])->pluck('id')->toArray();
            }
            if($client_price[0]->content_id == 3 && $client_price[0]->range_id == 3){
                $feature_sku3 = WebsiteEnhanceData::where('website_id',$id)->where('feature_count','>=',++$feature_range[1])->where('feature_count','<=',$feature_range[2])->pluck('id')->toArray();
            }
            if($client_price[0]->content_id == 3 && $client_price[0]->range_id == 4){
                $feature_sku4 = WebsiteEnhanceData::where('website_id',$id)->where('feature_count','>=',++$feature_range[2])->where('feature_count','<=',$feature_range[3])->pluck('id')->toArray();
            }
            if($client_price[0]->content_id == 3 && $client_price[0]->range_id == 5){
                $feature_sku5 = WebsiteEnhanceData::where('website_id',$id)->where('feature_count','>=',$feature_range[4])->pluck('id')->toArray();
            }

             // Get Specification SKU's
             if($client_price[0]->content_id == 4 && $client_price[0]->range_id == 1){
                $specification_sku1 = WebsiteEnhanceData::where('website_id',$id)->where('specification_count','>=',0)->where('specification_count','<=',$specification_range[0])->pluck('id')->toArray();
            }
            if($client_price[0]->content_id == 4 && $client_price[0]->range_id == 2){
                $specification_sku2 = WebsiteEnhanceData::where('website_id',$id)->where('specification_count','>=',++$specification_range[0])->where('specification_count','<=',$specification_range[1])->pluck('id')->toArray();
            }
            if($client_price[0]->content_id == 4 && $client_price[0]->range_id == 3){
                $specification_sku3 = WebsiteEnhanceData::where('website_id',$id)->where('specification_count','>=',++$specification_range[1])->where('specification_count','<=',$specification_range[2])->pluck('id')->toArray();
            }
            if($client_price[0]->content_id == 4 && $client_price[0]->range_id == 4){
                $specification_sku4 = WebsiteEnhanceData::where('website_id',$id)->where('specification_count','>=',++$specification_range[2])->where('specification_count','<=',$specification_range[3])->pluck('id')->toArray();
            }
            if($client_price[0]->content_id == 4 && $client_price[0]->range_id == 5){
                $specification_sku5 = WebsiteEnhanceData::where('website_id',$id)->where('specification_count','>=',$specification_range[4])->pluck('id')->toArray();
            }

            // Get Image SKU's
            if($client_price[0]->content_id == 5 && $client_price[0]->range_id == 1){
                $image_sku1 = WebsiteEnhanceData::where('website_id',$id)->where('image_count','>=',0)->where('image_count','<=',$image_range[0])->pluck('id')->toArray();
            }
            if($client_price[0]->content_id == 5 && $client_price[0]->range_id == 2){
                $image_sku2 = WebsiteEnhanceData::where('website_id',$id)->where('image_count','>=',++$image_range[0])->where('image_count','<=',$image_range[1])->pluck('id')->toArray();
            }
            if($client_price[0]->content_id == 5 && $client_price[0]->range_id == 3){
                $image_sku3 = WebsiteEnhanceData::where('website_id',$id)->where('image_count','>=',++$image_range[1])->where('image_count','<=',$image_range[2])->pluck('id')->toArray();
            }
            if($client_price[0]->content_id == 5 && $client_price[0]->range_id == 4){
                $image_sku4 = WebsiteEnhanceData::where('website_id',$id)->where('image_count','>=',++$image_range[2])->where('image_count','<=',$image_range[3])->pluck('id')->toArray();
            }
            if($client_price[0]->content_id == 5 && $client_price[0]->range_id == 5){
                $image_sku5 = WebsiteEnhanceData::where('website_id',$id)->where('image_count','>=',$image_range[4])->pluck('id')->toArray();
            }
        }

        return Excel::download(new ExportBatch($batch_id,$user_role,$status,$title_sku1,$title_sku2,$title_sku3,$title_sku4,$title_sku5,
        $description_sku1,$description_sku2,$description_sku3,$description_sku4,$description_sku5,
        $feature_sku1,$feature_sku2,$feature_sku3,$feature_sku4,$feature_sku5,
        $specification_sku1,$specification_sku2,$specification_sku3,$specification_sku4,$specification_sku5,
        $image_sku1,$image_sku2,$image_sku3,$image_sku4,$image_sku5), $file_name);
    }
}
