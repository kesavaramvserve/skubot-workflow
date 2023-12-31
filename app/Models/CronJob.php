<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CronJob extends Model
{
    use HasFactory;
    protected $table = 'cron_jobs';
    protected $fillable = [
        'id','user_id','website_id','scrappe_file_id','status','client_file_id','enhance_status'
    ];
}
