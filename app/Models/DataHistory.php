<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataHistory extends Model
{
    use HasFactory;
    protected $table = 'data_histories';
    protected $fillable = [
        'user_id','website_id','action'
    ];
}
