<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo_gallery extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'image',
        'cover',
        'code'
    ];
}
