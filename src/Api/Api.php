<?php

declare(strict_types=1);

namespace Codenixsv\MessariApi\Api;

use Codenixsv\MessariApi\Message\ResponseTransformer;
use Codenixsv\MessariApi\MessariClient;
use Codenixsv\MessariApi\Api\Query\QueryBuilder;
use Codenixsv\MessariApi\Api\Query\QueryBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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

    /**
     * @param string $path
     * @param string $assetKey
     * @param string $metricId
     * @param array $params
     * @return array
     * @throws \Exception
     */
    protected function timeseries(string $path, string $assetKey, string $metricId, array $params): array
    {
        $query = $this->queryBuilder->buildQuery($params);
        $response = $this->client->getBaseClient()->get('/' . $path . '/' . strtolower($assetKey) . '/metrics/'
            . $metricId . '/time-series' . $query);

        return $this->transformer->transform($response);
    }

    /**
     * @param string $path
     * @param array $params
     * @return array
     * @throws \Exception
     */
    protected function all(string $path, array $params): array
    {
        $query = $this->queryBuilder->buildQuery($params);
        $response = $this->client->getBaseClient()->get('/' . $path . $query);

        return $this->transformer->transform($response);
    }
}
