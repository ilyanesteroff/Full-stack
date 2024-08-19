<?php

namespace App\Services\Rates;

use App\Services\Rates\Model;

class View
{
  private $model;

  public function __construct()
  {
    $this->model = new Model();
  }

  public function filter(string $base, string $target, string $date)
  {
    $query = $this->model->query();
    $query->where('base', strtoupper($base));

    if ($target) {
      $query->where('target', strtoupper($target));
    }
    if ($date) {
      $query->where('date', $date);
    }

    try {
      $output = $query->get();

      return $output;
    } catch (\Exception $e) {
      return [];
    }
  }
}
