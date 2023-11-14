<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteFeature extends Model
{
    use HasFactory;
    protected $table = 'website_features';
    protected $fillable = [
        'id','website_id','website_data_id','feature'
    ];
}
