<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteImage extends Model
{
    use HasFactory;
    protected $table = 'website_images';
    protected $fillable = [
        'id','website_id','website_data_id','image','width','height','size','alt'
    ];
}
