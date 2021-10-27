<?php

namespace App\Console;

use App\Models\AcademicYear;
use App\Models\ClubMember;
use App\Models\Email;
use App\Models\File;
use App\Models\Report;
use App\Models\Club;
use App\Models\Role;
use App\Models\TypeOfReport;
use App\Models\User;
use App\Notifications\ActionPlanReminder;
use App\Notifications\NewAcademicYearAcceptanceOfMembers;
use App\Notifications\ReportReminder;
use App\Notifications\SpendingPlanDemandReminder;
use App\Notifications\SpendingPlanReminder;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

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
            $files_size_limit_for_club = 10240; //size in MB (10 MB)
            $clubs = Club::all();

            foreach ($clubs as $club) {
                $files = Storage::allFiles('public/clubFiles/'.$club->id);

                $size = 0;

                foreach ($files as $file) {
                    $size += Storage::size($file);
                }

                $size = round($size/1048576, 2); //size converted to MB

                while ($size > $files_size_limit_for_club)
                {
                    $oldest_file = File::where('clubs_id', $club->id)->oldest()->first();

                    if (Storage::disk('public')->exists($oldest_file->name)) {
                        $oldest_file_size = round(Storage::size('public/'.$oldest_file->name)/1048576, 2);
                        Storage::disk('public')->delete($oldest_file->name);
                        $size = $size - $oldest_file_size;
                    }

                    $oldest_file->delete();
                }
            }
        })->daily();



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
                $action_plan_description = NULL;
                $previous_academic_year_name = strval(now()->year - 1) . "/" . strval(now()->year);
                $previous_academic_year = AcademicYear::where('name', $previous_academic_year_name)->first();
                if($previous_academic_year)
                {
                    $previous_academic_year_id = $previous_academic_year->id;
                    $action_plan = Report::where('clubs_id', $club_id) -> where('types_id', TypeOfReport::getActionPlanID()) -> where('academic_years_id', $previous_academic_year_id)->first();
                    if($action_plan)
                    {
                        $action_plan_description = 'Uwaga: poniżej skopiowano plan działań z ostatniego roku. Proszę opisać co udało się zrealizować, a co nie i z jakich powodów.'
                            .$action_plan->description;
                    }
                }

                Report::create([
                    'clubs_id' => $club_id,
                    'academic_years_id' => getCurrentAcademicYear()->id,
                    'types_id' => TypeOfReport::getReportID(),
                    'supervisor_approved' => NULL,
                    'secretariat_approved' => NULL,
                    'vice-rector_approved' => NULL,
                    'description' => $action_plan_description,
                ]);

                Report::create([
                    'clubs_id' => $club_id,
                    'academic_years_id' => getCurrentAcademicYear()->id,
                    'types_id' => TypeOfReport::getSpendingPlanID(),
                    'supervisor_approved' => NULL,
                    'secretariat_approved' => NULL,
                    'vice-rector_approved' => NULL,
                ]);

                Report::create([
                    'clubs_id' => $club_id,
                    'academic_years_id' => getCurrentAcademicYear()->id,
                    'types_id' => TypeOfReport::getActionPlanID(),
                    'supervisor_approved' => NULL,
                    'secretariat_approved' => NULL,
                    'vice-rector_approved' => NULL,
                    'description' => 'Uwaga: Prosimy o przedstawienie planowanych działań w punktach',
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
        })->yearlyOn(9, 15, '10:00');

        if(Email::latest()->where('type', 'report_reminder')->value('enable_sending'))
        {
            $schedule->call(function () {
                $users = getActiveChairmenAndSupervisors();
                Notification::send($users, new ReportReminder());
            })->yearlyOn(Email::latest()->where('type', 'report_reminder')->value('month'), Email::latest()->where('type', 'spending_plan_reminder')->value('day'), '10:00');

            $schedule->call(function () {
                $users = getActiveChairmenAndSupervisors();
                Notification::send($users, new ReportReminder());
            })->yearlyOn(Email::latest()->where('type', 'report_reminder')->value('month2'), Email::latest()->where('type', 'spending_plan_reminder')->value('day2'), '10:00');
        }


        if(Email::latest()->where('type', 'action_plan_reminder')->value('enable_sending'))
        {
            $schedule->call(function () {
                $users = getActiveChairmenAndSupervisors();
                Notification::send($users, new ActionPlanReminder());
            })->yearlyOn(Email::latest()->where('type', 'action_plan_reminder')->value('month'), Email::latest()->where('type', 'spending_plan_reminder')->value('day'), '10:00');

            $schedule->call(function () {
                $users = getActiveChairmenAndSupervisors();
                Notification::send($users, new ActionPlanReminder());
            })->yearlyOn(Email::latest()->where('type', 'action_plan_reminder')->value('month2'), Email::latest()->where('type', 'spending_plan_reminder')->value('day2'), '10:00');
        }

        if(Email::latest()->where('type', 'new_academic_year_acceptance_of_members')->value('enable_sending'))
        {
            $schedule->call(function () {
                $users = getActiveChairmenAndSupervisors();
                Notification::send($users, new NewAcademicYearAcceptanceOfMembers());
            })->yearlyOn(Email::latest()->where('type', 'new_academic_year_acceptance_of_members')->value('month'), Email::latest()->where('type', 'spending_plan_reminder')->value('day'), '10:00');

            $schedule->call(function () {
                $users = getActiveChairmenAndSupervisors();
                Notification::send($users, new NewAcademicYearAcceptanceOfMembers());
            })->yearlyOn(Email::latest()->where('type', 'new_academic_year_acceptance_of_members')->value('month2'), Email::latest()->where('type', 'spending_plan_reminder')->value('day2'), '10:00');
        }


        if(Email::latest()->where('type', 'spending_plan_reminder')->value('enable_sending'))
        {
            $schedule->call(function () {
                $users = getActiveChairmenAndSupervisors();
                Notification::send($users, new SpendingPlanReminder());
            })->yearlyOn(Email::latest()->where('type', 'spending_plan_reminder')->value('month'), Email::latest()->where('type', 'spending_plan_reminder')->value('day'), '10:00');

            $schedule->call(function () {
                $users = getActiveChairmenAndSupervisors();
                Notification::send($users, new SpendingPlanReminder());
            })->yearlyOn(Email::latest()->where('type', 'spending_plan_reminder')->value('month2'), Email::latest()->where('type', 'spending_plan_reminder')->value('day2'), '10:00');
        }

        if(Email::latest()->where('type', 'spending_plan_demand_reminder')->value('enable_sending'))
        {
            $schedule->call(function () {
                $users = getActiveChairmenAndSupervisors();
                Notification::send($users, new SpendingPlanDemandReminder());
            })->yearlyOn(Email::latest()->where('type', 'spending_plan_demand_reminder')->value('month'), Email::latest()->where('type', 'spending_plan_reminder')->value('day'), '10:00');

            $schedule->call(function () {
                $users = getActiveChairmenAndSupervisors();
                Notification::send($users, new SpendingPlanDemandReminder());
            })->yearlyOn(Email::latest()->where('type', 'spending_plan_demand_reminder')->value('month2'), Email::latest()->where('type', 'spending_plan_reminder')->value('day2'), '10:00');
        }
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
