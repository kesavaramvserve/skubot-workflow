<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\Website;
use App\Models\WebsiteEnhanceData;
use App\Models\WebsiteEnhanceFeature;
use App\Models\WebsiteEnhanceSpecification;
use App\Models\WebsiteEnhanceImage;
use App\Models\DigitalAsset;
use App\Models\ProjectUser;
use DB;
use Carbon\Carbon;

class SingleWorkflowController extends Controller
{
    public function sku($id){
        $user_id        = auth()->user()->id;
        $sku_id         = Crypt::decryptString($id);
        $website_id     = WebsiteEnhanceData::where('id',$sku_id)->value('website_id');
        $pa_started_at  = WebsiteEnhanceData::where('id',$sku_id)->value('pa_started_at');
        $time_track     = Website::where('id',$website_id)->value('time_track');
        $project_role   = ProjectUser::where('website_id',$website_id)->where('user_id',$user_id)->value('user_role');
        
        if($time_track ==1 && $pa_started_at == null){
            WebsiteEnhanceData::where('id',$sku_id)->update([
                'pa_started_at' => Carbon::now(),
            ]);
        }
        
        $data                   = WebsiteEnhanceData::where('id',$sku_id)->get();
        $img_src                = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','img_src')->get();
        $data_360               = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','data_360')->get();
        $spec_sheet             = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','spec_sheet')->get();
        $part_drawing           = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','part_drawing')->get();  
        $brochure               = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','brochure')->get();
        $catalog_page           = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','catalog_page')->get();
        $white_paper            = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','white_paper')->get();
        $warranty_document      = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','warranty_document')->get();
        $installation_manual    = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','installation_manual')->get();
        $how_to_document        = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','how_to_document')->get();
        $selection_guide        = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','selection_guide')->get();
        $video                  = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','video')->get();

        return view('single_workflow.steps',compact('project_role','website_id','data','img_src','data_360','spec_sheet','part_drawing','brochure','catalog_page','white_paper','warranty_document','installation_manual','how_to_document','selection_guide','video'));
    }

    public function update_sku(Request $request){
        $user_id            = auth()->user()->id;
        $website_id         = $request->website_id;
        $sku_id             = $request->sku_id;
        $feature_arr        = explode("<li>", $request->feature);
        $specification_arr  = explode("<li>", $request->specification);
        $image_arr          = $request->img_src;
        $download_status    = $request->download_status;
        $project_role       = ProjectUser::where('website_id',$website_id)->where('user_id',$user_id)->value('user_role');
        $pa_done            = $request->db_pa_done;
        $qc_done            = $request->db_qc_done;
        $qa_done            = $request->db_qa_done;
        $complete_status    = $request->pa_done;
        
        // Digital Asset Upload
        function digital_image_upload($imageUrl,$mpn,$imgname) {

            if ($url = parse_url($imageUrl)) {
                $extension = pathinfo($url['path'], PATHINFO_EXTENSION);
            }
    
            $extensionsList = array("jpg", "jpeg", "png", "gif", "tif", "pdf");
            $graybar_id=$mpn;
    
            if (in_array(strtolower($extension), $extensionsList)) {
                $local_image = $graybar_id.'_'.$imgname.'.'.$extension; 
            } else {
                if($this->check_image_type($imageUrl)){
                    $ext = $this->check_image_type($imageUrl);
                }else{
                    $ext = '.jpg';				
                }
                $local_image = $graybar_id.'_'.$imgname . $ext;
            }
    
            $remote_image = file_get_contents($imageUrl);
    
            if (!file_exists('digital_asset_images/'.$graybar_id)) {
                mkdir('digital_asset_images/'.$graybar_id, 0777, true);
            }
    
            if ($http_response_header != NULL) {
                file_put_contents("digital_asset_images/".$graybar_id."/" . $local_image, $remote_image);
            }
    
            return $local_image;
    
        }    
       
        DB::beginTransaction();
        try {
            
            if($request->pa_done){
                // PA Complete
                if($project_role == 'PA'){
                    $pa_done = $request->pa_done;
                    $qc_done = 0;
                    WebsiteEnhanceData::where('id',$sku_id)->update([
                        'pa_ended_at' => Carbon::now(),
                    ]);
                }
                // QC Complete
                if($project_role == 'QC'){
                    $qc_done = $request->pa_done;
                    $qa_done = 0;
                    WebsiteEnhanceData::where('id',$sku_id)->update([
                        'qc_approved_at' => Carbon::now(),
                    ]);
                }
                // QA Complete
                if($project_role == 'QA'){
                    $qa_done = $request->pa_done;
                    // $qa_done = 0;
                    WebsiteEnhanceData::where('id',$sku_id)->update([
                        'qa_approved_at' => Carbon::now(),
                    ]);
                }
            }else{
                // PA Save
                if($project_role == 'PA'){
                    $pa_done = 0;
                    $qc_done = null;
                }
                // QC Save
                if($project_role == 'QC'){
                    $qc_done = 0;
                    $qa_done = null;
                }
                // QA Save
                if($project_role == 'QA'){
                    $qa_done = 0;
                    // $qc_done = null;
                }
            }

            if($download_status != 1){
                // Delete Exsisting data
                WebsiteEnhanceFeature::where('website_enhance_data_id',$sku_id)->delete();
                WebsiteEnhanceSpecification::where('website_enhance_data_id',$sku_id)->delete();
                WebsiteEnhanceImage::where('website_enhance_data_id',$sku_id)->delete();
                
                // Update WebsiteEnhanceData
                WebsiteEnhanceData::where('id',$sku_id)->update([
                    'title'                 => $request->title,
                    'description'           => $request->description,
                    'brand'                 => $request->brand,
                    'color'                 => $request->color,
                    'size'                  => $request->size,
                    'pack_of'               => $request->pack_of,
                    'product_type'          => $request->product_type,
                    'ref_link1'             => $request->ref_link1,
                    'ref_link2'             => $request->ref_link2,
                    'ref_link3'             => $request->ref_link3,
                    'ref_link4'             => $request->ref_link4,
                    'ref_link5'             => $request->ref_link5,
                    'pa_done'               => $pa_done,
                    'qc_done'               => $qc_done,
                    'qa_done'               => $qa_done,
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

                // Update WebsiteEnhanceSpecification
                foreach($specification_arr as $key => $specification){
                    if($key != 0){
                        $specification = str_replace("</li>", "", $specification);
                        $specification = str_replace("</ul>", "", $specification);
                        $specification = explode(":", $specification);
                        WebsiteEnhanceSpecification::create([
                            'website_enhance_data_id'   => $sku_id,
                            'specification_head'        => $specification[0],
                            'specification_value'       => $specification[1],
                        ]);
                    }
                }

                // Update WebsiteEnhanceImage
                foreach($image_arr as $key => $image){
                    WebsiteEnhanceImage::create([
                        'website_enhance_data_id'   => $sku_id,
                        'image'                     => $image,
                    ]);
                }

                // Update Digital Assets

                // img_src
                // if($request->img_src != null){
                //     // Geting Old Data
                //     $old_data = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','img_src')->get();
                    
                //     // If have any old data, delete all
                //     if(!blank($old_data)){
                //         DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','img_src')->delete();
                //     }
                //     // Insert new datas
                //     foreach($request->img_src as $img_src){
                //         DigitalAsset::create([
                //             'website_enhance_data_id'   => $sku_id,
                //             'file_type'                 => 'img_src',
                //             'file_url'                  => $img_src,
                //         ]);
                //     }
                    
                // }    
                
                // img_src
                if($request->img_src != null){
                    // Geting Old ids
                    $old_ids = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','img_src')->pluck('id');
                    
                    $new_ids = [];
                    // Insert new datas
                    foreach($request->img_src as $img_src){
                        $old_data = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','img_src')->where('file_url',$img_src)->get();
                        if(blank($old_data)){
                            $data = DigitalAsset::create([
                                'website_enhance_data_id'   => $sku_id,
                                'file_type'                 => 'img_src',
                                'file_url'                  => $img_src,
                            ]);
                            $new_ids[] =  $data->id;
                        }else{
                            $new_ids[] =  $old_data[0]->id;
                        }
                    }

                    // Delete unwanted records
                    foreach($old_ids as $old_id){
                        if (in_array($old_id, $new_ids)) {
                            
                        } else {
                            DigitalAsset::where('id',$old_id)->delete();
                        } 
                    }
                }

                // data_360
                // if($request->data_360 != null){
                //     // dd($request->data_360);
                //     // Geting Old Data
                //     $old_data = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','data_360')->get();
                    
                //     // If have any old data, delete all
                //     if(!blank($old_data)){
                //         DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','data_360')->delete();
                //     }
                //     // Insert new datas
                //     foreach($request->data_360 as $data_360){
                //         DigitalAsset::create([
                //             'website_enhance_data_id'   => $sku_id,
                //             'file_type'                 => 'data_360',
                //             'file_url'                  => $data_360,
                //         ]);
                //     }
                // }

                // data_360
                if($request->data_360 != null){
                    // Geting Old ids
                    $old_ids = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','data_360')->pluck('id');
                    
                    $new_ids = [];
                    // Insert new datas
                    foreach($request->data_360 as $data_360){
                        $old_data = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','data_360')->where('file_url',$data_360)->get();
                        if(blank($old_data)){
                            $data = DigitalAsset::create([
                                'website_enhance_data_id'   => $sku_id,
                                'file_type'                 => 'data_360',
                                'file_url'                  => $data_360,
                            ]);
                            $new_ids[] =  $data->id;
                        }else{
                            $new_ids[] =  $old_data[0]->id;
                        }
                    }

                    // Delete unwanted records
                    foreach($old_ids as $old_id){
                        if (in_array($old_id, $new_ids)) {
                            
                        } else {
                            DigitalAsset::where('id',$old_id)->delete();
                        } 
                    }
                }

                // spec_sheet
                // if($request->spec_sheet != null){
                //     // Geting Old Data
                //     $old_data = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','spec_sheet')->get();
                    
                //     // If have any old data, delete all
                //     if(!blank($old_data)){
                //         DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','spec_sheet')->delete();
                //     }
                //     // Insert new datas
                //     foreach($request->spec_sheet as $spec_sheet){
                //         DigitalAsset::create([
                //             'website_enhance_data_id'   => $sku_id,
                //             'file_type'                 => 'spec_sheet',
                //             'file_url'                  => $spec_sheet,
                //         ]);
                //     }
                // }

                // spec_sheet
                if($request->spec_sheet != null){
                    // Geting Old ids
                    $old_ids = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','spec_sheet')->pluck('id');
                    
                    $new_ids = [];
                    // Insert new datas
                    foreach($request->spec_sheet as $spec_sheet){
                        $old_data = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','spec_sheet')->where('file_url',$spec_sheet)->get();
                        if(blank($old_data)){
                            $data = DigitalAsset::create([
                                'website_enhance_data_id'   => $sku_id,
                                'file_type'                 => 'spec_sheet',
                                'file_url'                  => $spec_sheet,
                            ]);
                            $new_ids[] =  $data->id;
                        }else{
                            $new_ids[] =  $old_data[0]->id;
                        }
                    }

                    // Delete unwanted records
                    foreach($old_ids as $old_id){
                        if (in_array($old_id, $new_ids)) {
                            
                        } else {
                            DigitalAsset::where('id',$old_id)->delete();
                        } 
                    }
                }

                // part_drawing
                // if($request->part_drawing != null){
                //     // Geting Old Data
                //     $old_data = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','part_drawing')->get();
                    
                //     // If have any old data, delete all
                //     if(!blank($old_data)){
                //         DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','part_drawing')->delete();
                //     }
                //     // Insert new datas
                //     foreach($request->part_drawing as $part_drawing){
                //         DigitalAsset::create([
                //             'website_enhance_data_id'   => $sku_id,
                //             'file_type'                 => 'part_drawing',
                //             'file_url'                  => $part_drawing,
                //         ]);
                //     }
                    
                // }

                // part_drawing
                if($request->part_drawing != null){
                    // Geting Old ids
                    $old_ids = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','part_drawing')->pluck('id');
                    
                    $new_ids = [];
                    // Insert new datas
                    foreach($request->part_drawing as $part_drawing){
                        $old_data = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','part_drawing')->where('file_url',$part_drawing)->get();
                        if(blank($old_data)){
                            $data = DigitalAsset::create([
                                'website_enhance_data_id'   => $sku_id,
                                'file_type'                 => 'part_drawing',
                                'file_url'                  => $part_drawing,
                            ]);
                            $new_ids[] =  $data->id;
                        }else{
                            $new_ids[] =  $old_data[0]->id;
                        }
                    }

                    // Delete unwanted records
                    foreach($old_ids as $old_id){
                        if (in_array($old_id, $new_ids)) {
                            
                        } else {
                            DigitalAsset::where('id',$old_id)->delete();
                        } 
                    }
                }

                // brochure
                // if($request->brochure != null){
                //     // Geting Old Data
                //     $old_data = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','brochure')->get();
                    
                //     // If have any old data, delete all
                //     if(!blank($old_data)){
                //         DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','brochure')->delete();
                //     }
                //     // Insert new datas
                //     foreach($request->brochure as $brochure){
                //         DigitalAsset::create([
                //             'website_enhance_data_id'   => $sku_id,
                //             'file_type'                 => 'brochure',
                //             'file_url'                  => $brochure,
                //         ]);
                //     }
                    
                // }

                // brochure
                if($request->brochure != null){
                    // Geting Old ids
                    $old_ids = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','brochure')->pluck('id');
                    
                    $new_ids = [];
                    // Insert new datas
                    foreach($request->brochure as $brochure){
                        $old_data = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','brochure')->where('file_url',$brochure)->get();
                        if(blank($old_data)){
                            $data = DigitalAsset::create([
                                'website_enhance_data_id'   => $sku_id,
                                'file_type'                 => 'brochure',
                                'file_url'                  => $brochure,
                            ]);
                            $new_ids[] =  $data->id;
                        }else{
                            $new_ids[] =  $old_data[0]->id;
                        }
                    }

                    // Delete unwanted records
                    foreach($old_ids as $old_id){
                        if (in_array($old_id, $new_ids)) {
                            
                        } else {
                            DigitalAsset::where('id',$old_id)->delete();
                        } 
                    }
                }

                // catalog_page
                // if($request->catalog_page != null){
                //     // Geting Old Data
                //     $old_data = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','catalog_page')->get();
                    
                //     // If have any old data, delete all
                //     if(!blank($old_data)){
                //         DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','catalog_page')->delete();
                //     }
                //     // Insert new datas
                //     foreach($request->catalog_page as $catalog_page){
                //         DigitalAsset::create([
                //             'website_enhance_data_id'   => $sku_id,
                //             'file_type'                 => 'catalog_page',
                //             'file_url'                  => $catalog_page,
                //         ]);
                //     }
                    
                // }

                // catalog_page
                if($request->catalog_page != null){
                    // Geting Old ids
                    $old_ids = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','catalog_page')->pluck('id');
                    
                    $new_ids = [];
                    // Insert new datas
                    foreach($request->catalog_page as $catalog_page){
                        $old_data = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','catalog_page')->where('file_url',$catalog_page)->get();
                        if(blank($old_data)){
                            $data = DigitalAsset::create([
                                'website_enhance_data_id'   => $sku_id,
                                'file_type'                 => 'catalog_page',
                                'file_url'                  => $catalog_page,
                            ]);
                            $new_ids[] =  $data->id;
                        }else{
                            $new_ids[] =  $old_data[0]->id;
                        }
                    }

                    // Delete unwanted records
                    foreach($old_ids as $old_id){
                        if (in_array($old_id, $new_ids)) {
                            
                        } else {
                            DigitalAsset::where('id',$old_id)->delete();
                        } 
                    }
                }

                // white_paper
                // if($request->white_paper != null){
                //     // Geting Old Data
                //     $old_data = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','white_paper')->get();
                    
                //     // If have any old data, delete all
                //     if(!blank($old_data)){
                //         DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','white_paper')->delete();
                //     }
                //     // Insert new datas
                //     foreach($request->white_paper as $white_paper){
                //         DigitalAsset::create([
                //             'website_enhance_data_id'   => $sku_id,
                //             'file_type'                 => 'white_paper',
                //             'file_url'                  => $white_paper,
                //         ]);
                //     }
                    
                // }

                // white_paper
                if($request->white_paper != null){
                    // Geting Old ids
                    $old_ids = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','white_paper')->pluck('id');
                    
                    $new_ids = [];
                    // Insert new datas
                    foreach($request->white_paper as $white_paper){
                        $old_data = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','white_paper')->where('file_url',$white_paper)->get();
                        if(blank($old_data)){
                            $data = DigitalAsset::create([
                                'website_enhance_data_id'   => $sku_id,
                                'file_type'                 => 'white_paper',
                                'file_url'                  => $white_paper,
                            ]);
                            $new_ids[] =  $data->id;
                        }else{
                            $new_ids[] =  $old_data[0]->id;
                        }
                    }

                    // Delete unwanted records
                    foreach($old_ids as $old_id){
                        if (in_array($old_id, $new_ids)) {
                            
                        } else {
                            DigitalAsset::where('id',$old_id)->delete();
                        } 
                    }
                }

                // warranty_document
                // if($request->warranty_document != null){
                //     // Geting Old Data
                //     $old_data = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','warranty_document')->get();
                    
                //     // If have any old data, delete all
                //     if(!blank($old_data)){
                //         DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','warranty_document')->delete();
                //     }
                //     // Insert new datas
                //     foreach($request->warranty_document as $warranty_document){
                //         DigitalAsset::create([
                //             'website_enhance_data_id'   => $sku_id,
                //             'file_type'                 => 'warranty_document',
                //             'file_url'                  => $warranty_document,
                //         ]);
                //     }
                    
                // }

                // warranty_document
                if($request->warranty_document != null){
                    // Geting Old ids
                    $old_ids = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','warranty_document')->pluck('id');
                    
                    $new_ids = [];
                    // Insert new datas
                    foreach($request->warranty_document as $warranty_document){
                        $old_data = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','warranty_document')->where('file_url',$warranty_document)->get();
                        if(blank($old_data)){
                            $data = DigitalAsset::create([
                                'website_enhance_data_id'   => $sku_id,
                                'file_type'                 => 'warranty_document',
                                'file_url'                  => $warranty_document,
                            ]);
                            $new_ids[] =  $data->id;
                        }else{
                            $new_ids[] =  $old_data[0]->id;
                        }
                    }

                    // Delete unwanted records
                    foreach($old_ids as $old_id){
                        if (in_array($old_id, $new_ids)) {
                            
                        } else {
                            DigitalAsset::where('id',$old_id)->delete();
                        } 
                    }
                }

                // installation_manual
                // if($request->installation_manual != null){
                //     // Geting Old Data
                //     $old_data = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','installation_manual')->get();
                    
                //     // If have any old data, delete all
                //     if(!blank($old_data)){
                //         DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','installation_manual')->delete();
                //     }
                //     // Insert new datas
                //     foreach($request->installation_manual as $installation_manual){
                //         DigitalAsset::create([
                //             'website_enhance_data_id'   => $sku_id,
                //             'file_type'                 => 'installation_manual',
                //             'file_url'                  => $installation_manual,
                //         ]);
                //     }
                    
                // }

                // installation_manual
                if($request->installation_manual != null){
                    // Geting Old ids
                    $old_ids = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','installation_manual')->pluck('id');
                    
                    $new_ids = [];
                    // Insert new datas
                    foreach($request->installation_manual as $installation_manual){
                        $old_data = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','installation_manual')->where('file_url',$installation_manual)->get();
                        if(blank($old_data)){
                            $data = DigitalAsset::create([
                                'website_enhance_data_id'   => $sku_id,
                                'file_type'                 => 'installation_manual',
                                'file_url'                  => $installation_manual,
                            ]);
                            $new_ids[] =  $data->id;
                        }else{
                            $new_ids[] =  $old_data[0]->id;
                        }
                    }

                    // Delete unwanted records
                    foreach($old_ids as $old_id){
                        if (in_array($old_id, $new_ids)) {
                            
                        } else {
                            DigitalAsset::where('id',$old_id)->delete();
                        } 
                    }
                }

                // how_to_document
                // if($request->how_to_document != null){
                //     // Geting Old Data
                //     $old_data = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','how_to_document')->get();
                    
                //     // If have any old data, delete all
                //     if(!blank($old_data)){
                //         DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','how_to_document')->delete();
                //     }
                //     // Insert new datas
                //     foreach($request->how_to_document as $how_to_document){
                //         DigitalAsset::create([
                //             'website_enhance_data_id'   => $sku_id,
                //             'file_type'                 => 'how_to_document',
                //             'file_url'                  => $how_to_document,
                //         ]);
                //     }
                    
                // }

                // how_to_document
                if($request->how_to_document != null){
                    // Geting Old ids
                    $old_ids = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','how_to_document')->pluck('id');
                    
                    $new_ids = [];
                    // Insert new datas
                    foreach($request->how_to_document as $how_to_document){
                        $old_data = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','how_to_document')->where('file_url',$how_to_document)->get();
                        if(blank($old_data)){
                            $data = DigitalAsset::create([
                                'website_enhance_data_id'   => $sku_id,
                                'file_type'                 => 'how_to_document',
                                'file_url'                  => $how_to_document,
                            ]);
                            $new_ids[] =  $data->id;
                        }else{
                            $new_ids[] =  $old_data[0]->id;
                        }
                    }

                    // Delete unwanted records
                    foreach($old_ids as $old_id){
                        if (in_array($old_id, $new_ids)) {
                            
                        } else {
                            DigitalAsset::where('id',$old_id)->delete();
                        } 
                    }
                }

                // selection_guide
                // if($request->selection_guide != null){
                //     // Geting Old Data
                //     $old_data = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','selection_guide')->get();
                    
                //     // If have any old data, delete all
                //     if(!blank($old_data)){
                //         DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','selection_guide')->delete();
                //     }
                //     // Insert new datas
                //     foreach($request->selection_guide as $selection_guide){
                //         DigitalAsset::create([
                //             'website_enhance_data_id'   => $sku_id,
                //             'file_type'                 => 'selection_guide',
                //             'file_url'                  => $selection_guide,
                //         ]);
                //     }
                    
                // }

                // selection_guide
                if($request->selection_guide != null){
                    // Geting Old ids
                    $old_ids = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','selection_guide')->pluck('id');
                    
                    $new_ids = [];
                    // Insert new datas
                    foreach($request->selection_guide as $selection_guide){
                        $old_data = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','selection_guide')->where('file_url',$selection_guide)->get();
                        if(blank($old_data)){
                            $data = DigitalAsset::create([
                                'website_enhance_data_id'   => $sku_id,
                                'file_type'                 => 'selection_guide',
                                'file_url'                  => $selection_guide,
                            ]);
                            $new_ids[] =  $data->id;
                        }else{
                            $new_ids[] =  $old_data[0]->id;
                        }
                    }

                    // Delete unwanted records
                    foreach($old_ids as $old_id){
                        if (in_array($old_id, $new_ids)) {
                            
                        } else {
                            DigitalAsset::where('id',$old_id)->delete();
                        } 
                    }
                }

                // video
                // if($request->video != null){
                //     // Geting Old Data
                //     $old_data = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','video')->get();
                    
                //     // If have any old data, delete all
                //     if(!blank($old_data)){
                //         DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','video')->delete();
                //     }
                //     // Insert new datas
                //     foreach($request->video as $video){
                //         DigitalAsset::create([
                //             'website_enhance_data_id'   => $sku_id,
                //             'file_type'                 => 'video',
                //             'file_url'                  => $video,
                //         ]);
                //     }
                    
                // }

                // video
                if($request->video != null){
                    // Geting Old ids
                    $old_ids = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','video')->pluck('id');
                    
                    $new_ids = [];
                    // Insert new datas
                    foreach($request->video as $video){
                        $old_data = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','video')->where('file_url',$video)->get();
                        if(blank($old_data)){
                            $data = DigitalAsset::create([
                                'website_enhance_data_id'   => $sku_id,
                                'file_type'                 => 'video',
                                'file_url'                  => $video,
                            ]);
                            $new_ids[] =  $data->id;
                        }else{
                            $new_ids[] =  $old_data[0]->id;
                        }
                    }

                    // Delete unwanted records
                    foreach($old_ids as $old_id){
                        if (in_array($old_id, $new_ids)) {
                            
                        } else {
                            DigitalAsset::where('id',$old_id)->delete();
                        } 
                    }
                }
           
            }
            if($download_status == 1){
                $mpn = $request->mpn;

                // Delete Existing Data
                WebsiteEnhanceImage::where('website_enhance_data_id',$sku_id)->delete();

                // Update WebsiteEnhanceImage
                foreach($image_arr as $key => $image){
                    if($image != null){
                        WebsiteEnhanceImage::create([
                            'website_enhance_data_id'   => $sku_id,
                            'image'                     => $image,
                        ]);
                    }
                }

                // img_src
                if($request->img_src[0] != null){

                    // Geting Old Data
                    $old_data = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','img_src')->get();
                    
                    // If have any old data, delete all
                    if(!blank($old_data)){
                        DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','img_src')->delete();
                    }

                    // Insert new datas
                    foreach($request->img_src as $key => $img_src){
                        $imgname = 'image'.++$key;
                        $file_name = digital_image_upload($img_src,$mpn,$imgname);
                        
                        DigitalAsset::create([
                            'website_enhance_data_id'   => $sku_id,
                            'file_type'                 => 'img_src',
                            'file_url'                  => $img_src,
                            'file_name'                 => $file_name,
                        ]);
                    }
                    
                }

                // if($request->img_src != null){
                //     $db_ids = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','img_src')->pluck('id');
                //     $ids = [];
                //     // Insert new datas
                //     foreach($request->img_src as $img_src){
                //         $old_data = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','img_src')->where('file_name',$img_src)->get();
                //         if(!blank($old_data)){
                //             $ids[] = $old_data[0]->id;
                //         }else{
                //             $data = DigitalAsset::create([
                //                 'website_enhance_data_id'   => $sku_id,
                //                 'file_type'                 => 'img_src',
                //                 'file_url'                  => $img_src,
                //             ]);
                //             $ids[] = $data->id;
                //         }
                //     }
                //     dd($db_ids,$ids);
                    
                // }

                // data_360
                if($request->data_360[0] != null){
                    // dd($request->data_360);
                    // Geting Old Data
                    $old_data = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','data_360')->get();
                    
                    // If have any old data, delete all
                    if(!blank($old_data)){
                        DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','data_360')->delete();
                    }
                    // Insert new datas
                    foreach($request->data_360 as $key => $data_360){
                        $imgname = 'data_360_spin'.++$key;
                        $file_name = digital_image_upload($data_360,$mpn,$imgname);

                        DigitalAsset::create([
                            'website_enhance_data_id'   => $sku_id,
                            'file_type'                 => 'data_360',
                            'file_url'                  => $data_360,
                            'file_name'                 => $file_name,
                        ]);
                    }
                }

                // spec_sheet
                if($request->spec_sheet[0] != null){
                    // Geting Old Data
                    $old_data = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','spec_sheet')->get();
                    
                    // If have any old data, delete all
                    if(!blank($old_data)){
                        DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','spec_sheet')->delete();
                    }
                    // Insert new datas
                    foreach($request->spec_sheet as $key => $spec_sheet){
                        $imgname = 'spec_sheet'.++$key;
                        $file_name = digital_image_upload($spec_sheet,$mpn,$imgname);

                        DigitalAsset::create([
                            'website_enhance_data_id'   => $sku_id,
                            'file_type'                 => 'spec_sheet',
                            'file_url'                  => $spec_sheet,
                            'file_name'                 => $file_name,
                        ]);
                    }
                }

                // part_drawing
                if($request->part_drawing[0] != null){
                    // Geting Old Data
                    $old_data = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','part_drawing')->get();
                    
                    // If have any old data, delete all
                    if(!blank($old_data)){
                        DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','part_drawing')->delete();
                    }
                    // Insert new datas
                    foreach($request->part_drawing as $key => $part_drawing){
                        $imgname = 'part_drawing'.++$key;
                        $file_name = digital_image_upload($part_drawing,$mpn,$imgname);

                        DigitalAsset::create([
                            'website_enhance_data_id'   => $sku_id,
                            'file_type'                 => 'part_drawing',
                            'file_url'                  => $part_drawing,
                            'file_name'                 => $file_name,
                        ]);
                    }
                    
                }

                // brochure
                if($request->brochure[0] != null){
                    // Geting Old Data
                    $old_data = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','brochure')->get();
                    
                    // If have any old data, delete all
                    if(!blank($old_data)){
                        DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','brochure')->delete();
                    }
                    // Insert new datas
                    foreach($request->brochure as $key => $brochure){
                        $imgname = 'brochure'.++$key;
                        $file_name = digital_image_upload($brochure,$mpn,$imgname);

                        DigitalAsset::create([
                            'website_enhance_data_id'   => $sku_id,
                            'file_type'                 => 'brochure',
                            'file_url'                  => $brochure,
                            'file_name'                 => $file_name,
                        ]);
                    }
                    
                }

                // catalog_page
                if($request->catalog_page[0] != null){
                    // Geting Old Data
                    $old_data = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','catalog_page')->get();
                    
                    // If have any old data, delete all
                    if(!blank($old_data)){
                        DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','catalog_page')->delete();
                    }
                    // Insert new datas
                    foreach($request->catalog_page as $key => $catalog_page){
                        $imgname = 'catalog_page'.++$key;
                        $file_name = digital_image_upload($catalog_page,$mpn,$imgname);

                        DigitalAsset::create([
                            'website_enhance_data_id'   => $sku_id,
                            'file_type'                 => 'catalog_page',
                            'file_url'                  => $catalog_page,
                            'file_name'                 => $file_name,
                        ]);
                    }
                    
                }

                // white_paper
                if($request->white_paper[0] != null){
                    // Geting Old Data
                    $old_data = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','white_paper')->get();
                    
                    // If have any old data, delete all
                    if(!blank($old_data)){
                        DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','white_paper')->delete();
                    }
                    // Insert new datas
                    foreach($request->white_paper as $key => $white_paper){
                        $imgname = 'white_paper'.++$key;
                        $file_name = digital_image_upload($white_paper,$mpn,$imgname);

                        DigitalAsset::create([
                            'website_enhance_data_id'   => $sku_id,
                            'file_type'                 => 'white_paper',
                            'file_url'                  => $white_paper,
                            'file_name'                 => $file_name,
                        ]);
                    }
                    
                }

                // warranty_document
                if($request->warranty_document[0] != null){
                    // Geting Old Data
                    $old_data = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','warranty_document')->get();
                    
                    // If have any old data, delete all
                    if(!blank($old_data)){
                        DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','warranty_document')->delete();
                    }
                    // Insert new datas
                    foreach($request->warranty_document as $key => $warranty_document){
                        $imgname = 'warranty_document'.++$key;
                        $file_name = digital_image_upload($warranty_document,$mpn,$imgname);

                        DigitalAsset::create([
                            'website_enhance_data_id'   => $sku_id,
                            'file_type'                 => 'warranty_document',
                            'file_url'                  => $warranty_document,
                            'file_name'                 => $file_name,
                        ]);
                    }
                    
                }

                // installation_manual
                if($request->installation_manual[0] != null){
                    // Geting Old Data
                    $old_data = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','installation_manual')->get();
                    
                    // If have any old data, delete all
                    if(!blank($old_data)){
                        DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','installation_manual')->delete();
                    }
                    // Insert new datas
                    foreach($request->installation_manual as $key => $installation_manual){
                        $imgname = 'installation_manual'.++$key;
                        $file_name = digital_image_upload($installation_manual,$mpn,$imgname);

                        DigitalAsset::create([
                            'website_enhance_data_id'   => $sku_id,
                            'file_type'                 => 'installation_manual',
                            'file_url'                  => $installation_manual,
                            'file_name'                 => $file_name,
                        ]);
                    }
                    
                }

                // how_to_document
                if($request->how_to_document[0] != null){
                    // Geting Old Data
                    $old_data = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','how_to_document')->get();
                    
                    // If have any old data, delete all
                    if(!blank($old_data)){
                        DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','how_to_document')->delete();
                    }
                    // Insert new datas
                    foreach($request->how_to_document as $key => $how_to_document){
                        $imgname = 'how_to_document'.++$key;
                        $file_name = digital_image_upload($how_to_document,$mpn,$imgname);

                        DigitalAsset::create([
                            'website_enhance_data_id'   => $sku_id,
                            'file_type'                 => 'how_to_document',
                            'file_url'                  => $how_to_document,
                            'file_name'                 => $file_name,
                        ]);
                    }
                    
                }

                // selection_guide
                if($request->selection_guide[0] != null){
                    // Geting Old Data
                    $old_data = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','selection_guide')->get();
                    
                    // If have any old data, delete all
                    if(!blank($old_data)){
                        DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','selection_guide')->delete();
                    }
                    // Insert new datas
                    foreach($request->selection_guide as $key => $selection_guide){
                        $imgname = 'selection_guide'.++$key;
                        $file_name = digital_image_upload($selection_guide,$mpn,$imgname);

                        DigitalAsset::create([
                            'website_enhance_data_id'   => $sku_id,
                            'file_type'                 => 'selection_guide',
                            'file_url'                  => $selection_guide,
                            'file_name'                 => $file_name,
                        ]);
                    }
                    
                }

                // video
                if($request->video[0] != null){
                    // Geting Old Data
                    $old_data = DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','video')->get();
                    
                    // If have any old data, delete all
                    if(!blank($old_data)){
                        DigitalAsset::where('website_enhance_data_id',$sku_id)->where('file_type','video')->delete();
                    }
                    // Insert new datas
                    foreach($request->video as $key => $video){
                        $imgname = 'video'.++$key;
                        $file_name = digital_image_upload($video,$mpn,$imgname);

                        DigitalAsset::create([
                            'website_enhance_data_id'   => $sku_id,
                            'file_type'                 => 'video',
                            'file_url'                  => $video,
                            'file_name'                 => $file_name,
                        ]);
                    }
                    
                }
            }

        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error','Something went Wrong');
            DB::rollback();
        }

        DB::commit();

        if($complete_status == 1){
            return redirect()->route('batch_list.index')->with('success','SKU Updated Successfully!!!');
        }
        
        $enc_id = Crypt::encryptString($sku_id);
        $data = WebsiteEnhanceData::where('id',$sku_id)->get();
        return redirect()->route('sku',$enc_id)->with('success','SKU Updated Successfully!!!');
    }
    
}
