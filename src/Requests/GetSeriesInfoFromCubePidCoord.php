<?php

namespace SeanJA\StatsCanAPI\Requests;

use GuzzleHttp\Psr7\Request;

class GetSeriesInfoFromCubePidCoord implements StatsCanAPIRequestInterface
{
    public function __construct(
        private readonly int $productId,
        private readonly string $coordinate
    ){

    }

    public function __invoke(): Request
    {
        return new Request(
            method: 'POST',
            uri: 'https://www150.statcan.gc.ca/t1/wds/rest/getSeriesInfoFromCubePidCoord',
            headers: [
                'Content-Type' => 'application/json'
            ],
            body: json_encode([[
                'productId' => $this->productId,
                'coordinate' => $this->coordinate
            ]]),
        );
    }
}