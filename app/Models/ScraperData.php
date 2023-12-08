<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScraperData extends Model
{
    use HasFactory;
    protected $table = 'scraper_datas';
    protected $fillable = [
        'id','scraper_user_id','website_id','client_file_id','path'
    ];

    public function getWebsite()
    {
        return $this->hasOne(Website::class, 'id', 'website_id');
    }
}
