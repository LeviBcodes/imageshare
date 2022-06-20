<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'location',
        'about',
        'profile_image',
        'background_image',
        'linkedin_url',
        'twitter_url',
    ];

    public function profileImage()
    {
        $imagePath = ($this->profile_image) ? $this->profile_image : 'profile/default_profile_image.png';
        return '../../storage/' . $imagePath;
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
