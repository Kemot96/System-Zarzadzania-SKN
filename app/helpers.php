<?php


use App\Models\AcademicYear;

if (! function_exists('getCurrentAcademicYear')) {
    function getCurrentAcademicYear() {
        return AcademicYear::latest()->where('current_year', '1')->first();
    }
}

