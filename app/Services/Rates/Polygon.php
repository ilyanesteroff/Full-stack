<?php

namespace App\Services\Rates;

use Illuminate\Support\Facades\Http;
use App\Services\Rates\API;

class Polygon extends API
{
  private $key;

  public function __construct(string $key)
  {
    $this->key = $key;
  }

  public function constructURL(string $date)
  {
    $url = "https://api.polygon.io/v2/aggs/grouped/locale/global/market/fx/{$date}?adjusted=true&apiKey={$this->key}";

    return $url;
  }

  public function fetch(string $date): array
  {
    try {
      $url = $this->constructURL($date);
      $res = Http::get($url);

      return $res->successful() ? $res->json('results') : [];
    } catch (\Exception $e) {
      return [];
    }
  }

  public function extractData(array $data): array
  {
    $tickers = str_replace('C:', '', $data['T']);
    $target = strtoupper(substr($tickers, -3));
    $base = strtoupper(substr($tickers, 0, 3));

    return ['base' => $base, 'target' => $target, 'rate' => $data['o']];
  }
}
