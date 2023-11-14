<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteRange extends Model
{
    use HasFactory;
    protected $table = 'website_ranges';
    protected $fillable = [
        'id','website_id','content','high_attention_required','needs_improvement','good_to_improve','average_optimized','optimized'
    ];
}
