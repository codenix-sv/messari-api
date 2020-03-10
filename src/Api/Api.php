<?php

declare(strict_types=1);

namespace Codenixsv\MessariApi\Api;

use Codenixsv\MessariApi\Message\ResponseTransformer;
use Codenixsv\MessariApi\MessariClient;

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

    /**
     * Api constructor.
     * @param $client
     */
    public function __construct(MessariClient $client)
    {
        $this->client = $client;
        $this->transformer = new ResponseTransformer();
    }

    /**
     * @return MessariClient
     */
    public function getClient(): MessariClient
    {
        return $this->client;
    }
}
