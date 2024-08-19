<?php

namespace App\Services;

use App\Services\Rates\Manager as RateManager;

class Schedule
{
  private $rateManager;

  public function __construct()
  {
    $this->rateManager = new RateManager();
  }

  public function runDailyJobs()
  {
    $this->rateManager->refreshRates();
  }
}
