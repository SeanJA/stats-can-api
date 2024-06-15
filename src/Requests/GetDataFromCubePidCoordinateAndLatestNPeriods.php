<?php

namespace SeanJA\StatsCanAPI\Requests;

use GuzzleHttp\Psr7\Request;
use SeanJA\StatsCanAPI\ValueObjects\Coordinate;

class GetDataFromCubePidCoordinateAndLatestNPeriods implements StatsCanAPIRequestInterface
{
    public function __construct(
        private readonly int        $productId,
        private readonly Coordinate $coordinate,
        private readonly int        $latestN
    )
    {

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