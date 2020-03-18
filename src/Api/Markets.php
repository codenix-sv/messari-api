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
     * Get the list of all exchanges and pairs that WebSocket-based market real-time market data API supports.
     *
     * @param array $params
     * @return array
     * @throws Exception
     */
    public function getAll($params = []): array
    {
        return $this->all('markets', $params);
    }

    /**
     * Retrieve historical timeseries data for a market.
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
        return $this->timeseries('markets', $assetKey, $metricId, $params);
    }
}
