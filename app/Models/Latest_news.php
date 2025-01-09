<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Latest_news extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'date',
        'image',
    ];
}
