<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class header extends Model
{
    use HasFactory;
    protected $fillable = [
        'header_value1',
        'header_value2',
        'header_value3',
        'header_value4',
        'header_value5',
        'header_value6',
    ];
}
