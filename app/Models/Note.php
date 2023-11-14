<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;
    protected $table = 'notes';
    protected $fillable = [
        'website_id',
        'status',
        'internal_notes',
        'client_notes',
        'title_notes',
        'description_notes',
        'feature_notes',
        'specification_notes',
        'image_notes',
        'overall_notes',
        'category'
    ];
}
