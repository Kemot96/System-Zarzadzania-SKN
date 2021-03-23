<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClubMember extends Model
{
    use HasFactory;



    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'roles_id');
    }

    public function club()
    {
        return $this->belongsTo(Club::class, 'clubs_id');
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class, 'academic_years_id');
    }

}
