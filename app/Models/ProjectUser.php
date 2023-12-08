<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectUser extends Model
{
    use HasFactory;
    protected $table = 'project_users';
    protected $fillable = [
        'website_id',
        'user_role',
        'user_id',
        'client_file_id'
    ];
}
