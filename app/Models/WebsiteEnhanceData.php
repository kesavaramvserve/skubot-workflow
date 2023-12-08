<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteEnhanceData extends Model
{
    use HasFactory;
    protected $table = 'website_enhance_datas';
    protected $fillable = [
        'id',
        'website_id',
        'status',
        'title',
        'description',
        'brand',
        'title_metadata',
        'description_metadata',
        'keywords_metadata',
        'title_metadata_length',
        'description_metadata_length',
        'keywords_metadata_length',
        'rating',
        'rating_count',
        'qa_count',
        'category',
        'stock',
        'title_character_count',
        'description_word_count',
        'feature_count',
        'specification_count',
        'image_count',
        'url',
        'p_id',
        'mpn',
        'tag',
        'batch_id',
        'supplier_type',
        'tl_id',
        'pa_id',
        'qc_id',
        'da_id',
        'qa_id',
        'pa_started_at',
        'pa_ended_at',
        'pa_approved_at',
        'qc_approved_at',
        'da_approved_at',
        'qa_approved_at',
        'pa_assigned_at',
        'qc_assigned_at',
        'da_assigned_at',
        'qa_assigned_at',
        'live_updated_at',
        'pa_done',
        'qc_done',
        'da_done',
        'qa_done',
        'summary',
        'rework',
        'name_error',
        'caption_error',
        'manf_error',
        'image_error',
        'path_error',
        'other_error',
        'reject_status'
    ];

    public function getWebsite()
    {
        return $this->hasOne(Website::class, 'id', 'website_id');
    }

    public function getFeature()
    {
        return $this->hasMany(WebsiteFeature::class, 'website_data_id', 'id');
    }

    public function getSpecification()
    {
        return $this->hasMany(WebsiteSpecification::class, 'website_data_id', 'id');
    }
    
    public function getImage()
    {
        return $this->hasMany(WebsiteImage::class, 'website_data_id', 'id');
    }
    
    public function getEnhanceFeature()
    {
        return $this->hasMany(WebsiteEnhanceFeature::class, 'website_enhance_data_id', 'id');
    }

    public function getEnhanceSpecification()
    {
        return $this->hasMany(WebsiteEnhanceSpecification::class, 'website_enhance_data_id', 'id');
    }
    
    public function getEnhanceImage()
    {
        return $this->hasMany(WebsiteEnhanceImage::class, 'website_enhance_data_id', 'id');
    }

    public function getTL()
    {
        return $this->hasOne(User::class, 'id', 'tl_id');
    }

    public function getPA()
    {
        return $this->hasOne(User::class, 'id', 'pa_id');
    }

    public function getQC()
    {
        return $this->hasOne(User::class, 'id', 'qc_id');
    }

    public function getDA()
    {
        return $this->hasOne(User::class, 'id', 'da_id');
    }

    public function getQA()
    {
        return $this->hasOne(User::class, 'id', 'qa_id');
    }
}
