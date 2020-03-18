<?php

declare(strict_types=1);

namespace Codenixsv\MessariApi\Api;

use Codenixsv\MessariApi\Message\ResponseTransformer;
use Codenixsv\MessariApi\MessariClient;
use Codenixsv\MessariApi\Api\Query\QueryBuilder;
use Codenixsv\MessariApi\Api\Query\QueryBuilderInterface;

/**
 * Class Api
 * @package Codenixsv\MessariApi\Api
 */
class Api
{
    /** @var MessariClient  */
    protected $client;

    /** @var ResponseTransformer  */
    protected $transformer;

    /** @var QueryBuilderInterface */
    protected $queryBuilder;

    /**
     * Api constructor.
     * @param MessariClient $client
     * @param QueryBuilderInterface|null $queryBuilder
     */
    public function __construct(MessariClient $client, ?QueryBuilderInterface $queryBuilder = null)
    {
        $this->client = $client;
        $this->transformer = new ResponseTransformer();
        $this->queryBuilder = $queryBuilder ?: new QueryBuilder();
    }

    /**
     * @return MessariClient
     */
    public function getClient(): MessariClient
    {
        return $this->client;
    }
}
