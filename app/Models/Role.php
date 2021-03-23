<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    public function rights()
    {
        return $this->belongsToMany(Right::class, 'roles_rights', 'rights_id', 'roles_id');
    }

    public function clubMembers()
    {
        return $this->hasMany(ClubMember::class, 'roles_id');
    }


}
