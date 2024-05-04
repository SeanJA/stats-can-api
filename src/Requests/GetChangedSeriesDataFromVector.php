<?php

namespace SeanJA\StatsCanAPI\Requests;

use GuzzleHttp\Psr7\Request;

class GetChangedSeriesDataFromVector implements StatsCanAPIRequestInterface
{
    public function __construct(
        private readonly int $vectorId
    )
    {
    }

    public function __invoke(): Request
    {
        return new Request(
            method: 'POST',
            uri: 'https://www150.statcan.gc.ca/t1/wds/rest/getChangedSeriesDataFromVector',
            headers: [
                'Content-Type' => 'application/json'
            ],
            body: json_encode([[
                'vectorId' => $this->vectorId
            ]]),
        );
    }
}