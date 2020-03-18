<?php

declare(strict_types=1);

namespace Codenixsv\MessariApi\Api\Tests\Api\Query;

use Codenixsv\ApiClient\BaseClient;
use Codenixsv\MessariApi\Api\Assets;
use Codenixsv\MessariApi\Api\Query\QueryBuilder;
use Codenixsv\MessariApi\MessariClient;
use Http\Mock\Client as HttpMockClient;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class QueryBuilderTest extends TestCase
{
    public function testBuildQuery()
    {
        $builder = new QueryBuilder();
        $query = $builder->buildQuery(['foo' => 'bar']);

        $this->assertEquals('?foo=bar', $query);
    }

    public function testBuildQueryWithEmptyParams()
    {
        $builder = new QueryBuilder();
        $query = $builder->buildQuery([]);

        $this->assertEquals('', $query);
    }
}
