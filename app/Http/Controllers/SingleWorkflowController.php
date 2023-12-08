<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\Website;
use App\Models\WebsiteEnhanceData;
use App\Models\WebsiteEnhanceFeature;
use App\Models\WebsiteEnhanceSpecification;
use App\Models\WebsiteEnhanceImage;
use DB;
use Carbon\Carbon;

class SingleWorkflowController extends Controller
{
    public function sku($id){
        $sku_id     = Crypt::decryptString($id);
        $website_id = WebsiteEnhanceData::where('id',$sku_id)->value('website_id');
        $time_track = Website::where('id',$website_id)->value('time_track');
        
        if($time_track ==1){
            WebsiteEnhanceData::where('id',$sku_id)->update([
                'pa_started_at' => Carbon::now(),
            ]);
        }
        
        $data = WebsiteEnhanceData::where('id',$sku_id)->get();
        return view('single_workflow.steps',compact('data'));
    }

    public function update_sku(Request $request){
        
        $sku_id             = $request->sku_id;
        $feature_arr        = explode("<li>", $request->feature);
        $specification_arr  = explode("<li>", $request->specification);
        $image_arr          = $request->img_src;
        if($request->pa_done){
            $pa_done = $request->pa_done;
            $qc_done = 0;
            WebsiteEnhanceData::where('id',$sku_id)->update([
                'pa_ended_at' => Carbon::now(),
            ]);
        }else{
            $pa_done = 0;
            $qc_done = null;
        }
        // dd($specification_arr);
        DB::beginTransaction();
        try {
            // Delete Exsisting data
            WebsiteEnhanceFeature::where('website_enhance_data_id',$sku_id)->delete();
            WebsiteEnhanceSpecification::where('website_enhance_data_id',$sku_id)->delete();
            WebsiteEnhanceImage::where('website_enhance_data_id',$sku_id)->delete();
            
            // Update WebsiteEnhanceData
            WebsiteEnhanceData::where('id',$sku_id)->update([
                'title'                 => $request->title,
                'description'           => $request->description,
                'brand'                 => $request->brand,
                'pa_done'               => $pa_done,
                'qc_done'               => $qc_done,
                'title_metadata'        => $request->meta_title,
                'description_metadata'  => $request->meta_description,
                'keywords_metadata'     => $request->meta_keywords,
            ]);

            // Update WebsiteEnhanceFeature
            foreach($feature_arr as $key => $feature){
                if($key != 0){
                    $feature = str_replace("</li>", "", $feature);
                    $feature = str_replace("</ul>", "", $feature);
                    WebsiteEnhanceFeature::create([
                        'website_enhance_data_id'   => $sku_id,
                        'feature'                   => $feature,
                    ]);
                }
            }

            // Update WebsiteEnhanceFeature
            foreach($specification_arr as $key => $specification){
                if($key != 0){
                    $specification = str_replace("</li>", "", $specification);
                    $specification = str_replace("</ul>", "", $specification);
                    $specification = explode("=", $specification);
                    WebsiteEnhanceSpecification::create([
                        'website_enhance_data_id'   => $sku_id,
                        'specification_head'        => $specification[0],
                        'specification_value'       => $specification[1],
                    ]);
                }
            }

            // Update WebsiteEnhanceFeature
            foreach($image_arr as $key => $image){
                WebsiteEnhanceImage::create([
                    'website_enhance_data_id'   => $sku_id,
                    'image'                     => $image,
                ]);
            }

        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error','Something went Wrong');
            DB::rollback();
        }

        DB::commit();
        
        $enc_id = Crypt::encryptString($sku_id);
        $data = WebsiteEnhanceData::where('id',$sku_id)->get();
        return redirect()->route('sku',$enc_id)->with('success','SKU Updated Successfully!!!');
    }
}
