<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionMember extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'sections_id');
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class, 'academic_years_id');
    }
}
