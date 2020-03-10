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
     * @param bool $withMetrics existence of this query param filters assets to those with quantitative data
     * @param bool $withProfiles existence of this query param filters assets to those with qualitative data
     * @param string|null $fields pare down the returned fields (comma , separated, drill down with a slash /)
     * @param string|null $sort default sort is "marketcap desc", but the only valid value for this query
     *  param is "id" which translates to "id asc", which is useful for a stable sort while paginating
     * @param int|null $page Page number, starts at 1. Increment to paginate through
     *  results (until result is empty array)
     * @param int|null $limit default is 20, max is 500
     * @return array
     * @throws Exception
     */
    public function getAll(
        bool $withMetrics = false,
        bool $withProfiles = false,
        ?string $fields = null,
        ?string $sort = null,
        ?int  $page = null,
        ?int $limit = null
    ): array {
        $query = $this->buildQueryGetAll($withMetrics, $withProfiles, $fields, $sort, $page, $limit);
        $endpoint = empty($query) ? '/assets' : '/assets?' . $query;
        $response = $this->client->getBaseClient()->get($endpoint);

        return $this->transformer->transform($response);
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
        $query = is_null($fields) ? '' : '?' . http_build_query(compact($fields));
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
        $query = is_null($fields) ? '' : '?' . http_build_query(compact($fields));
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
        $query = is_null($fields) ? '' : '?' . http_build_query(compact($fields));
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
        $query = is_null($fields) ? '' : '?' . http_build_query(compact($fields));
        $response = $this->client->getBaseClient()->get('/assets/' . strtolower($assetKey) . '/metrics'
            . '/market-data' . $query);

        return $this->transformer->transform($response);
    }

    /**
     * Retrieve historical timeseries data for an asset.
     *
     * @param string $assetKey This "key" can be the asset's ID (unique), slug (unique), or symbol (non-unique)
     * @param string $metricID The metricID is a unique identifier which describes the type of data returned by
     *  time-series endpoints.
     * @param string|null $start The "start" query parameter can be used to set the start date after which points
     *  are returned.
     * @param string|null $end The "end" query parameter can be used to set the end date after which no more points
     *  will be returned.
     * @param string|null $interval Defines what interval the resulting points will be returned in.
     * @param string|null $columns A comma separated list of strings that controls which columns will be returned and
     *  in what order.
     * @param string|null $order Order controls whether points in the response are returned in ascending or
     *  descending order.
     * @param string|null $format Specify format = csv to download data as CSV.
     * @return array
     * @throws Exception
     */
    public function getTimeseries(
        string $assetKey,
        string $metricID,
        ?string $start = null,
        ?string $end = null,
        ?string $interval = null,
        ?string $columns = null,
        ?string $order = null,
        ?string $format = null
    ): array {
        $query = $this->buildQueryGetTimeseries($start, $end, $interval, $columns, $order, $format);
        $query = empty($query) ? $query : ('?' . $query);
        $response = $this->client->getBaseClient()->get('/assets/' . strtolower($assetKey) . '/metrics/'
        . $metricID . '/time-series' . $query);

        return $this->transformer->transform($response);
    }

    /**
     * @param bool $withMetrics
     * @param bool $withProfiles
     * @param string|null $fields
     * @param string|null $sort
     * @param int|null $page
     * @param int|null $limit
     * @return string
     */
    private function buildQueryGetAll(
        bool $withMetrics = false,
        bool $withProfiles = false,
        ?string $fields = null,
        ?string $sort = null,
        ?int  $page = null,
        ?int $limit = null
    ): string {
        $data = compact('fields', 'sort', 'page', 'limit');
        if (true === $withMetrics) {
            $data['with-metrics'] = '';
        }
        if (true === $withProfiles) {
            $data['with-profiles'] = '';
        }

        $params = array_filter($data, function ($value) {
            return !is_null($value);
        });

        return http_build_query($params);
    }

    /**
     * @param string|null $start
     * @param string|null $end
     * @param string|null $interval
     * @param string|null $columns
     * @param string|null $order
     * @param string|null $format
     * @return string
     */
    private function buildQueryGetTimeseries(
        ?string $start = null,
        ?string $end = null,
        ?string $interval = null,
        ?string $columns = null,
        ?string $order = null,
        ?string $format = null
    ): string {
        $data = compact('start', 'end', 'interval', 'columns', 'order', 'format');

        $params = array_filter($data, function ($value) {
            return !is_null($value);
        });

        return http_build_query($params);
    }
}
