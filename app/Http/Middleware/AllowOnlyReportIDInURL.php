<?php

namespace App\Http\Middleware;

use App\Models\TypeOfReport;
use Closure;
use Illuminate\Http\Request;

class AllowOnlyReportIDInURL
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
        $report = $request -> report;
        $club = $request -> club;
        $current_academic_year = getCurrentAcademicYear();
        if($report->types_id == TypeOfReport::getReportID() && $report->clubs_id == $club->id && $report->academic_years_id == $current_academic_year->id)
        {
            return $next($request);
        }
        else{
            return back();
        }
    }
}
