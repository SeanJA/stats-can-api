<?php

namespace SeanJA\StatsCanAPI\Requests;

use GuzzleHttp\Psr7\Request;

class GetFullTableDownloadCSV implements StatsCanAPIRequestInterface
{
    public function __construct(
        private readonly int $productId
    )
    {
    }

    public function __invoke(): Request
    {
        return new Request(
            'GET',
            'https://www150.statcan.gc.ca/t1/wds/rest/getFullTableDownloadCSV/' . $this->productId . '/en'
        );
    }
}