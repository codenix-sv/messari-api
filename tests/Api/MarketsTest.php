<?php

declare(strict_types=1);

namespace Codenixsv\MessariApi\Api\Tests\Api;

use Codenixsv\ApiClient\BaseClient;
use Codenixsv\MessariApi\Api\Markets;
use Codenixsv\MessariApi\MessariClient;
use Http\Mock\Client as HttpMockClient;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class MarketsTest extends TestCase
{
    public function testGetAll()
    {
        $markets = $this->createMarkets($this->mockSuccessfulResponse());
        $markets->getAll();

        /** @var RequestInterface $request */
        $request = $markets->getClient()->getBaseClient()->getHttpClient()->getLastRequest();
        $this->assertEquals('https://data.messari.io/api/v1/markets', $request->getUri()->__toString());
    }

    public function testGetAllWithParams()
    {
        $markets = $this->createMarkets($this->mockSuccessfulResponse());
        $markets->getAll(1);

        /** @var RequestInterface $request */
        $request = $markets->getClient()->getBaseClient()->getHttpClient()->getLastRequest();
        $this->assertEquals('https://data.messari.io/api/v1/markets?page=1', $request->getUri()->__toString());
    }

    public function testGetTimeseries()
    {
        $markets = $this->createMarkets($this->mockSuccessfulResponse());
        $markets->getTimeseries('binance-btc-usdt', 'price');

        /** @var RequestInterface $request */
        $request = $markets->getClient()->getBaseClient()->getHttpClient()->getLastRequest();
        $this->assertEquals(
            'https://data.messari.io/api/v1/markets/binance-btc-usdt/metrics/price/time-series',
            $request->getUri()->__toString()
        );
    }

    public function testGetTimeseriesWithParams()
    {
        $markets = $this->createMarkets($this->mockSuccessfulResponse());
        $markets->getTimeseries('binance-btc-usdt', 'price', '2020-01-01', '2020-01-07', '1d');

        /** @var RequestInterface $request */
        $request = $markets->getClient()->getBaseClient()->getHttpClient()->getLastRequest();
        $this->assertEquals(
            'https://data.messari.io/api/v1/markets/binance-btc-usdt/metrics/price/time-series?start=2020-01-01'
            . '&end=2020-01-07&interval=1d',
            $request->getUri()->__toString()
        );
    }

    /**
     * @param ResponseInterface $response
     * @return Markets
     */
    private function createMarkets(ResponseInterface $response): Markets
    {
        $httpClientMock = new HttpMockClient();
        $httpClientMock->addResponse($response);
        $baseClient = new BaseClient($httpClientMock);
        $messariClient = new MessariClient($baseClient);

        return new Markets($messariClient);
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
