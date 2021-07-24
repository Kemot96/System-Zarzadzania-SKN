<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'reports_id',
        'name',
        'original_file_name',
    ];

    public function report()
    {
        return $this->belongsTo(Report::class, 'reports_id');
    }
}
