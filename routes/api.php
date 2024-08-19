<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScheduleController;

Route::post('/schedule/trigger/{job}', [ScheduleController::class, 'trigger'])->middleware('verify.admin.auth');
