<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AllowAccessToChairman
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
        if($role_name == 'przewodniczący_koła')
        {
            return $next($request);
        }
        return back();
    }
}
