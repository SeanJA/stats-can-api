<?php

namespace SeanJA\StatsCanAPI\Requests;

use GuzzleHttp\Psr7\Request;

class GetDataFromVectorsAndLatestNPeriods implements StatsCanAPIRequestInterface
{
    public function __construct(
        private readonly int $vectorId,
        private readonly int $latestN
    )
    {

    }

    public function __invoke(): Request
    {
        return new Request(
            method: 'POST',
            uri: 'https://www150.statcan.gc.ca/t1/wds/rest/getDataFromVectorsAndLatestNPeriods',
            headers: [
                'Content-Type' => 'application/json'
            ],
            body: json_encode([[
                'vectorId' => $this->vectorId,
                'latestN' => $this->latestN
            ]]),
        );
    }
}