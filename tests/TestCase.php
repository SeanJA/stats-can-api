<?php

namespace Tests\SeanJA\StatsCanAPI;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

class TestCase extends PHPUnitTestCase
{
    /**
     * @param string $body
     * @param int $statusCode
     * @return GuzzleClient
     */
    public function mockGuzzleClient(string $body, int $statusCode = 200): GuzzleClient
    {
       $mock = MockHandler::createWithMiddleware([
            new Response($statusCode, [], $body)
        ]);

        $handlerStack = HandlerStack::create($mock);

        return new GuzzleClient([
            'handler' => $handlerStack
        ]);
    }
}