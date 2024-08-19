<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Rates\Manager as RateManager;

class CurrencyRateServiceProvider extends ServiceProvider
{
  private $rateManager;
  public function __construct()
  {
    $this->rateManager = new RateManager();
  }

  public function register()
  {

  }

  public function boot()
  {
    if (app()->runningInConsole() && in_array('migrate', request()->server('argv', []))) {
      return;
    }

    $this->rateManager->refreshRates();
  }
}
