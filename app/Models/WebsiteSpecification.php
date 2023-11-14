<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteSpecification extends Model
{
    use HasFactory;
    protected $table = 'website_specifications';
    protected $fillable = [
        'id','website_id','website_data_id','specification_head','specification_value'
    ];
}
