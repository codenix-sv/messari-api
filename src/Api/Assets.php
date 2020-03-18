<?php

declare(strict_types=1);

namespace Codenixsv\MessariApi\Api;

use Exception;

/**
 * Class Assets
 * @package Codenixsv\MessariApi\Api
 */
class Assets extends Api
{
    /**
     * Get the paginated list of all assets and their metrics and profiles.
     *
     * @param array $params
     * @return array
     * @throws Exception
     */
    public function getAll($params = []): array
    {
        return $this->all('assets', $params);
    }

    /**
     * Get basic metadata for an asset.
     *
     * @param string $assetKey This "key" can be the asset's ID (unique), slug (unique), or symbol (non-unique)
     * @param string|null $fields pare down the returned fields (comma , separated, drill down with a slash /)
     * @return array
     * @throws Exception
     */
    public function get(string $assetKey, ?string $fields = null): array
    {
        $query = $this->queryBuilder->buildQuery(compact('fields'));
        $response = $this->client->getBaseClient()->get('/assets/' . strtolower($assetKey) . $query);

        return $this->transformer->transform($response);
    }

    /**
     * Get all of our qualitative information for an asset.
     *
     * @param string $assetKey This "key" can be the asset's ID (unique), slug (unique), or symbol (non-unique)
     * @param string|null $fields pare down the returned fields (comma , separated, drill down with a slash /)
     * @return array
     * @throws Exception
     */
    public function getProfile(string $assetKey, ?string $fields = null): array
    {
        $query = $this->queryBuilder->buildQuery(compact('fields'));
        $response = $this->client->getBaseClient()->get('/assets/' . strtolower($assetKey) . '/profile' . $query);

        return $this->transformer->transform($response);
    }

    /**
     * Get all of our quantitative metrics for an asset.
     *
     * @param string $assetKey This "key" can be the asset's ID (unique), slug (unique), or symbol (non-unique)
     * @param string|null $fields pare down the returned fields (comma , separated, drill down with a slash /)
     * @return array
     * @throws Exception
     */
    public function getMetrics(string $assetKey, ?string $fields = null): array
    {
        $query = $this->queryBuilder->buildQuery(compact('fields'));
        $response = $this->client->getBaseClient()->get('/assets/' . strtolower($assetKey) . '/metrics' . $query);

        return $this->transformer->transform($response);
    }

    /**
     * Get the latest market data for an asset. This data is also included in the metrics endpoint, but if all you need
     *  is market-data, use this.
     *
     * @param string $assetKey This "key" can be the asset's ID (unique), slug (unique), or symbol (non-unique)
     * @param string|null $fields pare down the returned fields (comma , separated, drill down with a slash /)
     * @return array
     * @throws Exception
     */
    public function getMarketData(string $assetKey, ?string $fields = null): array
    {
        $query = $this->queryBuilder->buildQuery(compact('fields'));
        $response = $this->client->getBaseClient()->get('/assets/' . strtolower($assetKey) . '/metrics'
            . '/market-data' . $query);

        return $this->transformer->transform($response);
    }

    /**
     * Retrieve historical timeseries data for an asset.
     *
     * @param string $assetKey This "key" can be the asset's ID (unique), slug (unique), or symbol (non-unique)
     * @param string $metricId The metricID is a unique identifier which describes the type of data returned by
     *  time-series endpoints.
     * @param array $params
     * @return array
     * @throws Exception
     */
    public function getTimeseries(string $assetKey, string $metricId, array $params = []): array
    {
        return $this->timeseries('assets', $assetKey, $metricId, $params);
    }
}
