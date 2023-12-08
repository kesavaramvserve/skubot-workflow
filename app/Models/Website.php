<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    use HasFactory;
    protected $table = 'websites';
    protected $fillable = [
        'id',
        'user_id',
        'client_id',
        'first_name',
        'last_name',
        'email',
        'company_name',
        'website',
        'description',
        'status',
        'platform',
        'platform_details',
        'workflow_settings',
        'project_status',
        'reason',
        'download_image',
        'download_asset',
        'time_track',
        'enhance_status',
        'post_payment_status',
        'post_payment_id',
        'validation_status',
        'remark',
        'parent_id',
        'ops_id',
        'tl_id',
        'tl_assigned_at',
        'title_status',
        'description_status',
        'feature_status',
        'specification_status',
        'image_status',
    ];

    public function getScrapeData()
    {
        return $this->hasOne(ScraperData::class, 'website_id', 'id');
    }

    public function getClient()
    {
        return $this->hasOne(Client::class, 'id', 'client_id');
    }

    public function getWebsiteData()
    {
        return $this->hasOne(WebsiteData::class, 'website_id', 'id');
    }

    public function getClientRequiremnet()
    {
        return $this->hasOne(ClientRequirement::class, 'website_id', 'id');
    }

    public function getClientRequestData()
    {
        return $this->hasOne(ClientRequestData::class, 'website_id', 'id');
    }

    public function getEnhancedData()
    {
        return $this->hasOne(EnhancedData::class, 'website_id', 'id');
    }

    public function getWebsiteEnhancedData()
    {
        return $this->hasOne(WebsiteEnhanceData::class, 'website_id', 'id');
    }
    public function getNotes()
    {
        return $this->hasOne(Note::class, 'website_id', 'id');
    }
    public function getCronStatus()
    {
        return $this->hasOne(CronJob::class, 'website_id', 'id');
    }
}
