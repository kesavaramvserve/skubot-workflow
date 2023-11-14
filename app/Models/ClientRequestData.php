<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientRequestData extends Model
{
    use HasFactory;
    protected $table = 'client_request_datas';
    protected $fillable = [
        'id','website_id','path'
    ];
}
