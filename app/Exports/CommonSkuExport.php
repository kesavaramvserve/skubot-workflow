<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Website;
use App\Models\WebsiteData;
use App\Models\WebsiteFeature;
use App\Models\WebsiteSpecification;
use App\Models\WebsiteImage;
use App\Models\WebsiteRange;
use App\Models\ClientPrice;
use App\Models\ClientRequirement;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CommonSkuExport implements WithHeadings, WithMapping, FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $range;
    protected $website_id;

    function __construct($range,$website_id) {
        $this->range = $range;
        $this->website_id = $website_id;
    }

    public function collection()
    {
        $title_range    = WebsiteRange::where('website_id',$this->website_id)->where('content','title')->get();
        $title          = [$title_range[0]->high_attention_required, $title_range[0]->needs_improvement,$title_range[0]->good_to_improve, $title_range[0]->average_optimized, $title_range[0]->optimized];

        $description_range    = WebsiteRange::where('website_id',$this->website_id)->where('content','description')->get();
        $description          = [$description_range[0]->high_attention_required, $description_range[0]->needs_improvement,$description_range[0]->good_to_improve, $description_range[0]->average_optimized, $description_range[0]->optimized];

        $feature_range    = WebsiteRange::where('website_id',$this->website_id)->where('content','feature')->get();
        $feature          = [$feature_range[0]->high_attention_required, $feature_range[0]->needs_improvement,$feature_range[0]->good_to_improve, $feature_range[0]->average_optimized, $feature_range[0]->optimized];

        $specification_range    = WebsiteRange::where('website_id',$this->website_id)->where('content','specification')->get();
        $specification          = [$specification_range[0]->high_attention_required, $specification_range[0]->needs_improvement,$specification_range[0]->good_to_improve, $specification_range[0]->average_optimized, $specification_range[0]->optimized];

        $image_range    = WebsiteRange::where('website_id',$this->website_id)->where('content','image')->get();
        $image          = [$image_range[0]->high_attention_required, $image_range[0]->needs_improvement,$image_range[0]->good_to_improve, $image_range[0]->average_optimized, $image_range[0]->optimized];

        // high_attention_required
        if($this->range == 'range1'){  
            
            $title_report          = WebsiteData::where('website_id',$this->website_id)->where('title_character_count','>=',0)->where('title_character_count','<=',$title[0])->get();
            $description_report    = WebsiteData::where('website_id',$this->website_id)->where('description_word_count','>=',0)->where('description_word_count','<=',$description[0])->get();
            $feature_report        = WebsiteData::where('website_id',$this->website_id)->where('feature_count','>=',0)->where('feature_count','<=',$feature[0])->get();
            $specification_report  = WebsiteData::where('website_id',$this->website_id)->where('specification_count','>=',0)->where('specification_count','<=',$specification[0])->get();
            $image_report          = WebsiteData::where('website_id',$this->website_id)->where('image_count','>=',0)->where('image_count','<=',$image[0])->get();

            
            $query = WebsiteData::where('website_id',$this->website_id);
            $entry = 0;

            if(count($title_report) > 0){
                $entry = $entry + 1;
                $query->where('title_character_count','>=',0)->where('title_character_count','<=',$title[0]);
            }
            if(count($description_report) > 0){
                $entry = $entry + 1;
                $query->where('description_word_count','>=',0)->where('description_word_count','<=',$description[0]);
            }
            if(count($feature_report) > 0){
                $entry = $entry + 1;
                $query->where('feature_count','>=',0)->where('feature_count','<=',$feature[0]);
            }
            if(count($specification_report) > 0){
                $entry = $entry + 1;
                $query->where('specification_count','>=',0)->where('specification_count','<=',$specification[0]);
            }
            if(count($image_report) > 0){
                $entry = $entry + 1;
                $query->where('image_count','>=',0)->where('image_count','<=',$image[0]);
            }

            $data = $query->get();
        }

        // needs_improvement
        if($this->range == 'range2'){  
            
            $title_report         = WebsiteData::where('website_id',$this->website_id)->where('title_character_count','>=',$title[0])->where('title_character_count','<=',$title[1])->get();
            $description_report   = WebsiteData::where('website_id',$this->website_id)->where('description_word_count','>=',$description[0])->where('description_word_count','<=',$description[1])->get();
            $feature_report       = WebsiteData::where('website_id',$this->website_id)->where('feature_count','>=',$feature[0])->where('feature_count','<=',$feature[1])->get();
            $specification_report = WebsiteData::where('website_id',$this->website_id)->where('specification_count','>=',$specification[0])->where('specification_count','<=',$specification[1])->get();
            $image_report         = WebsiteData::where('website_id',$this->website_id)->where('image_count','>=',$image[0])->where('image_count','<=',$image[1])->get();

            
            $query = WebsiteData::where('website_id',$this->website_id);
            $entry = 0;

            if(count($title_report) > 0){
                $entry = $entry + 1;
                $from = $title[0] +1;
                $query->where('title_character_count','>=',$from)->where('title_character_count','<=',$title[1]);
            }
            if(count($description_report) > 0){
                $entry = $entry + 1;
                $from = $description[0] +1;
                $query->where('description_word_count','>=',$from)->where('description_word_count','<=',$description[1]);
            }
            if(count($feature_report) > 0){
                $entry = $entry + 1;
                $from = $feature[0] +1;
                $query->where('feature_count','>=',$from)->where('feature_count','<=',$feature[1]);
            }
            if(count($specification_report) > 0){
                $entry = $entry + 1;
                $from = $specification[0] +1;
                $query->where('specification_count','>=',$from)->where('specification_count','<=',$specification[1]);
            }
            if(count($image_report) > 0){
                $entry = $entry + 1;
                $from = $image[0] +1;
                $query->where('image_count','>=',$from)->where('image_count','<=',$image[1]);
            }

            $data = $query->get();
        }

        // good_to_improve
        if($this->range == 'range3'){  
            
            $title_report         = WebsiteData::where('website_id',$this->website_id)->where('title_character_count','>=',$title[1])->where('title_character_count','<=',$title[2])->get();
            $description_report   = WebsiteData::where('website_id',$this->website_id)->where('description_word_count','>=',$description[1])->where('description_word_count','<=',$description[2])->get();
            $feature_report       = WebsiteData::where('website_id',$this->website_id)->where('feature_count','>=',$feature[1])->where('feature_count','<=',$feature[2])->get();
            $specification_report = WebsiteData::where('website_id',$this->website_id)->where('specification_count','>=',$specification[1])->where('specification_count','<=',$specification[2])->get();
            $image_report         = WebsiteData::where('website_id',$this->website_id)->where('image_count','>=',$image[1])->where('image_count','<=',$image[2])->get();

            
            $query = WebsiteData::where('website_id',$this->website_id);
            $entry = 0;

            if(count($title_report) > 0){
                $entry = $entry + 1;
                $from = $title[1] +1;
                $query->where('title_character_count','>=',$from)->where('title_character_count','<=',$title[2]);
            }
            if(count($description_report) > 0){
                $entry = $entry + 1;
                $from = $description[1] +1;
                $query->where('description_word_count','>=',$from)->where('description_word_count','<=',$description[2]);
            }
            if(count($feature_report) > 0){
                $entry = $entry + 1;
                $from = $feature[1] +1;
                $query->where('feature_count','>=',$from)->where('feature_count','<=',$feature[2]);
            }
            if(count($specification_report) > 0){
                $entry = $entry + 1;
                $from = $specification[1] +1;
                $query->where('specification_count','>=',$from)->where('specification_count','<=',$specification[2]);
            }
            if(count($image_report) > 0){
                $entry = $entry + 1;
                $from = $image[1] +1;
                $query->where('image_count','>=',$from)->where('image_count','<=',$image[2]);
            }

            $data = $query->get();
        }

        // average_optimized
        if($this->range == 'range4'){  
            
            $title_report         = WebsiteData::where('website_id',$this->website_id)->where('title_character_count','>=',$title[2])->where('title_character_count','<=',$title[3])->get();
            $description_report   = WebsiteData::where('website_id',$this->website_id)->where('description_word_count','>=',$description[2])->where('description_word_count','<=',$description[3])->get();
            $feature_report       = WebsiteData::where('website_id',$this->website_id)->where('feature_count','>=',$feature[2])->where('feature_count','<=',$feature[3])->get();
            $specification_report = WebsiteData::where('website_id',$this->website_id)->where('specification_count','>=',$specification[2])->where('specification_count','<=',$specification[3])->get();
            $image_report         = WebsiteData::where('website_id',$this->website_id)->where('image_count','>=',$image[2])->where('image_count','<=',$image[3])->get();

            
            $query = WebsiteData::where('website_id',$this->website_id);
            $entry = 0;

            if(count($title_report) > 0){
                $entry = $entry + 1;
                $from = $title[2] +1;
                $query->where('title_character_count','>=',$from)->where('title_character_count','<=',$title[3]);
            }
            if(count($description_report) > 0){
                $entry = $entry + 1;
                $from = $description[2] +1;
                $query->where('description_word_count','>=',$from)->where('description_word_count','<=',$description[3]);
            }
            if(count($feature_report) > 0){
                $entry = $entry + 1;
                $from = $feature[2] +1;
                $query->where('feature_count','>=',$from)->where('feature_count','<=',$feature[3]);
            }
            if(count($specification_report) > 0){
                $entry = $entry + 1;
                $from = $specification[2] +1;
                $query->where('specification_count','>=',$from)->where('specification_count','<=',$specification[3]);
            }
            if(count($image_report) > 0){
                $entry = $entry + 1;
                $from = $image[2] +1;
                $query->where('image_count','>=',$from)->where('image_count','<=',$image[3]);
            }

            $data = $query->get();
        }

        // optimized
        if($this->range == 'range5'){  
            
            $title_report         = WebsiteData::where('website_id',$this->website_id)->where('title_character_count','>=',$title[4])->get();
            $description_report   = WebsiteData::where('website_id',$this->website_id)->where('description_word_count','>=',$description[4])->get();
            $feature_report       = WebsiteData::where('website_id',$this->website_id)->where('feature_count','>=',$feature[4])->get();
            $specification_report = WebsiteData::where('website_id',$this->website_id)->where('specification_count','>=',$specification[4])->get();
            $image_report         = WebsiteData::where('website_id',$this->website_id)->where('image_count','>=',$image[4])->get();

            
            $query = WebsiteData::where('website_id',$this->website_id);
            $entry = 0;

            if(count($title_report) > 0){
                $entry = $entry + 1;
                $query->where('title_character_count','>=',$title[4]);
            }
            if(count($description_report) > 0){
                $entry = $entry + 1;
                $query->where('description_word_count','>=',$description[4]);
            }
            if(count($feature_report) > 0){
                $entry = $entry + 1;
                $query->where('feature_count','>=',$feature[4]);
            }
            if(count($specification_report) > 0){
                $entry = $entry + 1;
                $query->where('specification_count','>=',$specification[4]);
            }
            if(count($image_report) > 0){
                $entry = $entry + 1;
                $query->where('image_count','>=',$image[4]);
            }

            $data = $query->get();
        }
        // dd($data);
        return $data;
    }

    public function headings(): array
    {
        return [
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
        ];
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

        // Feature
        $feature_list = $data->getFeature;
        $feature_count = count($feature_list);
        
        for ($x = 1; $x <= $feature_count; $x++) {
            ${"FEATURE_".$x} = $feature_list[$x-1]->feature;
        }

        // Specification
        $specification_list = $data->getSpecification;
        $specification_count = count($specification_list);
        // dd($data);
        for ($x = 1; $x <= $specification_count; $x++) {
            ${"SPEC_HEADER_".$x} = $specification_list[$x-1]->specification_head;
            ${"SPEC_VALUE_".$x} = $specification_list[$x-1]->specification_value;
        }

        // Image
        $image_list = $data->getImage;
        $image_count = count($image_list);
        for ($x = 1; $x <= $image_count; $x++) {
            ${"IMG_SRC_".$x} = $image_list[$x-1]->image;
        }

        return [
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
        ];
    }
}
