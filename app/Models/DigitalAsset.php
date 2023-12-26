<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DigitalAsset extends Model
{
    use HasFactory;
    protected $table = 'digital_assets';
    protected $fillable = [
        'id',
        'website_enhance_data_id',
        'file_type',
        'file_url',
        'file_name',
        'is_manual_upload',
    ];
}
