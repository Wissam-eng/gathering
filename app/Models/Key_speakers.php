<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Key_speakers extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'name',
        'description',
        'image',
        'file',
    ];
}
