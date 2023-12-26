<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientRequestData extends Model
{
    use HasFactory;
    protected $table = 'client_request_datas';
    protected $fillable = [
        'id','website_id','path','notes'
    ];

    public function getScarperData()
    {
        return $this->hasOne(ScraperData::class, 'client_file_id', 'id');
    }

    public function getWebsite()
    {
        return $this->hasOne(Website::class, 'id', 'website_id');
    }
}
