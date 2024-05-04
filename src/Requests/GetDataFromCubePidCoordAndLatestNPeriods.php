<?php

namespace SeanJA\StatsCanAPI\Requests;

use GuzzleHttp\Psr7\Request;

class GetDataFromCubePidCoordAndLatestNPeriods implements StatsCanAPIRequestInterface
{
    public function __construct(
        private readonly int $productId,
        private readonly string $coordinate,
        private readonly int $latestN
    ){

    }

    public function __invoke(): Request
    {
        return new Request(
            method: 'POST',
            uri: 'https://www150.statcan.gc.ca/t1/wds/rest/getDataFromCubePidCoordAndLatestNPeriods',
            headers: [
                'Content-Type' => 'application/json'
            ],
            body: json_encode([[
                'productId' => $this->productId,
                'coordinate' => $this->coordinate,
                'latestN' => $this->latestN
            ]]),
        );
    }
}