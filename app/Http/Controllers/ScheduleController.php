<?php

namespace App\Http\Controllers;

use App\Services\Schedule;

class ScheduleController extends Controller
{
    private $schedule;
    public function __construct()
    {
        $this->schedule = new Schedule();
    }

    public function trigger($job)
    {
        if ($job == "daily") {
            $this->schedule->runDailyJobs();
        }

        return response()->json(['status' => 'success']);
    }
}
