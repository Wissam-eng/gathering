<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contct_footer extends Model
{
    use HasFactory;
    protected $fillable = [
        'location',
        'phone',
        'whatsapp',
        'email',
        'website',
        'facebook',
        'instagram',
        'twitter',
        'Newsletter',
    ];
}

