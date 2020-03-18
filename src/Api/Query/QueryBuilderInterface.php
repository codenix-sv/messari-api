<?php

declare(strict_types=1);

namespace Codenixsv\MessariApi\Api\Query;

/**
 * Interface QueryBuilderInterface
 * @package Codenixsv\MessariApi\Api\Query
 */
interface QueryBuilderInterface
{
    /**
     * @param array $params
     * @return string
     */
    public function buildQuery(array $params): string;
}
