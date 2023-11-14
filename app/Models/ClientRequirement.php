<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientRequirement extends Model
{
    use HasFactory;
    protected $table = 'client_requirements';
    protected $fillable = [
        'id','client_id','website_id','client_price_id'
    ];
}
