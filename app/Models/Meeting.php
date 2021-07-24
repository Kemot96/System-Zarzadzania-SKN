<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;

    protected $casts = [
        'present_members' => 'array',
    ];

    protected $fillable = [
        'clubs_id',
        'supervisor_approved',
        'topic',
        'present_members',
    ];
}
