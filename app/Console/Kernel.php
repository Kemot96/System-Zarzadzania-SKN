<?php

namespace App\Console;

use App\Models\AcademicYear;
use App\Models\ClubMember;
use App\Models\Report;
use App\Models\Club;
use App\Models\Role;
use App\Models\TypeOfReport;
use App\Models\User;
use App\Notifications\ActionPlanReminder;
use App\Notifications\NewAcademicYearAcceptanceOfMembers;
use App\Notifications\ReportReminder;
use App\Notifications\SpendingPlanReminder;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $club_members = ClubMember::where('academic_years_id', getCurrentAcademicYear()->id)->get();
            $supervisor_id = Role::where('name', 'opiekun_koła')->value('id');
            $inactive_user_id = Role::where('name', 'nieaktywny')->value('id');

            AcademicYear::where('current_year', true)->first()->update(array(
                'current_year' => false,
            ));

            AcademicYear::create([
                'name' => strval(now()->year) . "/" . strval(now()->year + 1),
                'current_year' => true,
            ]);

            $club_ids = Club::pluck('id')->all();

            foreach ($club_ids as $club_id) {
                Report::create([
                    'clubs_id' => $club_id,
                    'academic_years_id' => getCurrentAcademicYear()->id,
                    'types_id' => TypeOfReport::getReportID(),
                ]);

                Report::create([
                    'clubs_id' => $club_id,
                    'academic_years_id' => getCurrentAcademicYear()->id,
                    'types_id' => TypeOfReport::getSpendingPlanID(),
                ]);

                Report::create([
                    'clubs_id' => $club_id,
                    'academic_years_id' => getCurrentAcademicYear()->id,
                    'types_id' => TypeOfReport::getActionPlanID(),
                ]);
            }

            foreach ($club_members as $club_member) {
                if ($club_member->roles_id == $supervisor_id) {
                    ClubMember::create([
                        'users_id' => $club_member->users_id,
                        'roles_id' => $supervisor_id,
                        'clubs_id' => $club_member->clubs_id,
                        'academic_years_id' => getCurrentAcademicYear()->id,
                        'removal_request' => FALSE,
                    ]);
                } else {
                    ClubMember::create([
                        'users_id' => $club_member->users_id,
                        'roles_id' => $inactive_user_id,
                        'clubs_id' => $club_member->clubs_id,
                        'academic_years_id' => getCurrentAcademicYear()->id,
                        'removal_request' => FALSE,
                    ]);
                }
            }
        })->everyMinute();

        $schedule->call(function () {
            $users = getActiveChairmenAndSupervisors();
            Notification::send($users, new ReportReminder());

        })->yearlyOn(6, 15, '10:00');

        $schedule->call(function () {
            $users = getActiveChairmenAndSupervisors();
            Notification::send($users, new ActionPlanReminder());
            Notification::send($users, new NewAcademicYearAcceptanceOfMembers());

        })->yearlyOn(10, 30, '10:00');

        $schedule->call(function () {

            $users = getActiveChairmenAndSupervisors();
            Notification::send($users, new SpendingPlanReminder());

        })->yearlyOn(11, 15, '10:00');

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
