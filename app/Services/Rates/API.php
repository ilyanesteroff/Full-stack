<?php

namespace App\Services\Rates;

abstract class API
{
  abstract public function fetch(string $date): array;
  abstract public function extractData(array $data): array;
}