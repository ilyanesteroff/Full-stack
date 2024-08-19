<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\Rates\Polygon;
use Illuminate\Support\Facades\Http;

class PolygonServiceTest extends TestCase
{
    private $polygonService;
    private $apiKey = 'key';

    protected function setUp(): void
    {
        parent::setUp();

        $this->polygonService = new Polygon($this->apiKey);
    }

    public function testConstructURL()
    {
        $date = '2024-08-18';
        $expectedUrl = "https://api.polygon.io/v2/aggs/grouped/locale/global/market/fx/{$date}?adjusted=true&apiKey={$this->apiKey}";

        $this->assertEquals($expectedUrl, $this->polygonService->constructURL($date));
    }

    public function testFetchSuccess()
    {
        $date = '2024-08-18';
        $responseData = [
            ['T' => 'C:USDJPY', 'o' => 110.5],
        ];

        Http::fake([
            $this->polygonService->constructURL($date) => Http::response(['results' => $responseData], 200),
        ]);

        $result = $this->polygonService->fetch($date);
        $this->assertEquals($responseData, $result);
    }

    public function testFetchFailure()
    {
        $date = '2024-08-18';

        Http::fake([
            $this->polygonService->constructURL($date) => Http::response(null, 500),
        ]);

        $result = $this->polygonService->fetch($date);
        $this->assertEquals([], $result);
    }

    public function testExtractData()
    {
        $data = ['T' => 'C:USDJPY', 'o' => 110.5];
        $expected = ['base' => 'USD', 'target' => 'JPY', 'rate' => 110.5];

        $this->assertEquals($expected, $this->polygonService->extractData($data));
    }

    public function testExtractDataWithDifferentTickerFormat()
    {
        $data = ['T' => 'C:EURUSD', 'o' => 1.18];
        $expected = ['base' => 'EUR', 'target' => 'USD', 'rate' => 1.18];

        $this->assertEquals($expected, $this->polygonService->extractData($data));
    }
}
