<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Club extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'icon',
        'description',
    ];

    public function getCreatedAtAttribute($value)
    {
        return date('d-m-Y H:i:s', strtotime($value));
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('d-m-Y H:i:s', strtotime($value));
    }

    public function sections()
    {
        return $this->hasMany(Section::class, 'clubs_id');
    }

    public function files()
    {
        return $this->hasMany(File::class, 'clubs_id');
    }

    public function clubMembers()
    {
        return $this->hasMany(ClubMember::class, 'clubs_id');
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'clubs_id');
    }

    public function getLoggedUserRoleName(){
        $user = Auth::user();

        $current_academic_year = AcademicYear::latest()->where('current_year', '1')->first();

        $get_club_member_query = ClubMember::latest()->find(1)
                ->where('users_id', $user->id)
                ->where('clubs_id', $this->id)
                ->where('academic_years_id', $current_academic_year -> id);

        if ($get_club_member_query->exists()) {
            $role_id = $get_club_member_query->value('roles_id');

            //return name of role
            return Role::latest()->find(1)->where('id', $role_id)->first()->name;
        }
        return NULL;
    }

}
