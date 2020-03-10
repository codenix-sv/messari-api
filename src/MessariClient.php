<?php

declare(strict_types=1);

namespace Codenixsv\MessariApi;

use Codenixsv\ApiClient\BaseClient;
use Codenixsv\ApiClient\BaseClientInterface;
use Codenixsv\MessariApi\Api\Assets;
use Codenixsv\MessariApi\Api\Markets;
use Codenixsv\MessariApi\Api\News;

/**
 * Class MessariClient
 * @package Codenixsv\MessariApi
 */
class MessariClient
{
    const BASE_URI = 'https://data.messari.io/api/v1';

    /** @var BaseClientInterface */
    private $baseClient;

    /**
     * MessariClient constructor.
     * @param BaseClientInterface|null $baseClient
     */
    public function __construct(?BaseClientInterface $baseClient = null)
    {
        $this->baseClient = $baseClient ?: new BaseClient();
        $this->baseClient->setBaseUri($this->getBaseUri());
    }

    /**
     * @return BaseClientInterface
     */
    public function getBaseClient(): BaseClientInterface
    {
        return $this->baseClient;
    }

    /**
     * @return Assets
     */
    public function assets(): Assets
    {
        return new Assets($this);
    }

    /**
     * @return Markets
     */
    public function markets(): Markets
    {
        return new Markets($this);
    }

    /**
     * @return News
     */
    public function news(): News
    {
        return new News($this);
    }

    /**
     * @return string
     */
    private function getBaseUri(): string
    {
        return self::BASE_URI;
    }
}
