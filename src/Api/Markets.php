<?php

declare(strict_types=1);

namespace Codenixsv\MessariApi\Api;

use Exception;

/**
 * Class Markets
 * @package Codenixsv\MessariApi\Api
 */
class Markets extends Api
{
    /**
     * @param int|null $page Page number, starts at 1. Increment to paginate through results (until
     *  result is empty array)
     * @param string|null $fields pare down the returned fields (comma , separated, drill down with a slash /)
     * @return array
     * @throws Exception
     */
    public function getAll(?int $page = null, ?string $fields = null): array
    {
        $query = $this->queryBuilder->buildQuery(compact('fields', 'page'));
        $response = $this->client->getBaseClient()->get('/markets' . $query);

        return $this->transformer->transform($response);
    }

    /**
     * Retrieve historical timeseries data for a market.
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
        $query = $this->queryBuilder->buildQuery(compact('start', 'end', 'interval', 'columns', 'order', 'format'));
        $response = $this->client->getBaseClient()->get('/markets/' . strtolower($assetKey) . '/metrics/'
            . $metricID . '/time-series' . $query);

        return $this->transformer->transform($response);
    }
}
