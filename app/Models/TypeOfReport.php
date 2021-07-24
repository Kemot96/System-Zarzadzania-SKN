<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeOfReport extends Model
{
    public $table = "type_of_report";

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    public static function getReportID()
    {
        return TypeOfReport::where('name', 'Sprawozdanie')->first()->id;
    }

    public static function getSpendingPlanID()
    {
        return TypeOfReport::where('name', 'Plan wydatków')->first()->id;
    }

    public static function getActionPlanID()
    {
        return TypeOfReport::where('name', 'Plan działań')->first()->id;
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'types_id');
    }
}
