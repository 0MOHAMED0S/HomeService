<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProviderProfile extends Model
{
    protected $fillable = [
        'user_id',
        'profession_id',
        'skills',
        'languages',
        'experience_years',
        'bio',
        'longitude',
        'latitude',
        'profile_picture',
        'id_front',
        'id_back',
        'police_clearance',
        'commercial_register',
        'status',
        'rejection_reason',
        'field_statuses',
    ];

    protected $casts = [
        'skills' => 'array',
        'languages' => 'array',
        'field_statuses' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function profession()
    {
        return $this->belongsTo(Profession::class);
    }
}
