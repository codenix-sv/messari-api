<?php

declare(strict_types=1);

namespace Codenixsv\MessariApi\Tests\Message;

use Codenixsv\MessariApi\Exception\TransformResponseException;
use Codenixsv\MessariApi\Message\ResponseTransformer;
use Nyholm\Psr7\Response;
use PHPUnit\Framework\TestCase;

class ResponseTransformerTest extends TestCase
{
    public function testTransform()
    {
        $transformer = new ResponseTransformer();
        $data = ['foo' => 'bar'];
        $response = new Response(200, ['Content-Type' => 'application/json'], json_encode($data));

        $this->assertEquals($data, $transformer->transform($response));
    }

    public function testTransformWithEmptyBody()
    {
        $transformer = new ResponseTransformer();
        $data = [];
        $response = new Response(200, ['Content-Type' => 'application/json'], json_encode($data));

        $this->assertEquals($data, $transformer->transform($response));
    }

    public function testTransformThrowTransformResponseException()
    {
        $transformer = new ResponseTransformer();
        $response = new Response(200, ['Content-Type' => 'application/json'], '');

        $this->expectException(TransformResponseException::class);

        $transformer->transform($response);
    }

    public function testTransformWithIncorrectContentType()
    {
        $transformer = new ResponseTransformer();
        $data = [];
        $response = new Response(200, ['Content-Type' => 'application/javascript'], json_encode($data));

        $this->expectException(TransformResponseException::class);

        $this->assertEquals($data, $transformer->transform($response));
    }
}
