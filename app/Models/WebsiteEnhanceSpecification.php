<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteEnhanceSpecification extends Model
{
    use HasFactory;
    protected $table = 'website_enhance_specifications';
    protected $fillable = [
        'id','website_id','website_enhance_data_id','specification_head','specification_value'
    ];
}
