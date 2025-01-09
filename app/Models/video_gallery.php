<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class video_gallery extends Model
{
    use HasFactory;
    protected $fillable = [

        'video',
    ];
}
