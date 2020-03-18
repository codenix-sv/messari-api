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
     * @param int|null $page Page number, starts at 1. Increment to paginate through results (until
     *  result is empty array)
     * @param string|null $fields pare down the returned fields (comma , separated, drill down with a slash /)
     * @return array
     * @throws Exception
     */
    public function getAll(?int $page = null, ?string $fields = null): array
    {
        $query = $this->queryBuilder->buildQuery(compact('fields', 'page'));
        $response = $this->client->getBaseClient()->get('/news' . $query);

        return $this->transformer->transform($response);
    }


    /**
     * @param string $assetKey This "key" can be the asset's ID (unique), slug (unique), or symbol (non-unique)
     * @param string|null $fields pare down the returned fields (comma , separated, drill down with a slash /)
     * @param bool|null $asMarkdown formatting (other than HTML links) is hidden. Use this query param to return
     *  content with markdown syntax
     * @return array
     * @throws Exception
     */
    public function getForAsset(string $assetKey, ?string $fields = null, ?bool $asMarkdown = null): array
    {
        $params = [];

        if (!is_null($fields)) {
            $params['fields'] = $fields;
        }
        if (!is_null($asMarkdown)) {
            $params['as_markdown'] = $asMarkdown;
        }

        $query = $this->queryBuilder->buildQuery($params);
        $response = $this->client->getBaseClient()->get('/news/' . strtolower($assetKey) . $query);

        return $this->transformer->transform($response);
    }
}
