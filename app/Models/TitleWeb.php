<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TitleWeb extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_introduce',
        'title_goals',
        'title_Sponsorships',
        'title_Gallery',
        'title_FeaturedSpeakers',
        'title_MediaPartner',
        'title_TargetGroup',
        'title_ForumManagement',
        'title_Organizer',
        'title_LATEST_NEWS',

    ];
}
