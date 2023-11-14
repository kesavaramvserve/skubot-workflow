<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\Website;
use App\Models\WebsiteEnhanceData;
use App\Models\WebsiteEnhanceFeature;
use App\Models\WebsiteEnhanceSpecification;
use App\Models\WebsiteEnhanceImage;
use App\Models\ClientPrice;
use App\Models\ClientRequirement;

class ExportBatch implements WithHeadings, WithMapping, FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $batch_id;
    protected $user_role;
    protected $pa_done;
    protected $status;
    protected $title_sku1;
    protected $title_sku2;
    protected $title_sku3;
    protected $title_sku4;
    protected $title_sku5;
    protected $description_sku1;
    protected $description_sku2;
    protected $description_sku3;
    protected $description_sku4;
    protected $description_sku5;
    protected $feature_sku1;
    protected $feature_sku2;
    protected $feature_sku3;
    protected $feature_sku4;
    protected $feature_sku5;
    protected $specification_sku1;
    protected $specification_sku2;
    protected $specification_sku3;
    protected $specification_sku4;
    protected $specification_sku5;
    protected $image_sku1;
    protected $image_sku2;
    protected $image_sku3;
    protected $image_sku4;
    protected $image_sku5;

    function __construct($batch_id,$user_role,$status,$title_sku1,$title_sku2,$title_sku3,$title_sku4,$title_sku5,
    $description_sku1,$description_sku2,$description_sku3,$description_sku4,$description_sku5,
    $feature_sku1,$feature_sku2,$feature_sku3,$feature_sku4,$feature_sku5,
    $specification_sku1,$specification_sku2,$specification_sku3,$specification_sku4,$specification_sku5,
    $image_sku1,$image_sku2,$image_sku3,$image_sku4,$image_sku5)
    {
        $this->batch_id = $batch_id;
        $this->user_role  = $user_role;
        $this->status  = $status;
        $this->title_sku1 = $title_sku1;
        $this->title_sku2 = $title_sku2;
        $this->title_sku3 = $title_sku3;
        $this->title_sku4 = $title_sku4;
        $this->title_sku5 = $title_sku5;
        $this->description_sku1 = $description_sku1;
        $this->description_sku2 = $description_sku2;
        $this->description_sku3 = $description_sku3;
        $this->description_sku4 = $description_sku4;
        $this->description_sku5 = $description_sku5;
        $this->feature_sku1 = $feature_sku1;
        $this->feature_sku2 = $feature_sku2;
        $this->feature_sku3 = $feature_sku3;
        $this->feature_sku4 = $feature_sku4;
        $this->feature_sku5 = $feature_sku5;
        $this->specification_sku1 = $specification_sku1;
        $this->specification_sku2 = $specification_sku2;
        $this->specification_sku3 = $specification_sku3;
        $this->specification_sku4 = $specification_sku4;
        $this->specification_sku5 = $specification_sku5;
        $this->image_sku1 = $image_sku1;
        $this->image_sku2 = $image_sku2;
        $this->image_sku3 = $image_sku3;
        $this->image_sku4 = $image_sku4;
        $this->image_sku5 = $image_sku5;
    }

    public function collection()
    {
        // if($this->user_role == 'PA'){
        //     $data = WebsiteEnhanceData::with('getFeature','getSpecification','getImage')->where('status',0)->whereIn('batch_id', $this->batch_id)->get();
        // }else{
        //     $data = WebsiteEnhanceData::with('getFeature','getSpecification','getImage')->where('status',1)->whereIn('batch_id', $this->batch_id)->get();
        // }
        $user_where_done = $this->user_role.'_done';
        if($this->status == 'inqueue'){
            $data = WebsiteEnhanceData::with('getFeature','getSpecification','getImage','getTL','getPA','getQC','getDA','getQA')->whereIn('batch_id', $this->batch_id)->where($user_where_done,null)->get();
        }
        if($this->status == 'inprogress'){
            $data = WebsiteEnhanceData::with('getFeature','getSpecification','getImage','getTL','getPA','getQC','getDA','getQA')->whereIn('batch_id', $this->batch_id)->where($user_where_done,0)->get();
        }
        if($this->status == 'rejected'){
            $data = WebsiteEnhanceData::with('getFeature','getSpecification','getImage','getTL','getPA','getQC','getDA','getQA')->where($user_where_done,0)->where('reject_status',1)->whereIn('batch_id', $this->batch_id)->get();
        }
        if($this->status == 'completed'){
            $data = WebsiteEnhanceData::with('getFeature','getSpecification','getImage','getTL','getPA','getQC','getDA','getQA')->where($user_where_done,1)->whereIn('batch_id', $this->batch_id)->get();
        }
        if($this->status == ''){
            $data = WebsiteEnhanceData::with('getFeature','getSpecification','getImage','getTL','getPA','getQC','getDA','getQA')->whereIn('batch_id', $this->batch_id)->get();
        }
        // dd($this->status);
        return $data;
    }

    public function headings(): array
    {
        $data = WebsiteEnhanceData::with('getFeature','getSpecification','getImage','getTL','getPA','getQC','getDA','getQA')->whereIn('batch_id', $this->batch_id)->get();
        foreach($data as $datas){
            $this->pa_done = $datas->pa_done;
        }
        $user_role = auth()->user()->getrole->name;
        // if($this->pa_done != 0){
        //     return [
        //         'name_error',
        //         'caption_error',
        //         'manf_error',
        //         'image_error',
        //         'path_error',
        //         'other_error',
        //         'db_id',
        //         'URL',
        //         'ID',
        //         'MPN',
        //         'NAME',
        //         'BRAND',
        //         'CATEGORY',
        //         'TAG',
        //         'OVERVIEW',
        //         'FEATURE_1',
        //         'FEATURE_2',
        //         'FEATURE_3',
        //         'FEATURE_4',
        //         'FEATURE_5',
        //         'FEATURE_6',
        //         'FEATURE_7',
        //         'FEATURE_8',
        //         'FEATURE_9',
        //         'FEATURE_10',
        //         'FEATURE_11',
        //         'FEATURE_12',
        //         'FEATURE_13',
        //         'FEATURE_14',
        //         'FEATURE_15',
        //         'FEATURE_16',
        //         'FEATURE_17',
        //         'FEATURE_18',
        //         'FEATURE_19',
        //         'FEATURE_20',
        //         'FEATURE_21',
        //         'FEATURE_22',
        //         'FEATURE_23',
        //         'FEATURE_24',
        //         'FEATURE_25',
        //         'FEATURE_26',
        //         'FEATURE_27',
        //         'FEATURE_28',
        //         'FEATURE_29',
        //         'FEATURE_30',
        //         'FEATURE_31',
        //         'FEATURE_32',
        //         'FEATURE_33',
        //         'FEATURE_34',
        //         'FEATURE_35',
        //         'FEATURE_36',
        //         'FEATURE_37',
        //         'FEATURE_38',
        //         'FEATURE_39',
        //         'FEATURE_40',
        //         'FEATURE_41',
        //         'FEATURE_42',
        //         'FEATURE_43',
        //         'FEATURE_44',
        //         'FEATURE_45',
        //         'FEATURE_46',
        //         'FEATURE_47',
        //         'FEATURE_48',
        //         'FEATURE_49',
        //         'FEATURE_50',
        //         'FEATURE_51',
        //         'SPEC_HEADER_1',
        //         'SPEC_VALUE_1',
        //         'SPEC_HEADER_2',
        //         'SPEC_VALUE_2',
        //         'SPEC_HEADER_3',
        //         'SPEC_VALUE_3',
        //         'SPEC_HEADER_4',
        //         'SPEC_VALUE_4',
        //         'SPEC_HEADER_5',
        //         'SPEC_VALUE_5',
        //         'SPEC_HEADER_6',
        //         'SPEC_VALUE_6',
        //         'SPEC_HEADER_7',
        //         'SPEC_VALUE_7',
        //         'SPEC_HEADER_8',
        //         'SPEC_VALUE_8',
        //         'SPEC_HEADER_9',
        //         'SPEC_VALUE_9',
        //         'SPEC_HEADER_10',
        //         'SPEC_VALUE_10',
        //         'SPEC_HEADER_11',
        //         'SPEC_VALUE_11',
        //         'SPEC_HEADER_12',
        //         'SPEC_VALUE_12',
        //         'SPEC_HEADER_13',
        //         'SPEC_VALUE_13',
        //         'SPEC_HEADER_14',
        //         'SPEC_VALUE_14',
        //         'SPEC_HEADER_15',
        //         'SPEC_VALUE_15',
        //         'SPEC_HEADER_16',
        //         'SPEC_VALUE_16',
        //         'SPEC_HEADER_17',
        //         'SPEC_VALUE_17',
        //         'SPEC_HEADER_18',
        //         'SPEC_VALUE_18',
        //         'SPEC_HEADER_19',
        //         'SPEC_VALUE_19',
        //         'SPEC_HEADER_20',
        //         'SPEC_VALUE_20',
        //         'SPEC_HEADER_21',
        //         'SPEC_VALUE_21',
        //         'SPEC_HEADER_22',
        //         'SPEC_VALUE_22',
        //         'SPEC_HEADER_23',
        //         'SPEC_VALUE_23',
        //         'SPEC_HEADER_24',
        //         'SPEC_VALUE_24',
        //         'SPEC_HEADER_25',
        //         'SPEC_VALUE_25',
        //         'SPEC_HEADER_26',
        //         'SPEC_VALUE_26',
        //         'SPEC_HEADER_27',
        //         'SPEC_VALUE_27',
        //         'SPEC_HEADER_28',
        //         'SPEC_VALUE_28',
        //         'SPEC_HEADER_29',
        //         'SPEC_VALUE_29',
        //         'SPEC_HEADER_30',
        //         'SPEC_VALUE_30',
        //         'SPEC_HEADER_31',
        //         'SPEC_VALUE_31',
        //         'SPEC_HEADER_32',
        //         'SPEC_VALUE_32',
        //         'SPEC_HEADER_33',
        //         'SPEC_VALUE_33',
        //         'SPEC_HEADER_34',
        //         'SPEC_VALUE_34',
        //         'SPEC_HEADER_35',
        //         'SPEC_VALUE_35',
        //         'SPEC_HEADER_36',
        //         'SPEC_VALUE_36',
        //         'SPEC_HEADER_37',
        //         'SPEC_VALUE_37',
        //         'SPEC_HEADER_38',
        //         'SPEC_VALUE_38',
        //         'SPEC_HEADER_39',
        //         'SPEC_VALUE_39',
        //         'SPEC_HEADER_40',
        //         'SPEC_VALUE_40',
        //         'SPEC_HEADER_41',
        //         'SPEC_VALUE_41',
        //         'SPEC_HEADER_42',
        //         'SPEC_VALUE_42',
        //         'SPEC_HEADER_43',
        //         'SPEC_VALUE_43',
        //         'IMG_SRC_1',
        //         'IMG_SRC_2',
        //         'IMG_SRC_3',
        //         'IMG_SRC_4',
        //         'IMG_SRC_5',
        //         'IMG_SRC_6',
        //         'IMG_SRC_7',
        //         'IMG_SRC_8',
        //         'IMG_SRC_9',
        //         'IMG_SRC_10',
        //         'IMG_SRC_11',
        //         'IMG_SRC_12',
        //         'IMG_SRC_13',
        //         'IMG_SRC_14',
        //         'IMG_SRC_15',
        //         'IMG_SRC_16',
        //         'IMG_SRC_17',
        //         'IMG_SRC_18',
        //         'IMG_SRC_19',
        //         'IMG_SRC_20',
        //         'IMG_SRC_21',
        //         'IMG_SRC_22',
        //         'IMG_SRC_23',
        //         'IMG_SRC_24',
        //         'IMG_SRC_25',
        //         'IMG_SRC_26',
        //         'IMG_SRC_27',
        //         'IMG_SRC_28',
        //         'IMG_SRC_29',
        //         'IMG_SRC_30',
        //         'IMG_SRC_31',
        //         'IMG_SRC_32',
        //         'IMG_SRC_33',
        //         'IMG_SRC_34',
        //         'IMG_SRC_35',
        //         'IMG_SRC_36',
        //         'IMG_SRC_37',
        //         'IMG_SRC_38',
        //         'IMG_SRC_39',
        //         'IMG_SRC_40',
        //         'IMG_SRC_41',
        //         'IMG_SRC_42',
        //         'IMG_SRC_43',
        //         'IMG_SRC_44',
        //         'IMG_SRC_45',
        //         'IMG_SRC_46',
        //         'IMG_SRC_47',
        //         'IMG_SRC_48',
        //         'IMG_SRC_49',
        //         'IMG_SRC_50',
        //         'IMG_SRC_51',
        //         'IMG_SRC_52',
        //         'IMG_SRC_53',
        //         'IMG_SRC_54',
        //         'IMG_SRC_55',
        //         'IMG_SRC_56',
        //         'IMG_SRC_57',
        //         'IMG_SRC_58',
        //         'IMG_SRC_59',
        //         'IMG_SRC_60',
        //         'tl_id',
        //         'pa_id',
        //         'qc_id',
        //         'da_id',
        //         'qa_id',
        //         'summary',
        //         'rework_reason',
        //     ];
        // }else{
        //     return [
        //         'db_id',
        //         'URL',
        //         'ID',
        //         'MPN',
        //         'NAME',
        //         'BRAND',
        //         'CATEGORY',
        //         'TAG',
        //         'OVERVIEW',
        //         'FEATURE_1',
        //         'FEATURE_2',
        //         'FEATURE_3',
        //         'FEATURE_4',
        //         'FEATURE_5',
        //         'FEATURE_6',
        //         'FEATURE_7',
        //         'FEATURE_8',
        //         'FEATURE_9',
        //         'FEATURE_10',
        //         'FEATURE_11',
        //         'FEATURE_12',
        //         'FEATURE_13',
        //         'FEATURE_14',
        //         'FEATURE_15',
        //         'FEATURE_16',
        //         'FEATURE_17',
        //         'FEATURE_18',
        //         'FEATURE_19',
        //         'FEATURE_20',
        //         'FEATURE_21',
        //         'FEATURE_22',
        //         'FEATURE_23',
        //         'FEATURE_24',
        //         'FEATURE_25',
        //         'FEATURE_26',
        //         'FEATURE_27',
        //         'FEATURE_28',
        //         'FEATURE_29',
        //         'FEATURE_30',
        //         'FEATURE_31',
        //         'FEATURE_32',
        //         'FEATURE_33',
        //         'FEATURE_34',
        //         'FEATURE_35',
        //         'FEATURE_36',
        //         'FEATURE_37',
        //         'FEATURE_38',
        //         'FEATURE_39',
        //         'FEATURE_40',
        //         'FEATURE_41',
        //         'FEATURE_42',
        //         'FEATURE_43',
        //         'FEATURE_44',
        //         'FEATURE_45',
        //         'FEATURE_46',
        //         'FEATURE_47',
        //         'FEATURE_48',
        //         'FEATURE_49',
        //         'FEATURE_50',
        //         'FEATURE_51',
        //         'SPEC_HEADER_1',
        //         'SPEC_VALUE_1',
        //         'SPEC_HEADER_2',
        //         'SPEC_VALUE_2',
        //         'SPEC_HEADER_3',
        //         'SPEC_VALUE_3',
        //         'SPEC_HEADER_4',
        //         'SPEC_VALUE_4',
        //         'SPEC_HEADER_5',
        //         'SPEC_VALUE_5',
        //         'SPEC_HEADER_6',
        //         'SPEC_VALUE_6',
        //         'SPEC_HEADER_7',
        //         'SPEC_VALUE_7',
        //         'SPEC_HEADER_8',
        //         'SPEC_VALUE_8',
        //         'SPEC_HEADER_9',
        //         'SPEC_VALUE_9',
        //         'SPEC_HEADER_10',
        //         'SPEC_VALUE_10',
        //         'SPEC_HEADER_11',
        //         'SPEC_VALUE_11',
        //         'SPEC_HEADER_12',
        //         'SPEC_VALUE_12',
        //         'SPEC_HEADER_13',
        //         'SPEC_VALUE_13',
        //         'SPEC_HEADER_14',
        //         'SPEC_VALUE_14',
        //         'SPEC_HEADER_15',
        //         'SPEC_VALUE_15',
        //         'SPEC_HEADER_16',
        //         'SPEC_VALUE_16',
        //         'SPEC_HEADER_17',
        //         'SPEC_VALUE_17',
        //         'SPEC_HEADER_18',
        //         'SPEC_VALUE_18',
        //         'SPEC_HEADER_19',
        //         'SPEC_VALUE_19',
        //         'SPEC_HEADER_20',
        //         'SPEC_VALUE_20',
        //         'SPEC_HEADER_21',
        //         'SPEC_VALUE_21',
        //         'SPEC_HEADER_22',
        //         'SPEC_VALUE_22',
        //         'SPEC_HEADER_23',
        //         'SPEC_VALUE_23',
        //         'SPEC_HEADER_24',
        //         'SPEC_VALUE_24',
        //         'SPEC_HEADER_25',
        //         'SPEC_VALUE_25',
        //         'SPEC_HEADER_26',
        //         'SPEC_VALUE_26',
        //         'SPEC_HEADER_27',
        //         'SPEC_VALUE_27',
        //         'SPEC_HEADER_28',
        //         'SPEC_VALUE_28',
        //         'SPEC_HEADER_29',
        //         'SPEC_VALUE_29',
        //         'SPEC_HEADER_30',
        //         'SPEC_VALUE_30',
        //         'SPEC_HEADER_31',
        //         'SPEC_VALUE_31',
        //         'SPEC_HEADER_32',
        //         'SPEC_VALUE_32',
        //         'SPEC_HEADER_33',
        //         'SPEC_VALUE_33',
        //         'SPEC_HEADER_34',
        //         'SPEC_VALUE_34',
        //         'SPEC_HEADER_35',
        //         'SPEC_VALUE_35',
        //         'SPEC_HEADER_36',
        //         'SPEC_VALUE_36',
        //         'SPEC_HEADER_37',
        //         'SPEC_VALUE_37',
        //         'SPEC_HEADER_38',
        //         'SPEC_VALUE_38',
        //         'SPEC_HEADER_39',
        //         'SPEC_VALUE_39',
        //         'SPEC_HEADER_40',
        //         'SPEC_VALUE_40',
        //         'SPEC_HEADER_41',
        //         'SPEC_VALUE_41',
        //         'SPEC_HEADER_42',
        //         'SPEC_VALUE_42',
        //         'SPEC_HEADER_43',
        //         'SPEC_VALUE_43',
        //         'IMG_SRC_1',
        //         'IMG_SRC_2',
        //         'IMG_SRC_3',
        //         'IMG_SRC_4',
        //         'IMG_SRC_5',
        //         'IMG_SRC_6',
        //         'IMG_SRC_7',
        //         'IMG_SRC_8',
        //         'IMG_SRC_9',
        //         'IMG_SRC_10',
        //         'IMG_SRC_11',
        //         'IMG_SRC_12',
        //         'IMG_SRC_13',
        //         'IMG_SRC_14',
        //         'IMG_SRC_15',
        //         'IMG_SRC_16',
        //         'IMG_SRC_17',
        //         'IMG_SRC_18',
        //         'IMG_SRC_19',
        //         'IMG_SRC_20',
        //         'IMG_SRC_21',
        //         'IMG_SRC_22',
        //         'IMG_SRC_23',
        //         'IMG_SRC_24',
        //         'IMG_SRC_25',
        //         'IMG_SRC_26',
        //         'IMG_SRC_27',
        //         'IMG_SRC_28',
        //         'IMG_SRC_29',
        //         'IMG_SRC_30',
        //         'IMG_SRC_31',
        //         'IMG_SRC_32',
        //         'IMG_SRC_33',
        //         'IMG_SRC_34',
        //         'IMG_SRC_35',
        //         'IMG_SRC_36',
        //         'IMG_SRC_37',
        //         'IMG_SRC_38',
        //         'IMG_SRC_39',
        //         'IMG_SRC_40',
        //         'IMG_SRC_41',
        //         'IMG_SRC_42',
        //         'IMG_SRC_43',
        //         'IMG_SRC_44',
        //         'IMG_SRC_45',
        //         'IMG_SRC_46',
        //         'IMG_SRC_47',
        //         'IMG_SRC_48',
        //         'IMG_SRC_49',
        //         'IMG_SRC_50',
        //         'IMG_SRC_51',
        //         'IMG_SRC_52',
        //         'IMG_SRC_53',
        //         'IMG_SRC_54',
        //         'IMG_SRC_55',
        //         'IMG_SRC_56',
        //         'IMG_SRC_57',
        //         'IMG_SRC_58',
        //         'IMG_SRC_59',
        //         'IMG_SRC_60',
        //         'tl_id',
        //         'pa_id',
        //         'qc_id',
        //         'da_id',
        //         'qa_id',
        //         'summary',
        //         'rework_reason',
        //     ];
        // }
        if($user_role == 'PA' && $this->pa_done == 0){
            return [
                'db_id',
                'URL',
                'ID',
                'MPN',
                'NAME',
                'BRAND',
                'CATEGORY',
                'TAG',
                'OVERVIEW',
                'FEATURE_1',
                'FEATURE_2',
                'FEATURE_3',
                'FEATURE_4',
                'FEATURE_5',
                'FEATURE_6',
                'FEATURE_7',
                'FEATURE_8',
                'FEATURE_9',
                'FEATURE_10',
                'FEATURE_11',
                'FEATURE_12',
                'FEATURE_13',
                'FEATURE_14',
                'FEATURE_15',
                'FEATURE_16',
                'FEATURE_17',
                'FEATURE_18',
                'FEATURE_19',
                'FEATURE_20',
                'FEATURE_21',
                'FEATURE_22',
                'FEATURE_23',
                'FEATURE_24',
                'FEATURE_25',
                'FEATURE_26',
                'FEATURE_27',
                'FEATURE_28',
                'FEATURE_29',
                'FEATURE_30',
                'FEATURE_31',
                'FEATURE_32',
                'FEATURE_33',
                'FEATURE_34',
                'FEATURE_35',
                'FEATURE_36',
                'FEATURE_37',
                'FEATURE_38',
                'FEATURE_39',
                'FEATURE_40',
                'FEATURE_41',
                'FEATURE_42',
                'FEATURE_43',
                'FEATURE_44',
                'FEATURE_45',
                'FEATURE_46',
                'FEATURE_47',
                'FEATURE_48',
                'FEATURE_49',
                'FEATURE_50',
                'FEATURE_51',
                'SPEC_HEADER_1',
                'SPEC_VALUE_1',
                'SPEC_HEADER_2',
                'SPEC_VALUE_2',
                'SPEC_HEADER_3',
                'SPEC_VALUE_3',
                'SPEC_HEADER_4',
                'SPEC_VALUE_4',
                'SPEC_HEADER_5',
                'SPEC_VALUE_5',
                'SPEC_HEADER_6',
                'SPEC_VALUE_6',
                'SPEC_HEADER_7',
                'SPEC_VALUE_7',
                'SPEC_HEADER_8',
                'SPEC_VALUE_8',
                'SPEC_HEADER_9',
                'SPEC_VALUE_9',
                'SPEC_HEADER_10',
                'SPEC_VALUE_10',
                'SPEC_HEADER_11',
                'SPEC_VALUE_11',
                'SPEC_HEADER_12',
                'SPEC_VALUE_12',
                'SPEC_HEADER_13',
                'SPEC_VALUE_13',
                'SPEC_HEADER_14',
                'SPEC_VALUE_14',
                'SPEC_HEADER_15',
                'SPEC_VALUE_15',
                'SPEC_HEADER_16',
                'SPEC_VALUE_16',
                'SPEC_HEADER_17',
                'SPEC_VALUE_17',
                'SPEC_HEADER_18',
                'SPEC_VALUE_18',
                'SPEC_HEADER_19',
                'SPEC_VALUE_19',
                'SPEC_HEADER_20',
                'SPEC_VALUE_20',
                'SPEC_HEADER_21',
                'SPEC_VALUE_21',
                'SPEC_HEADER_22',
                'SPEC_VALUE_22',
                'SPEC_HEADER_23',
                'SPEC_VALUE_23',
                'SPEC_HEADER_24',
                'SPEC_VALUE_24',
                'SPEC_HEADER_25',
                'SPEC_VALUE_25',
                'SPEC_HEADER_26',
                'SPEC_VALUE_26',
                'SPEC_HEADER_27',
                'SPEC_VALUE_27',
                'SPEC_HEADER_28',
                'SPEC_VALUE_28',
                'SPEC_HEADER_29',
                'SPEC_VALUE_29',
                'SPEC_HEADER_30',
                'SPEC_VALUE_30',
                'SPEC_HEADER_31',
                'SPEC_VALUE_31',
                'SPEC_HEADER_32',
                'SPEC_VALUE_32',
                'SPEC_HEADER_33',
                'SPEC_VALUE_33',
                'SPEC_HEADER_34',
                'SPEC_VALUE_34',
                'SPEC_HEADER_35',
                'SPEC_VALUE_35',
                'SPEC_HEADER_36',
                'SPEC_VALUE_36',
                'SPEC_HEADER_37',
                'SPEC_VALUE_37',
                'SPEC_HEADER_38',
                'SPEC_VALUE_38',
                'SPEC_HEADER_39',
                'SPEC_VALUE_39',
                'SPEC_HEADER_40',
                'SPEC_VALUE_40',
                'SPEC_HEADER_41',
                'SPEC_VALUE_41',
                'SPEC_HEADER_42',
                'SPEC_VALUE_42',
                'SPEC_HEADER_43',
                'SPEC_VALUE_43',
                'IMG_SRC_1',
                'IMG_SRC_2',
                'IMG_SRC_3',
                'IMG_SRC_4',
                'IMG_SRC_5',
                'IMG_SRC_6',
                'IMG_SRC_7',
                'IMG_SRC_8',
                'IMG_SRC_9',
                'IMG_SRC_10',
                'IMG_SRC_11',
                'IMG_SRC_12',
                'IMG_SRC_13',
                'IMG_SRC_14',
                'IMG_SRC_15',
                'IMG_SRC_16',
                'IMG_SRC_17',
                'IMG_SRC_18',
                'IMG_SRC_19',
                'IMG_SRC_20',
                'IMG_SRC_21',
                'IMG_SRC_22',
                'IMG_SRC_23',
                'IMG_SRC_24',
                'IMG_SRC_25',
                'IMG_SRC_26',
                'IMG_SRC_27',
                'IMG_SRC_28',
                'IMG_SRC_29',
                'IMG_SRC_30',
                'IMG_SRC_31',
                'IMG_SRC_32',
                'IMG_SRC_33',
                'IMG_SRC_34',
                'IMG_SRC_35',
                'IMG_SRC_36',
                'IMG_SRC_37',
                'IMG_SRC_38',
                'IMG_SRC_39',
                'IMG_SRC_40',
                'IMG_SRC_41',
                'IMG_SRC_42',
                'IMG_SRC_43',
                'IMG_SRC_44',
                'IMG_SRC_45',
                'IMG_SRC_46',
                'IMG_SRC_47',
                'IMG_SRC_48',
                'IMG_SRC_49',
                'IMG_SRC_50',
                'IMG_SRC_51',
                'IMG_SRC_52',
                'IMG_SRC_53',
                'IMG_SRC_54',
                'IMG_SRC_55',
                'IMG_SRC_56',
                'IMG_SRC_57',
                'IMG_SRC_58',
                'IMG_SRC_59',
                'IMG_SRC_60',
                'tl_id',
                'pa_id',
                'qc_id',
                'da_id',
                'qa_id',
                'summary',
                'rework_reason',
                'TITLE',
                'DESCRIPTION',
                'FEATURE',
                'SPECIFICATION',
                'IMAGE',
            ];
        }else{
            return [
                'name_error',
                'caption_error',
                'manf_error',
                'image_error',
                'path_error',
                'other_error',
                'db_id',
                'URL',
                'ID',
                'MPN',
                'NAME',
                'BRAND',
                'CATEGORY',
                'TAG',
                'OVERVIEW',
                'FEATURE_1',
                'FEATURE_2',
                'FEATURE_3',
                'FEATURE_4',
                'FEATURE_5',
                'FEATURE_6',
                'FEATURE_7',
                'FEATURE_8',
                'FEATURE_9',
                'FEATURE_10',
                'FEATURE_11',
                'FEATURE_12',
                'FEATURE_13',
                'FEATURE_14',
                'FEATURE_15',
                'FEATURE_16',
                'FEATURE_17',
                'FEATURE_18',
                'FEATURE_19',
                'FEATURE_20',
                'FEATURE_21',
                'FEATURE_22',
                'FEATURE_23',
                'FEATURE_24',
                'FEATURE_25',
                'FEATURE_26',
                'FEATURE_27',
                'FEATURE_28',
                'FEATURE_29',
                'FEATURE_30',
                'FEATURE_31',
                'FEATURE_32',
                'FEATURE_33',
                'FEATURE_34',
                'FEATURE_35',
                'FEATURE_36',
                'FEATURE_37',
                'FEATURE_38',
                'FEATURE_39',
                'FEATURE_40',
                'FEATURE_41',
                'FEATURE_42',
                'FEATURE_43',
                'FEATURE_44',
                'FEATURE_45',
                'FEATURE_46',
                'FEATURE_47',
                'FEATURE_48',
                'FEATURE_49',
                'FEATURE_50',
                'FEATURE_51',
                'SPEC_HEADER_1',
                'SPEC_VALUE_1',
                'SPEC_HEADER_2',
                'SPEC_VALUE_2',
                'SPEC_HEADER_3',
                'SPEC_VALUE_3',
                'SPEC_HEADER_4',
                'SPEC_VALUE_4',
                'SPEC_HEADER_5',
                'SPEC_VALUE_5',
                'SPEC_HEADER_6',
                'SPEC_VALUE_6',
                'SPEC_HEADER_7',
                'SPEC_VALUE_7',
                'SPEC_HEADER_8',
                'SPEC_VALUE_8',
                'SPEC_HEADER_9',
                'SPEC_VALUE_9',
                'SPEC_HEADER_10',
                'SPEC_VALUE_10',
                'SPEC_HEADER_11',
                'SPEC_VALUE_11',
                'SPEC_HEADER_12',
                'SPEC_VALUE_12',
                'SPEC_HEADER_13',
                'SPEC_VALUE_13',
                'SPEC_HEADER_14',
                'SPEC_VALUE_14',
                'SPEC_HEADER_15',
                'SPEC_VALUE_15',
                'SPEC_HEADER_16',
                'SPEC_VALUE_16',
                'SPEC_HEADER_17',
                'SPEC_VALUE_17',
                'SPEC_HEADER_18',
                'SPEC_VALUE_18',
                'SPEC_HEADER_19',
                'SPEC_VALUE_19',
                'SPEC_HEADER_20',
                'SPEC_VALUE_20',
                'SPEC_HEADER_21',
                'SPEC_VALUE_21',
                'SPEC_HEADER_22',
                'SPEC_VALUE_22',
                'SPEC_HEADER_23',
                'SPEC_VALUE_23',
                'SPEC_HEADER_24',
                'SPEC_VALUE_24',
                'SPEC_HEADER_25',
                'SPEC_VALUE_25',
                'SPEC_HEADER_26',
                'SPEC_VALUE_26',
                'SPEC_HEADER_27',
                'SPEC_VALUE_27',
                'SPEC_HEADER_28',
                'SPEC_VALUE_28',
                'SPEC_HEADER_29',
                'SPEC_VALUE_29',
                'SPEC_HEADER_30',
                'SPEC_VALUE_30',
                'SPEC_HEADER_31',
                'SPEC_VALUE_31',
                'SPEC_HEADER_32',
                'SPEC_VALUE_32',
                'SPEC_HEADER_33',
                'SPEC_VALUE_33',
                'SPEC_HEADER_34',
                'SPEC_VALUE_34',
                'SPEC_HEADER_35',
                'SPEC_VALUE_35',
                'SPEC_HEADER_36',
                'SPEC_VALUE_36',
                'SPEC_HEADER_37',
                'SPEC_VALUE_37',
                'SPEC_HEADER_38',
                'SPEC_VALUE_38',
                'SPEC_HEADER_39',
                'SPEC_VALUE_39',
                'SPEC_HEADER_40',
                'SPEC_VALUE_40',
                'SPEC_HEADER_41',
                'SPEC_VALUE_41',
                'SPEC_HEADER_42',
                'SPEC_VALUE_42',
                'SPEC_HEADER_43',
                'SPEC_VALUE_43',
                'IMG_SRC_1',
                'IMG_SRC_2',
                'IMG_SRC_3',
                'IMG_SRC_4',
                'IMG_SRC_5',
                'IMG_SRC_6',
                'IMG_SRC_7',
                'IMG_SRC_8',
                'IMG_SRC_9',
                'IMG_SRC_10',
                'IMG_SRC_11',
                'IMG_SRC_12',
                'IMG_SRC_13',
                'IMG_SRC_14',
                'IMG_SRC_15',
                'IMG_SRC_16',
                'IMG_SRC_17',
                'IMG_SRC_18',
                'IMG_SRC_19',
                'IMG_SRC_20',
                'IMG_SRC_21',
                'IMG_SRC_22',
                'IMG_SRC_23',
                'IMG_SRC_24',
                'IMG_SRC_25',
                'IMG_SRC_26',
                'IMG_SRC_27',
                'IMG_SRC_28',
                'IMG_SRC_29',
                'IMG_SRC_30',
                'IMG_SRC_31',
                'IMG_SRC_32',
                'IMG_SRC_33',
                'IMG_SRC_34',
                'IMG_SRC_35',
                'IMG_SRC_36',
                'IMG_SRC_37',
                'IMG_SRC_38',
                'IMG_SRC_39',
                'IMG_SRC_40',
                'IMG_SRC_41',
                'IMG_SRC_42',
                'IMG_SRC_43',
                'IMG_SRC_44',
                'IMG_SRC_45',
                'IMG_SRC_46',
                'IMG_SRC_47',
                'IMG_SRC_48',
                'IMG_SRC_49',
                'IMG_SRC_50',
                'IMG_SRC_51',
                'IMG_SRC_52',
                'IMG_SRC_53',
                'IMG_SRC_54',
                'IMG_SRC_55',
                'IMG_SRC_56',
                'IMG_SRC_57',
                'IMG_SRC_58',
                'IMG_SRC_59',
                'IMG_SRC_60',
                'tl_id',
                'pa_id',
                'qc_id',
                'da_id',
                'qa_id',
                'summary',
                'rework_reason',
                'TITLE',
                'DESCRIPTION',
                'FEATURE',
                'SPECIFICATION',
                'IMAGE',
            ];
        }
        
    }

    public function map($data): array
    {
        
        set_time_limit(180000000);
		ini_set('memory_limit', -1);
        
           $FEATURE_1 = '';
           $FEATURE_2 = '';
           $FEATURE_3 = '';
           $FEATURE_4 = '';
           $FEATURE_5 = '';
           $FEATURE_6 = '';
           $FEATURE_7 = '';
           $FEATURE_8 = '';
           $FEATURE_9 = '';
           $FEATURE_10 = '';
           $FEATURE_11 = '';
           $FEATURE_12 = '';
           $FEATURE_13 = '';
           $FEATURE_14 = '';
           $FEATURE_15 = '';
           $FEATURE_16 = '';
           $FEATURE_17 = '';
           $FEATURE_18 = '';
           $FEATURE_19 = '';
           $FEATURE_20 = '';
           $FEATURE_21 = '';
           $FEATURE_22 = '';
           $FEATURE_23 = '';
           $FEATURE_24 = '';
           $FEATURE_25 = '';
           $FEATURE_26 = '';
           $FEATURE_27 = '';
           $FEATURE_28 = '';
           $FEATURE_29 = '';
           $FEATURE_30 = '';
           $FEATURE_31 = '';
           $FEATURE_32 = '';
           $FEATURE_33 = '';
           $FEATURE_34 = '';
           $FEATURE_35 = '';
           $FEATURE_36 = '';
           $FEATURE_37 = '';
           $FEATURE_38 = '';
           $FEATURE_39 = '';
           $FEATURE_40 = '';
           $FEATURE_41 = '';
           $FEATURE_42 = '';
           $FEATURE_43 = '';
           $FEATURE_44 = '';
           $FEATURE_45 = '';
           $FEATURE_46 = '';
           $FEATURE_47 = '';
           $FEATURE_48 = '';
           $FEATURE_49 = '';
           $FEATURE_50 = '';
           $FEATURE_51 = '';
           $SPEC_HEADER_1 = '';
           $SPEC_VALUE_1 = '';
           $SPEC_HEADER_2 = '';
           $SPEC_VALUE_2 = '';
           $SPEC_HEADER_3 = '';
           $SPEC_VALUE_3 = '';
           $SPEC_HEADER_4 = '';
           $SPEC_VALUE_4 = '';
           $SPEC_HEADER_5 = '';
           $SPEC_VALUE_5 = '';
           $SPEC_HEADER_6 = '';
           $SPEC_VALUE_6 = '';
           $SPEC_HEADER_7 = '';
           $SPEC_VALUE_7 = '';
           $SPEC_HEADER_8 = '';
           $SPEC_VALUE_8 = '';
           $SPEC_HEADER_9 = '';
           $SPEC_VALUE_9 = '';
           $SPEC_HEADER_10 = '';
           $SPEC_VALUE_10 = '';
           $SPEC_HEADER_11 = '';
           $SPEC_VALUE_11 = '';
           $SPEC_HEADER_12 = '';
           $SPEC_VALUE_12 = '';
           $SPEC_HEADER_13 = '';
           $SPEC_VALUE_13 = '';
           $SPEC_HEADER_14 = '';
           $SPEC_VALUE_14 = '';
           $SPEC_HEADER_15 = '';
           $SPEC_VALUE_15 = '';
           $SPEC_HEADER_16 = '';
           $SPEC_VALUE_16 = '';
           $SPEC_HEADER_17 = '';
           $SPEC_VALUE_17 = '';
           $SPEC_HEADER_18 = '';
           $SPEC_VALUE_18 = '';
           $SPEC_HEADER_19 = '';
           $SPEC_VALUE_19 = '';
           $SPEC_HEADER_20 = '';
           $SPEC_VALUE_20 = '';
           $SPEC_HEADER_21 = '';
           $SPEC_VALUE_21 = '';
           $SPEC_HEADER_22 = '';
           $SPEC_VALUE_22 = '';
           $SPEC_HEADER_23 = '';
           $SPEC_VALUE_23 = '';
           $SPEC_HEADER_24 = '';
           $SPEC_VALUE_24 = '';
           $SPEC_HEADER_25 = '';
           $SPEC_VALUE_25 = '';
           $SPEC_HEADER_26 = '';
           $SPEC_VALUE_26 = '';
           $SPEC_HEADER_27 = '';
           $SPEC_VALUE_27 = '';
           $SPEC_HEADER_28 = '';
           $SPEC_VALUE_28 = '';
           $SPEC_HEADER_29 = '';
           $SPEC_VALUE_29 = '';
           $SPEC_HEADER_30 = '';
           $SPEC_VALUE_30 = '';
           $SPEC_HEADER_31 = '';
           $SPEC_VALUE_31 = '';
           $SPEC_HEADER_32 = '';
           $SPEC_VALUE_32 = '';
           $SPEC_HEADER_33 = '';
           $SPEC_VALUE_33 = '';
           $SPEC_HEADER_34 = '';
           $SPEC_VALUE_34 = '';
           $SPEC_HEADER_35 = '';
           $SPEC_VALUE_35 = '';
           $SPEC_HEADER_36 = '';
           $SPEC_VALUE_36 = '';
           $SPEC_HEADER_37 = '';
           $SPEC_VALUE_37 = '';
           $SPEC_HEADER_38 = '';
           $SPEC_VALUE_38 = '';
           $SPEC_HEADER_39 = '';
           $SPEC_VALUE_39 = '';
           $SPEC_HEADER_40 = '';
           $SPEC_VALUE_40 = '';
           $SPEC_HEADER_41 = '';
           $SPEC_VALUE_41 = '';
           $SPEC_HEADER_42 = '';
           $SPEC_VALUE_42 = '';
           $SPEC_HEADER_43 = '';
           $SPEC_VALUE_43 = '';
           $IMG_SRC_1 = '';
           $IMG_SRC_2 = '';
           $IMG_SRC_3 = '';
           $IMG_SRC_4 = '';
           $IMG_SRC_5 = '';
           $IMG_SRC_6 = '';
           $IMG_SRC_7 = '';
           $IMG_SRC_8 = '';
           $IMG_SRC_9 = '';
           $IMG_SRC_10 = '';
           $IMG_SRC_11 = '';
           $IMG_SRC_12 = '';
           $IMG_SRC_13 = '';
           $IMG_SRC_14 = '';
           $IMG_SRC_15 = '';
           $IMG_SRC_16 = '';
           $IMG_SRC_17 = '';
           $IMG_SRC_18 = '';
           $IMG_SRC_19 = '';
           $IMG_SRC_20 = '';
           $IMG_SRC_21 = '';
           $IMG_SRC_22 = '';
           $IMG_SRC_23 = '';
           $IMG_SRC_24 = '';
           $IMG_SRC_25 = '';
           $IMG_SRC_26 = '';
           $IMG_SRC_27 = '';
           $IMG_SRC_28 = '';
           $IMG_SRC_29 = '';
           $IMG_SRC_30 = '';
           $IMG_SRC_31 = '';
           $IMG_SRC_32 = '';
           $IMG_SRC_33 = '';
           $IMG_SRC_34 = '';
           $IMG_SRC_35 = '';
           $IMG_SRC_36 = '';
           $IMG_SRC_37 = '';
           $IMG_SRC_38 = '';
           $IMG_SRC_39 = '';
           $IMG_SRC_40 = '';
           $IMG_SRC_41 = '';
           $IMG_SRC_42 = '';
           $IMG_SRC_43 = '';
           $IMG_SRC_44 = '';
           $IMG_SRC_45 = '';
           $IMG_SRC_46 = '';
           $IMG_SRC_47 = '';
           $IMG_SRC_48 = '';
           $IMG_SRC_49 = '';
           $IMG_SRC_50 = '';
           $IMG_SRC_51 = '';
           $IMG_SRC_52 = '';
           $IMG_SRC_53 = '';
           $IMG_SRC_54 = '';
           $IMG_SRC_55 = '';
           $IMG_SRC_56 = '';
           $IMG_SRC_57 = '';
           $IMG_SRC_58 = '';
           $IMG_SRC_59 = '';
           $IMG_SRC_60 = '';
           $tl_id       = '';
           $pa_id       = '';
           $qc_id       = '';
           $da_id       = '';
           $qa_id       = '';
           $summary     = '';
           $rework      = '';
            // dd($data->name_error);
        // // Feature
        $feature_list = $data->getFeature;
        $feature_count = count($feature_list);
        
        for ($x = 1; $x <= $feature_count; $x++) {
            ${"FEATURE_".$x} = $feature_list[$x-1]->feature;
        }

        // // Specification
        $specification_list = $data->getSpecification;
        $specification_count = count($specification_list);
        // dd($data);
        for ($x = 1; $x <= $specification_count; $x++) {
            ${"SPEC_HEADER_".$x} = $specification_list[$x-1]->specification_head;
            ${"SPEC_VALUE_".$x} = $specification_list[$x-1]->specification_value;
        }

        // // Image
        $image_list = $data->getImage;
        $image_count = count($image_list);
        for ($x = 1; $x <= $image_count; $x++) {
            ${"IMG_SRC_".$x} = $image_list[$x-1]->image;
        }

        // Title
        $title = 'No';
        if(in_array($data->id,$this->title_sku1)){
            $title = 'Yes';
        }

        if(in_array($data->id,$this->title_sku2)){
            $title = 'Yes';
        }

        if(in_array($data->id,$this->title_sku3)){
            $title = 'Yes';
        }

        if(in_array($data->id,$this->title_sku4)){
            $title = 'Yes';
        }

        if(in_array($data->id,$this->title_sku5)){
            $title = 'Yes';
        }

        // Description
        $description = 'No';
        if(in_array($data->id,$this->description_sku1)){
            $description = 'Yes';
        }

        if(in_array($data->id,$this->description_sku2)){
            $description = 'Yes';
        }

        if(in_array($data->id,$this->description_sku3)){
            $description = 'Yes';
        }

        if(in_array($data->id,$this->description_sku4)){
            $description = 'Yes';
        }

        if(in_array($data->id,$this->description_sku5)){
            $description = 'Yes';
        }

        // Feature
        $feature = 'No';
        if(in_array($data->id,$this->feature_sku1)){
            $feature = 'Yes';
        }

        if(in_array($data->id,$this->feature_sku2)){
            $feature = 'Yes';
        }

        if(in_array($data->id,$this->feature_sku3)){
            $feature = 'Yes';
        }

        if(in_array($data->id,$this->feature_sku4)){
            $feature = 'Yes';
        }

        if(in_array($data->id,$this->feature_sku5)){
            $feature = 'Yes';
        }


        // Specification
        $specification = 'No';
        if(in_array($data->id,$this->specification_sku1)){
            $specification = 'Yes';
        }

        if(in_array($data->id,$this->specification_sku2)){
            $specification = 'Yes';
        }

        if(in_array($data->id,$this->specification_sku3)){
            $specification = 'Yes';
        }

        if(in_array($data->id,$this->specification_sku4)){
            $specification = 'Yes';
        }

        if(in_array($data->id,$this->specification_sku5)){
            $specification = 'Yes';
        }

        // Image
        $image = 'No';
        if(in_array($data->id,$this->image_sku1)){
            $image = 'Yes';
        }

        if(in_array($data->id,$this->image_sku2)){
            $image = 'Yes';
        }

        if(in_array($data->id,$this->image_sku3)){
            $image = 'Yes';
        }

        if(in_array($data->id,$this->image_sku4)){
            $image = 'Yes';
        }

        if(in_array($data->id,$this->image_sku5)){
            $image = 'Yes';
        }

        // TL Details
        if(!blank($data->getTL)){
            $tl_id = $data->getTL->first_name;
        }
        // PA Details
        if(!blank($data->getPA)){
            $pa_id = $data->getPA->first_name;
        }
        // QC Details
        if(!blank($data->getQC)){
            $qc_id = $data->getQC->first_name;
        }
        // DA Details
        if(!blank($data->getDA)){
            $da_id = $data->getDA->first_name;
        }
        // QA Details
        if(!blank($data->getQA)){
            $qa_id = $data->getQA->first_name;
        }
        $user_role = auth()->user()->getrole->name;
        // if($this->pa_done != 0){
        //     return [
        //         $data->name_error,
        //         $data->caption_error,
        //         $data->manf_error,
        //         $data->image_error,
        //         $data->path_error,
        //         $data->other_error,
        //         $data->id,
        //         $data->url,
        //         $data->p_id,
        //         $data->mpn,
        //         $data->title,
        //         $data->brand,
        //         $data->category,
        //         $data->tag,
        //         $data->description,
        //         $FEATURE_1,
        //         $FEATURE_2,
        //         $FEATURE_3,
        //         $FEATURE_4,
        //         $FEATURE_5,
        //         $FEATURE_6,
        //         $FEATURE_7,
        //         $FEATURE_8,
        //         $FEATURE_9,
        //         $FEATURE_10,
        //         $FEATURE_11,
        //         $FEATURE_12,
        //         $FEATURE_13,
        //         $FEATURE_14,
        //         $FEATURE_15,
        //         $FEATURE_16,
        //         $FEATURE_17,
        //         $FEATURE_18,
        //         $FEATURE_19,
        //         $FEATURE_20,
        //         $FEATURE_21,
        //         $FEATURE_22,
        //         $FEATURE_23,
        //         $FEATURE_24,
        //         $FEATURE_25,
        //         $FEATURE_26,
        //         $FEATURE_27,
        //         $FEATURE_28,
        //         $FEATURE_29,
        //         $FEATURE_30,
        //         $FEATURE_31,
        //         $FEATURE_32,
        //         $FEATURE_33,
        //         $FEATURE_34,
        //         $FEATURE_35,
        //         $FEATURE_36,
        //         $FEATURE_37,
        //         $FEATURE_38,
        //         $FEATURE_39,
        //         $FEATURE_40,
        //         $FEATURE_41,
        //         $FEATURE_42,
        //         $FEATURE_43,
        //         $FEATURE_44,
        //         $FEATURE_45,
        //         $FEATURE_46,
        //         $FEATURE_47,
        //         $FEATURE_48,
        //         $FEATURE_49,
        //         $FEATURE_50,
        //         $FEATURE_51,
        //         $SPEC_HEADER_1,
        //         $SPEC_VALUE_1,
        //         $SPEC_HEADER_2,
        //         $SPEC_VALUE_2,
        //         $SPEC_HEADER_3,
        //         $SPEC_VALUE_3,
        //         $SPEC_HEADER_4,
        //         $SPEC_VALUE_4,
        //         $SPEC_HEADER_5,
        //         $SPEC_VALUE_5,
        //         $SPEC_HEADER_6,
        //         $SPEC_VALUE_6,
        //         $SPEC_HEADER_7,
        //         $SPEC_VALUE_7,
        //         $SPEC_HEADER_8,
        //         $SPEC_VALUE_8,
        //         $SPEC_HEADER_9,
        //         $SPEC_VALUE_9,
        //         $SPEC_HEADER_10,
        //         $SPEC_VALUE_10,
        //         $SPEC_HEADER_11,
        //         $SPEC_VALUE_11,
        //         $SPEC_HEADER_12,
        //         $SPEC_VALUE_12,
        //         $SPEC_HEADER_13,
        //         $SPEC_VALUE_13,
        //         $SPEC_HEADER_14,
        //         $SPEC_VALUE_14,
        //         $SPEC_HEADER_15,
        //         $SPEC_VALUE_15,
        //         $SPEC_HEADER_16,
        //         $SPEC_VALUE_16,
        //         $SPEC_HEADER_17,
        //         $SPEC_VALUE_17,
        //         $SPEC_HEADER_18,
        //         $SPEC_VALUE_18,
        //         $SPEC_HEADER_19,
        //         $SPEC_VALUE_19,
        //         $SPEC_HEADER_20,
        //         $SPEC_VALUE_20,
        //         $SPEC_HEADER_21,
        //         $SPEC_VALUE_21,
        //         $SPEC_HEADER_22,
        //         $SPEC_VALUE_22,
        //         $SPEC_HEADER_23,
        //         $SPEC_VALUE_23,
        //         $SPEC_HEADER_24,
        //         $SPEC_VALUE_24,
        //         $SPEC_HEADER_25,
        //         $SPEC_VALUE_25,
        //         $SPEC_HEADER_26,
        //         $SPEC_VALUE_26,
        //         $SPEC_HEADER_27,
        //         $SPEC_VALUE_27,
        //         $SPEC_HEADER_28,
        //         $SPEC_VALUE_28,
        //         $SPEC_HEADER_29,
        //         $SPEC_VALUE_29,
        //         $SPEC_HEADER_30,
        //         $SPEC_VALUE_30,
        //         $SPEC_HEADER_31,
        //         $SPEC_VALUE_31,
        //         $SPEC_HEADER_32,
        //         $SPEC_VALUE_32,
        //         $SPEC_HEADER_33,
        //         $SPEC_VALUE_33,
        //         $SPEC_HEADER_34,
        //         $SPEC_VALUE_34,
        //         $SPEC_HEADER_35,
        //         $SPEC_VALUE_35,
        //         $SPEC_HEADER_36,
        //         $SPEC_VALUE_36,
        //         $SPEC_HEADER_37,
        //         $SPEC_VALUE_37,
        //         $SPEC_HEADER_38,
        //         $SPEC_VALUE_38,
        //         $SPEC_HEADER_39,
        //         $SPEC_VALUE_39,
        //         $SPEC_HEADER_40,
        //         $SPEC_VALUE_40,
        //         $SPEC_HEADER_41,
        //         $SPEC_VALUE_41,
        //         $SPEC_HEADER_42,
        //         $SPEC_VALUE_42,
        //         $SPEC_HEADER_43,
        //         $SPEC_VALUE_43,
        //         $IMG_SRC_1,
        //         $IMG_SRC_2,
        //         $IMG_SRC_3,
        //         $IMG_SRC_4,
        //         $IMG_SRC_5,
        //         $IMG_SRC_6,
        //         $IMG_SRC_7,
        //         $IMG_SRC_8,
        //         $IMG_SRC_9,
        //         $IMG_SRC_10,
        //         $IMG_SRC_11,
        //         $IMG_SRC_12,
        //         $IMG_SRC_13,
        //         $IMG_SRC_14,
        //         $IMG_SRC_15,
        //         $IMG_SRC_16,
        //         $IMG_SRC_17,
        //         $IMG_SRC_18,
        //         $IMG_SRC_19,
        //         $IMG_SRC_20,
        //         $IMG_SRC_21,
        //         $IMG_SRC_22,
        //         $IMG_SRC_23,
        //         $IMG_SRC_24,
        //         $IMG_SRC_25,
        //         $IMG_SRC_26,
        //         $IMG_SRC_27,
        //         $IMG_SRC_28,
        //         $IMG_SRC_29,
        //         $IMG_SRC_30,
        //         $IMG_SRC_31,
        //         $IMG_SRC_32,
        //         $IMG_SRC_33,
        //         $IMG_SRC_34,
        //         $IMG_SRC_35,
        //         $IMG_SRC_36,
        //         $IMG_SRC_37,
        //         $IMG_SRC_38,
        //         $IMG_SRC_39,
        //         $IMG_SRC_40,
        //         $IMG_SRC_41,
        //         $IMG_SRC_42,
        //         $IMG_SRC_43,
        //         $IMG_SRC_44,
        //         $IMG_SRC_45,
        //         $IMG_SRC_46,
        //         $IMG_SRC_47,
        //         $IMG_SRC_48,
        //         $IMG_SRC_49,
        //         $IMG_SRC_50,
        //         $IMG_SRC_51,
        //         $IMG_SRC_52,
        //         $IMG_SRC_53,
        //         $IMG_SRC_54,
        //         $IMG_SRC_55,
        //         $IMG_SRC_56,
        //         $IMG_SRC_57,
        //         $IMG_SRC_58,
        //         $IMG_SRC_59,
        //         $IMG_SRC_60,
        //         $tl_id,
        //         $pa_id,
        //         $qc_id,
        //         $da_id,
        //         $qa_id,
        //         $data->summary,
        //         $data->rework,
        //     ];
        // }else{
        //     return [
        //         $data->id,
        //         $data->url,
        //         $data->p_id,
        //         $data->mpn,
        //         $data->title,
        //         $data->brand,
        //         $data->category,
        //         $data->tag,
        //         $data->description,
        //         $FEATURE_1,
        //         $FEATURE_2,
        //         $FEATURE_3,
        //         $FEATURE_4,
        //         $FEATURE_5,
        //         $FEATURE_6,
        //         $FEATURE_7,
        //         $FEATURE_8,
        //         $FEATURE_9,
        //         $FEATURE_10,
        //         $FEATURE_11,
        //         $FEATURE_12,
        //         $FEATURE_13,
        //         $FEATURE_14,
        //         $FEATURE_15,
        //         $FEATURE_16,
        //         $FEATURE_17,
        //         $FEATURE_18,
        //         $FEATURE_19,
        //         $FEATURE_20,
        //         $FEATURE_21,
        //         $FEATURE_22,
        //         $FEATURE_23,
        //         $FEATURE_24,
        //         $FEATURE_25,
        //         $FEATURE_26,
        //         $FEATURE_27,
        //         $FEATURE_28,
        //         $FEATURE_29,
        //         $FEATURE_30,
        //         $FEATURE_31,
        //         $FEATURE_32,
        //         $FEATURE_33,
        //         $FEATURE_34,
        //         $FEATURE_35,
        //         $FEATURE_36,
        //         $FEATURE_37,
        //         $FEATURE_38,
        //         $FEATURE_39,
        //         $FEATURE_40,
        //         $FEATURE_41,
        //         $FEATURE_42,
        //         $FEATURE_43,
        //         $FEATURE_44,
        //         $FEATURE_45,
        //         $FEATURE_46,
        //         $FEATURE_47,
        //         $FEATURE_48,
        //         $FEATURE_49,
        //         $FEATURE_50,
        //         $FEATURE_51,
        //         $SPEC_HEADER_1,
        //         $SPEC_VALUE_1,
        //         $SPEC_HEADER_2,
        //         $SPEC_VALUE_2,
        //         $SPEC_HEADER_3,
        //         $SPEC_VALUE_3,
        //         $SPEC_HEADER_4,
        //         $SPEC_VALUE_4,
        //         $SPEC_HEADER_5,
        //         $SPEC_VALUE_5,
        //         $SPEC_HEADER_6,
        //         $SPEC_VALUE_6,
        //         $SPEC_HEADER_7,
        //         $SPEC_VALUE_7,
        //         $SPEC_HEADER_8,
        //         $SPEC_VALUE_8,
        //         $SPEC_HEADER_9,
        //         $SPEC_VALUE_9,
        //         $SPEC_HEADER_10,
        //         $SPEC_VALUE_10,
        //         $SPEC_HEADER_11,
        //         $SPEC_VALUE_11,
        //         $SPEC_HEADER_12,
        //         $SPEC_VALUE_12,
        //         $SPEC_HEADER_13,
        //         $SPEC_VALUE_13,
        //         $SPEC_HEADER_14,
        //         $SPEC_VALUE_14,
        //         $SPEC_HEADER_15,
        //         $SPEC_VALUE_15,
        //         $SPEC_HEADER_16,
        //         $SPEC_VALUE_16,
        //         $SPEC_HEADER_17,
        //         $SPEC_VALUE_17,
        //         $SPEC_HEADER_18,
        //         $SPEC_VALUE_18,
        //         $SPEC_HEADER_19,
        //         $SPEC_VALUE_19,
        //         $SPEC_HEADER_20,
        //         $SPEC_VALUE_20,
        //         $SPEC_HEADER_21,
        //         $SPEC_VALUE_21,
        //         $SPEC_HEADER_22,
        //         $SPEC_VALUE_22,
        //         $SPEC_HEADER_23,
        //         $SPEC_VALUE_23,
        //         $SPEC_HEADER_24,
        //         $SPEC_VALUE_24,
        //         $SPEC_HEADER_25,
        //         $SPEC_VALUE_25,
        //         $SPEC_HEADER_26,
        //         $SPEC_VALUE_26,
        //         $SPEC_HEADER_27,
        //         $SPEC_VALUE_27,
        //         $SPEC_HEADER_28,
        //         $SPEC_VALUE_28,
        //         $SPEC_HEADER_29,
        //         $SPEC_VALUE_29,
        //         $SPEC_HEADER_30,
        //         $SPEC_VALUE_30,
        //         $SPEC_HEADER_31,
        //         $SPEC_VALUE_31,
        //         $SPEC_HEADER_32,
        //         $SPEC_VALUE_32,
        //         $SPEC_HEADER_33,
        //         $SPEC_VALUE_33,
        //         $SPEC_HEADER_34,
        //         $SPEC_VALUE_34,
        //         $SPEC_HEADER_35,
        //         $SPEC_VALUE_35,
        //         $SPEC_HEADER_36,
        //         $SPEC_VALUE_36,
        //         $SPEC_HEADER_37,
        //         $SPEC_VALUE_37,
        //         $SPEC_HEADER_38,
        //         $SPEC_VALUE_38,
        //         $SPEC_HEADER_39,
        //         $SPEC_VALUE_39,
        //         $SPEC_HEADER_40,
        //         $SPEC_VALUE_40,
        //         $SPEC_HEADER_41,
        //         $SPEC_VALUE_41,
        //         $SPEC_HEADER_42,
        //         $SPEC_VALUE_42,
        //         $SPEC_HEADER_43,
        //         $SPEC_VALUE_43,
        //         $IMG_SRC_1,
        //         $IMG_SRC_2,
        //         $IMG_SRC_3,
        //         $IMG_SRC_4,
        //         $IMG_SRC_5,
        //         $IMG_SRC_6,
        //         $IMG_SRC_7,
        //         $IMG_SRC_8,
        //         $IMG_SRC_9,
        //         $IMG_SRC_10,
        //         $IMG_SRC_11,
        //         $IMG_SRC_12,
        //         $IMG_SRC_13,
        //         $IMG_SRC_14,
        //         $IMG_SRC_15,
        //         $IMG_SRC_16,
        //         $IMG_SRC_17,
        //         $IMG_SRC_18,
        //         $IMG_SRC_19,
        //         $IMG_SRC_20,
        //         $IMG_SRC_21,
        //         $IMG_SRC_22,
        //         $IMG_SRC_23,
        //         $IMG_SRC_24,
        //         $IMG_SRC_25,
        //         $IMG_SRC_26,
        //         $IMG_SRC_27,
        //         $IMG_SRC_28,
        //         $IMG_SRC_29,
        //         $IMG_SRC_30,
        //         $IMG_SRC_31,
        //         $IMG_SRC_32,
        //         $IMG_SRC_33,
        //         $IMG_SRC_34,
        //         $IMG_SRC_35,
        //         $IMG_SRC_36,
        //         $IMG_SRC_37,
        //         $IMG_SRC_38,
        //         $IMG_SRC_39,
        //         $IMG_SRC_40,
        //         $IMG_SRC_41,
        //         $IMG_SRC_42,
        //         $IMG_SRC_43,
        //         $IMG_SRC_44,
        //         $IMG_SRC_45,
        //         $IMG_SRC_46,
        //         $IMG_SRC_47,
        //         $IMG_SRC_48,
        //         $IMG_SRC_49,
        //         $IMG_SRC_50,
        //         $IMG_SRC_51,
        //         $IMG_SRC_52,
        //         $IMG_SRC_53,
        //         $IMG_SRC_54,
        //         $IMG_SRC_55,
        //         $IMG_SRC_56,
        //         $IMG_SRC_57,
        //         $IMG_SRC_58,
        //         $IMG_SRC_59,
        //         $IMG_SRC_60,
        //         $tl_id,
        //         $pa_id,
        //         $qc_id,
        //         $da_id,
        //         $qa_id,
        //         $data->summary,
        //         $data->rework,
        //     ];
        // }

        if($user_role == 'PA' && $this->pa_done == 0){
            return [
                $data->id,
                $data->url,
                $data->p_id,
                $data->mpn,
                $data->title,
                $data->brand,
                $data->category,
                $data->tag,
                $data->description,
                $FEATURE_1,
                $FEATURE_2,
                $FEATURE_3,
                $FEATURE_4,
                $FEATURE_5,
                $FEATURE_6,
                $FEATURE_7,
                $FEATURE_8,
                $FEATURE_9,
                $FEATURE_10,
                $FEATURE_11,
                $FEATURE_12,
                $FEATURE_13,
                $FEATURE_14,
                $FEATURE_15,
                $FEATURE_16,
                $FEATURE_17,
                $FEATURE_18,
                $FEATURE_19,
                $FEATURE_20,
                $FEATURE_21,
                $FEATURE_22,
                $FEATURE_23,
                $FEATURE_24,
                $FEATURE_25,
                $FEATURE_26,
                $FEATURE_27,
                $FEATURE_28,
                $FEATURE_29,
                $FEATURE_30,
                $FEATURE_31,
                $FEATURE_32,
                $FEATURE_33,
                $FEATURE_34,
                $FEATURE_35,
                $FEATURE_36,
                $FEATURE_37,
                $FEATURE_38,
                $FEATURE_39,
                $FEATURE_40,
                $FEATURE_41,
                $FEATURE_42,
                $FEATURE_43,
                $FEATURE_44,
                $FEATURE_45,
                $FEATURE_46,
                $FEATURE_47,
                $FEATURE_48,
                $FEATURE_49,
                $FEATURE_50,
                $FEATURE_51,
                $SPEC_HEADER_1,
                $SPEC_VALUE_1,
                $SPEC_HEADER_2,
                $SPEC_VALUE_2,
                $SPEC_HEADER_3,
                $SPEC_VALUE_3,
                $SPEC_HEADER_4,
                $SPEC_VALUE_4,
                $SPEC_HEADER_5,
                $SPEC_VALUE_5,
                $SPEC_HEADER_6,
                $SPEC_VALUE_6,
                $SPEC_HEADER_7,
                $SPEC_VALUE_7,
                $SPEC_HEADER_8,
                $SPEC_VALUE_8,
                $SPEC_HEADER_9,
                $SPEC_VALUE_9,
                $SPEC_HEADER_10,
                $SPEC_VALUE_10,
                $SPEC_HEADER_11,
                $SPEC_VALUE_11,
                $SPEC_HEADER_12,
                $SPEC_VALUE_12,
                $SPEC_HEADER_13,
                $SPEC_VALUE_13,
                $SPEC_HEADER_14,
                $SPEC_VALUE_14,
                $SPEC_HEADER_15,
                $SPEC_VALUE_15,
                $SPEC_HEADER_16,
                $SPEC_VALUE_16,
                $SPEC_HEADER_17,
                $SPEC_VALUE_17,
                $SPEC_HEADER_18,
                $SPEC_VALUE_18,
                $SPEC_HEADER_19,
                $SPEC_VALUE_19,
                $SPEC_HEADER_20,
                $SPEC_VALUE_20,
                $SPEC_HEADER_21,
                $SPEC_VALUE_21,
                $SPEC_HEADER_22,
                $SPEC_VALUE_22,
                $SPEC_HEADER_23,
                $SPEC_VALUE_23,
                $SPEC_HEADER_24,
                $SPEC_VALUE_24,
                $SPEC_HEADER_25,
                $SPEC_VALUE_25,
                $SPEC_HEADER_26,
                $SPEC_VALUE_26,
                $SPEC_HEADER_27,
                $SPEC_VALUE_27,
                $SPEC_HEADER_28,
                $SPEC_VALUE_28,
                $SPEC_HEADER_29,
                $SPEC_VALUE_29,
                $SPEC_HEADER_30,
                $SPEC_VALUE_30,
                $SPEC_HEADER_31,
                $SPEC_VALUE_31,
                $SPEC_HEADER_32,
                $SPEC_VALUE_32,
                $SPEC_HEADER_33,
                $SPEC_VALUE_33,
                $SPEC_HEADER_34,
                $SPEC_VALUE_34,
                $SPEC_HEADER_35,
                $SPEC_VALUE_35,
                $SPEC_HEADER_36,
                $SPEC_VALUE_36,
                $SPEC_HEADER_37,
                $SPEC_VALUE_37,
                $SPEC_HEADER_38,
                $SPEC_VALUE_38,
                $SPEC_HEADER_39,
                $SPEC_VALUE_39,
                $SPEC_HEADER_40,
                $SPEC_VALUE_40,
                $SPEC_HEADER_41,
                $SPEC_VALUE_41,
                $SPEC_HEADER_42,
                $SPEC_VALUE_42,
                $SPEC_HEADER_43,
                $SPEC_VALUE_43,
                $IMG_SRC_1,
                $IMG_SRC_2,
                $IMG_SRC_3,
                $IMG_SRC_4,
                $IMG_SRC_5,
                $IMG_SRC_6,
                $IMG_SRC_7,
                $IMG_SRC_8,
                $IMG_SRC_9,
                $IMG_SRC_10,
                $IMG_SRC_11,
                $IMG_SRC_12,
                $IMG_SRC_13,
                $IMG_SRC_14,
                $IMG_SRC_15,
                $IMG_SRC_16,
                $IMG_SRC_17,
                $IMG_SRC_18,
                $IMG_SRC_19,
                $IMG_SRC_20,
                $IMG_SRC_21,
                $IMG_SRC_22,
                $IMG_SRC_23,
                $IMG_SRC_24,
                $IMG_SRC_25,
                $IMG_SRC_26,
                $IMG_SRC_27,
                $IMG_SRC_28,
                $IMG_SRC_29,
                $IMG_SRC_30,
                $IMG_SRC_31,
                $IMG_SRC_32,
                $IMG_SRC_33,
                $IMG_SRC_34,
                $IMG_SRC_35,
                $IMG_SRC_36,
                $IMG_SRC_37,
                $IMG_SRC_38,
                $IMG_SRC_39,
                $IMG_SRC_40,
                $IMG_SRC_41,
                $IMG_SRC_42,
                $IMG_SRC_43,
                $IMG_SRC_44,
                $IMG_SRC_45,
                $IMG_SRC_46,
                $IMG_SRC_47,
                $IMG_SRC_48,
                $IMG_SRC_49,
                $IMG_SRC_50,
                $IMG_SRC_51,
                $IMG_SRC_52,
                $IMG_SRC_53,
                $IMG_SRC_54,
                $IMG_SRC_55,
                $IMG_SRC_56,
                $IMG_SRC_57,
                $IMG_SRC_58,
                $IMG_SRC_59,
                $IMG_SRC_60,
                $tl_id,
                $pa_id,
                $qc_id,
                $da_id,
                $qa_id,
                $data->summary,
                $data->rework,
                $title,
                $description,
                $feature,
                $specification,
                $image,
            ];
        }else{
            return [
                $data->name_error,
                $data->caption_error,
                $data->manf_error,
                $data->image_error,
                $data->path_error,
                $data->other_error,
                $data->id,
                $data->url,
                $data->p_id,
                $data->mpn,
                $data->title,
                $data->brand,
                $data->category,
                $data->tag,
                $data->description,
                $FEATURE_1,
                $FEATURE_2,
                $FEATURE_3,
                $FEATURE_4,
                $FEATURE_5,
                $FEATURE_6,
                $FEATURE_7,
                $FEATURE_8,
                $FEATURE_9,
                $FEATURE_10,
                $FEATURE_11,
                $FEATURE_12,
                $FEATURE_13,
                $FEATURE_14,
                $FEATURE_15,
                $FEATURE_16,
                $FEATURE_17,
                $FEATURE_18,
                $FEATURE_19,
                $FEATURE_20,
                $FEATURE_21,
                $FEATURE_22,
                $FEATURE_23,
                $FEATURE_24,
                $FEATURE_25,
                $FEATURE_26,
                $FEATURE_27,
                $FEATURE_28,
                $FEATURE_29,
                $FEATURE_30,
                $FEATURE_31,
                $FEATURE_32,
                $FEATURE_33,
                $FEATURE_34,
                $FEATURE_35,
                $FEATURE_36,
                $FEATURE_37,
                $FEATURE_38,
                $FEATURE_39,
                $FEATURE_40,
                $FEATURE_41,
                $FEATURE_42,
                $FEATURE_43,
                $FEATURE_44,
                $FEATURE_45,
                $FEATURE_46,
                $FEATURE_47,
                $FEATURE_48,
                $FEATURE_49,
                $FEATURE_50,
                $FEATURE_51,
                $SPEC_HEADER_1,
                $SPEC_VALUE_1,
                $SPEC_HEADER_2,
                $SPEC_VALUE_2,
                $SPEC_HEADER_3,
                $SPEC_VALUE_3,
                $SPEC_HEADER_4,
                $SPEC_VALUE_4,
                $SPEC_HEADER_5,
                $SPEC_VALUE_5,
                $SPEC_HEADER_6,
                $SPEC_VALUE_6,
                $SPEC_HEADER_7,
                $SPEC_VALUE_7,
                $SPEC_HEADER_8,
                $SPEC_VALUE_8,
                $SPEC_HEADER_9,
                $SPEC_VALUE_9,
                $SPEC_HEADER_10,
                $SPEC_VALUE_10,
                $SPEC_HEADER_11,
                $SPEC_VALUE_11,
                $SPEC_HEADER_12,
                $SPEC_VALUE_12,
                $SPEC_HEADER_13,
                $SPEC_VALUE_13,
                $SPEC_HEADER_14,
                $SPEC_VALUE_14,
                $SPEC_HEADER_15,
                $SPEC_VALUE_15,
                $SPEC_HEADER_16,
                $SPEC_VALUE_16,
                $SPEC_HEADER_17,
                $SPEC_VALUE_17,
                $SPEC_HEADER_18,
                $SPEC_VALUE_18,
                $SPEC_HEADER_19,
                $SPEC_VALUE_19,
                $SPEC_HEADER_20,
                $SPEC_VALUE_20,
                $SPEC_HEADER_21,
                $SPEC_VALUE_21,
                $SPEC_HEADER_22,
                $SPEC_VALUE_22,
                $SPEC_HEADER_23,
                $SPEC_VALUE_23,
                $SPEC_HEADER_24,
                $SPEC_VALUE_24,
                $SPEC_HEADER_25,
                $SPEC_VALUE_25,
                $SPEC_HEADER_26,
                $SPEC_VALUE_26,
                $SPEC_HEADER_27,
                $SPEC_VALUE_27,
                $SPEC_HEADER_28,
                $SPEC_VALUE_28,
                $SPEC_HEADER_29,
                $SPEC_VALUE_29,
                $SPEC_HEADER_30,
                $SPEC_VALUE_30,
                $SPEC_HEADER_31,
                $SPEC_VALUE_31,
                $SPEC_HEADER_32,
                $SPEC_VALUE_32,
                $SPEC_HEADER_33,
                $SPEC_VALUE_33,
                $SPEC_HEADER_34,
                $SPEC_VALUE_34,
                $SPEC_HEADER_35,
                $SPEC_VALUE_35,
                $SPEC_HEADER_36,
                $SPEC_VALUE_36,
                $SPEC_HEADER_37,
                $SPEC_VALUE_37,
                $SPEC_HEADER_38,
                $SPEC_VALUE_38,
                $SPEC_HEADER_39,
                $SPEC_VALUE_39,
                $SPEC_HEADER_40,
                $SPEC_VALUE_40,
                $SPEC_HEADER_41,
                $SPEC_VALUE_41,
                $SPEC_HEADER_42,
                $SPEC_VALUE_42,
                $SPEC_HEADER_43,
                $SPEC_VALUE_43,
                $IMG_SRC_1,
                $IMG_SRC_2,
                $IMG_SRC_3,
                $IMG_SRC_4,
                $IMG_SRC_5,
                $IMG_SRC_6,
                $IMG_SRC_7,
                $IMG_SRC_8,
                $IMG_SRC_9,
                $IMG_SRC_10,
                $IMG_SRC_11,
                $IMG_SRC_12,
                $IMG_SRC_13,
                $IMG_SRC_14,
                $IMG_SRC_15,
                $IMG_SRC_16,
                $IMG_SRC_17,
                $IMG_SRC_18,
                $IMG_SRC_19,
                $IMG_SRC_20,
                $IMG_SRC_21,
                $IMG_SRC_22,
                $IMG_SRC_23,
                $IMG_SRC_24,
                $IMG_SRC_25,
                $IMG_SRC_26,
                $IMG_SRC_27,
                $IMG_SRC_28,
                $IMG_SRC_29,
                $IMG_SRC_30,
                $IMG_SRC_31,
                $IMG_SRC_32,
                $IMG_SRC_33,
                $IMG_SRC_34,
                $IMG_SRC_35,
                $IMG_SRC_36,
                $IMG_SRC_37,
                $IMG_SRC_38,
                $IMG_SRC_39,
                $IMG_SRC_40,
                $IMG_SRC_41,
                $IMG_SRC_42,
                $IMG_SRC_43,
                $IMG_SRC_44,
                $IMG_SRC_45,
                $IMG_SRC_46,
                $IMG_SRC_47,
                $IMG_SRC_48,
                $IMG_SRC_49,
                $IMG_SRC_50,
                $IMG_SRC_51,
                $IMG_SRC_52,
                $IMG_SRC_53,
                $IMG_SRC_54,
                $IMG_SRC_55,
                $IMG_SRC_56,
                $IMG_SRC_57,
                $IMG_SRC_58,
                $IMG_SRC_59,
                $IMG_SRC_60,
                $tl_id,
                $pa_id,
                $qc_id,
                $da_id,
                $qa_id,
                $data->summary,
                $data->rework,
                $title,
                $description,
                $feature,
                $specification,
                $image,
            ];
        }
        
    }
}
