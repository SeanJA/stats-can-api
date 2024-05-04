<?php

namespace SeanJA\StatsCanAPI\Requests;

use GuzzleHttp\Psr7\Request;

class GetAllCubesListLite implements StatsCanAPIRequestInterface
{

    public function __invoke(): Request
    {
        return new Request(
            'GET',
            'https://www150.statcan.gc.ca/t1/wds/rest/getAllCubesListLite'
        );
    }
}