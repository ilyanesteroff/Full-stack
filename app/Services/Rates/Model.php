<?php

namespace App\Services\Rates;

use Illuminate\Support\Facades\DB;
use App\Services\Rates\Polygon;

class Model
{
  private $api;
  private $table = 'currency_rates';

  public function __construct()
  {
    $this->api = new Polygon(env('POLYGON_API_KEY'));
  }

  public function query()
  {
    return DB::table($this->table);
  }

  public function formatFromAPI(array $entry, string $date, string $version): array
  {
    $data = $this->api->extractData($entry);

    return [
      'date' => $date,
      'version' => $version,
      'base' => $data['base'],
      'rate' => $data['rate'],
      'target' => $data['target']
    ];
  }

  public function gatherForSpecificDate(string $date, string $version)
  {
    $output = [];
    $rates = $this->api->fetch($date);

    foreach ($rates as $entry) {
      $output[] = $this->formatFromAPI($entry, $date, $version);
    }

    return $output;
  }

  public function insertIntoDB(array $entries, string $version)
  {
    DB::beginTransaction();

    try {
      foreach (array_chunk($entries, 180) as $chunk) {
        $this->query()->insert($chunk);
      }
      $this->query()->where('version', '!=', $version)->delete();
      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();
      throw $e;
    }
  }
}
