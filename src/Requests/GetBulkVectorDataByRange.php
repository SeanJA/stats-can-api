<?php

namespace SeanJA\StatsCanAPI\Requests;

use GuzzleHttp\Psr7\Request;

class GetBulkVectorDataByRange implements StatsCanAPIRequestInterface
{
    public function __construct(
        private readonly array $vectorIds,
        private \DateTimeInterface $startDataPointReleaseDate,
        private \DateTimeInterface $endDataPointReleaseDate
    )
    {
    }

    public function __invoke(): Request
    {
        return new Request(
            method: 'POST',
            uri: 'https://www150.statcan.gc.ca/t1/wds/rest/getBulkVectorDataByRange',
            headers: [
                'Content-Type' => 'application/json'
            ],
            body: json_encode([[
                'vectorIds' => $this->vectorIds,
                'startDataPointReleaseDate' => $this->startDataPointReleaseDate->format('Y-m-d\TH:i'),
                'endDataPointReleaseDate' => $this->endDataPointReleaseDate->format('Y-m-d\TH:i')
            ]]),
        );
    }
}