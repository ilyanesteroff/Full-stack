<?php

namespace App\Services\Rates;

use Illuminate\Support\Carbon;
use App\Services\Rates\Model;
use Ramsey\Uuid\Uuid;

class Manager
{
  private $range = [1, 2, 3, 4];
  private $model;

  public function __construct()
  {
    $this->model = new Model();
  }

  public function refreshRates()
  {
    $output = [];
    $version = Uuid::uuid4()->toString();

    foreach ($this->range as $day) {
      $date = Carbon::now()->subDays($day + 1)->toDateString();
      $rates = $this->model->gatherForSpecificDate($date, $version);
      $output = array_merge($output, $rates);
    }

    if (count($output) > 0) {
      $this->model->insertIntoDB($output, $version);
    }
  }
}
