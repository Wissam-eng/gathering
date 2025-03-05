<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class registerIn extends Model
{
    use HasFactory;
    protected $fillable = [
        'register_as',
        'first_name',
        'last_name',
        'email',
        'phone',
        'company',
        'job_title',
        'city',
        'image',
    ];
}
