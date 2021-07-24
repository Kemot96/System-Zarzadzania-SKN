<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'users_id',
        'clubs_id',
        'academic_years_id',
        'types_id',
        'description',
        'remarks',
        'supervisor_approved',
        'secretariat_approved',
        'vice-rector_approved',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function club()
    {
        return $this->belongsTo(Club::class, 'clubs_id');
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class, 'academic_years_id');
    }

    public function type()
    {
        return $this->belongsTo(TypeOfReport::class, 'types_id');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'reports_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'reports_id');
    }
}
