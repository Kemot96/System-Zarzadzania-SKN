<?php

namespace App\Http\Middleware;

use App\Models\AcademicYear;
use App\Models\ClubMember;
use App\Models\Role;
use App\Models\Club;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccessToClubPage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $club = $request->club;

        $role_name = $club->getLoggedUserRoleName();
        if($role_name == 'opiekun_koła'|| $role_name == 'członek_koła' || $role_name == 'przewodniczący_koła')
        {
            return $next($request);
        }
        return redirect(route('joinClub', ['club' => $club]));
    }
}
