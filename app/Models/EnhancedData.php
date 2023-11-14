<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnhancedData extends Model
{
    use HasFactory;
    protected $table = 'enhanced_datas';
    protected $fillable = [
        'id','website_id','path'
    ];
}
