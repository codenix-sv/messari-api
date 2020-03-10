<?php

declare(strict_types=1);

namespace Codenixsv\MessariApi\Api\Tests\Api;

use Codenixsv\ApiClient\BaseClient;
use Codenixsv\MessariApi\Api\News;
use Codenixsv\MessariApi\MessariClient;
use Http\Mock\Client as HttpMockClient;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class NewsTest extends TestCase
{
    public function testGetAll()
    {
        $news = $this->createMarkets($this->mockSuccessfulResponse());
        $news->getAll();

        /** @var RequestInterface $request */
        $request = $news->getClient()->getBaseClient()->getHttpClient()->getLastRequest();
        $this->assertEquals('https://data.messari.io/api/v1/news', $request->getUri()->__toString());
    }

    public function testGetAllWithParams()
    {
        $news = $this->createMarkets($this->mockSuccessfulResponse());
        $news->getAll(1);

        /** @var RequestInterface $request */
        $request = $news->getClient()->getBaseClient()->getHttpClient()->getLastRequest();
        $this->assertEquals('https://data.messari.io/api/v1/news?page=1', $request->getUri()->__toString());
    }

    public function testGetForAsset()
    {
        $news = $this->createMarkets($this->mockSuccessfulResponse());
        $news->getForAsset('btc');

        /** @var RequestInterface $request */
        $request = $news->getClient()->getBaseClient()->getHttpClient()->getLastRequest();
        $this->assertEquals('https://data.messari.io/api/v1/news/btc', $request->getUri()->__toString());
    }

    public function testGetForAssetWithParams()
    {
        $news = $this->createMarkets($this->mockSuccessfulResponse());
        $news->getForAsset('btc', 'title,content,author/name', true);

        /** @var RequestInterface $request */
        $request = $news->getClient()->getBaseClient()->getHttpClient()->getLastRequest();
        $this->assertEquals(
            'https://data.messari.io/api/v1/news/btc?fields=title%2Ccontent%2Cauthor%2Fname&as_markdown=1',
            $request->getUri()->__toString()
        );
    }

    /**
     * @param ResponseInterface $response
     * @return News
     */
    private function createMarkets(ResponseInterface $response): News
    {
        $httpClientMock = new HttpMockClient();
        $httpClientMock->addResponse($response);
        $baseClient = new BaseClient($httpClientMock);
        $messariClient = new MessariClient($baseClient);

        return new News($messariClient);
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
