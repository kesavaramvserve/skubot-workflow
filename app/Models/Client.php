<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $table = 'clients';
    protected $fillable = [
        'id','user_id','company_name','website'
    ];

    public function getUser()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
