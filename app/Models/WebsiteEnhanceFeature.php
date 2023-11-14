<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteEnhanceFeature extends Model
{
    use HasFactory;
    protected $table = 'website_enhance_features';
    protected $fillable = [
        'id','website_id','website_enhance_data_id','feature'
    ];
}
