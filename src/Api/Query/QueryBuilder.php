<?php

declare(strict_types=1);

namespace Codenixsv\MessariApi\Api\Query;

/**
 * Class QueryBuilder
 * @package Codenixsv\MessariApi\Api\Query
 */
class QueryBuilder implements QueryBuilderInterface
{
    /**
     * @param array $params
     * @return string
     */
    public function buildQuery(array $params): string
    {
        $params = array_filter($params, function ($value) {
            return !is_null($value);
        });

        $query = http_build_query($params);

        return empty($query) ? '' : '?' . $query;
    }
}
