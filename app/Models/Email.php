<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'message',
        'day',
        'day2',
        'month',
        'month2',
        'enable_sending',
        'send_on_schedule',
        'send_on_schedule2',
    ];
}
