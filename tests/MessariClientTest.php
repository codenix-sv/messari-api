<?php

declare(strict_types=1);

namespace Codenixsv\MessariApi\Tests;

use Codenixsv\ApiClient\BaseClient;
use Codenixsv\ApiClient\BaseClientInterface;
use Codenixsv\MessariApi\Api\Assets;
use Codenixsv\MessariApi\Api\Markets;
use Codenixsv\MessariApi\Api\News;
use Codenixsv\MessariApi\MessariClient;
use PHPUnit\Framework\TestCase;

class MessariClientTest extends TestCase
{
    public function testGetBaseClient()
    {
        $client = new MessariClient(new BaseClient());

        $this->assertInstanceOf(BaseClientInterface::class, $client->getBaseClient());
    }

    public function testAssets()
    {
        $client = new MessariClient(new BaseClient());

        $this->assertInstanceOf(Assets::class, $client->assets());
    }

    public function testMarkets()
    {
        $client = new MessariClient(new BaseClient());

        $this->assertInstanceOf(Markets::class, $client->markets());
    }

    public function testNews()
    {
        $client = new MessariClient(new BaseClient());

        $this->assertInstanceOf(News::class, $client->news());
    }
}
