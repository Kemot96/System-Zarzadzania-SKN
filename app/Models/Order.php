<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'reports_id',
        'name',
        'description',
        'type',
        'quantity',
        'gross',
        'term',
    ];

    public function report()
    {
        return $this->belongsTo(Report::class, 'reports_id');
    }
}
