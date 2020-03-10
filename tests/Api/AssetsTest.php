<?php

declare(strict_types=1);

namespace Codenixsv\MessariApi\Api\Tests\Api;

use Codenixsv\ApiClient\BaseClient;
use Codenixsv\MessariApi\Api\Assets;
use Codenixsv\MessariApi\MessariClient;
use Http\Mock\Client as HttpMockClient;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class AssetsTest extends TestCase
{
    public function testGetAll()
    {
        $assets = $this->createAssets($this->mockSuccessfulResponse());
        $assets->getAll();

        /** @var RequestInterface $request */
        $request = $assets->getClient()->getBaseClient()->getHttpClient()->getLastRequest();
        $this->assertEquals('https://data.messari.io/api/v1/assets', $request->getUri()->__toString());
    }

    public function testGetAllWithParams()
    {
        $assets = $this->createAssets($this->mockSuccessfulResponse());
        $assets->getAll(true, true);

        /** @var RequestInterface $request */
        $request = $assets->getClient()->getBaseClient()->getHttpClient()->getLastRequest();
        $this->assertEquals(
            'https://data.messari.io/api/v1/assets?with-metrics=&with-profiles=',
            $request->getUri()->__toString()
        );
    }

    public function testGet()
    {
        $assets = $this->createAssets($this->mockSuccessfulResponse());
        $assets->get('btc');

        /** @var RequestInterface $request */
        $request = $assets->getClient()->getBaseClient()->getHttpClient()->getLastRequest();
        $this->assertEquals('https://data.messari.io/api/v1/assets/btc', $request->getUri()->__toString());
    }

    public function testGetProfile()
    {
        $assets = $this->createAssets($this->mockSuccessfulResponse());
        $assets->getProfile('btc');

        /** @var RequestInterface $request */
        $request = $assets->getClient()->getBaseClient()->getHttpClient()->getLastRequest();
        $this->assertEquals('https://data.messari.io/api/v1/assets/btc/profile', $request->getUri()->__toString());
    }

    public function testGetMetrics()
    {
        $assets = $this->createAssets($this->mockSuccessfulResponse());
        $assets->getMetrics('btc');

        /** @var RequestInterface $request */
        $request = $assets->getClient()->getBaseClient()->getHttpClient()->getLastRequest();
        $this->assertEquals('https://data.messari.io/api/v1/assets/btc/metrics', $request->getUri()->__toString());
    }

    public function testGetMarketData()
    {
        $assets = $this->createAssets($this->mockSuccessfulResponse());
        $assets->getMarketData('btc');

        /** @var RequestInterface $request */
        $request = $assets->getClient()->getBaseClient()->getHttpClient()->getLastRequest();
        $this->assertEquals(
            'https://data.messari.io/api/v1/assets/btc/metrics/market-data',
            $request->getUri()->__toString()
        );
    }

    public function testGetTimeseries()
    {
        $assets = $this->createAssets($this->mockSuccessfulResponse());
        $assets->getTimeseries('btc', 'price');

        /** @var RequestInterface $request */
        $request = $assets->getClient()->getBaseClient()->getHttpClient()->getLastRequest();
        $this->assertEquals(
            'https://data.messari.io/api/v1/assets/btc/metrics/price/time-series',
            $request->getUri()->__toString()
        );
    }

    public function testGetTimeseriesWithParams()
    {
        $assets = $this->createAssets($this->mockSuccessfulResponse());
        $assets->getTimeseries('btc', 'price', '2020-01-01', '2020-01-07', '1d');

        /** @var RequestInterface $request */
        $request = $assets->getClient()->getBaseClient()->getHttpClient()->getLastRequest();
        $this->assertEquals(
            'https://data.messari.io/api/v1/assets/btc/metrics/price/time-series?start=2020-01-01&end=2020-01'
            . '-07&interval=1d',
            $request->getUri()->__toString()
        );
    }

    /**
     * @param ResponseInterface $response
     * @return Assets
     */
    private function createAssets(ResponseInterface $response): Assets
    {
        $httpClientMock = new HttpMockClient();
        $httpClientMock->addResponse($response);
        $baseClient = new BaseClient($httpClientMock);
        $messariClient = new MessariClient($baseClient);

        return new Assets($messariClient);
    }

    /**
     * @return ResponseInterface
     */
    private function mockSuccessfulResponse(): ResponseInterface
    {
        $response = $this->createMock('Psr\Http\Message\ResponseInterface');
        $response->method('getBody')->willReturn(json_encode([]));
        $response->method('getHeaderLine')->willReturn('application/json');

        return $response;
    }
}
