<?php

declare(strict_types=1);

namespace Codenixsv\MessariApi\Api;

use Exception;

/**
 * Class News
 * @package Codenixsv\MessariApi\Api
 */
class News extends Api
{
    /**
     * Get the latest (paginated) news and analysis for all assets.
     *
     * @param array $params
     * @return array
     * @throws Exception
     */
    public function getAll($params = []): array
    {
        return $this->all('news', $params);
    }


    /**
     * Get the latest (paginated) news and analysis for an asset.
     *
     * @param string $assetKey
     * @param array $params
     * @return array
     * @throws Exception
     */
    public function getForAsset(string $assetKey, array $params = []): array
    {
        $query = $this->queryBuilder->buildQuery($params);
        $response = $this->client->getBaseClient()->get('/news/' . strtolower($assetKey) . $query);

        return $this->transformer->transform($response);
    }
}
