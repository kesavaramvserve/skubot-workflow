<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientPrice extends Model
{
    use HasFactory;
    protected $table = 'client_prices';
    protected $fillable = [
        'id','client_id','website_id','content_id','range_id','price'
    ];
}
