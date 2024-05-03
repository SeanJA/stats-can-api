<?php

namespace SeanJA\StatsCanAPI\Requests;

use DateTimeInterface;
use GuzzleHttp\Psr7\Request;

class GetChangedCubeList implements RequestInterface
{
    public function __construct(
        private readonly DateTimeInterface $date
    )
    {
    }

    public function __invoke(): Request
    {
        return new Request(
            method: 'GET',
            uri: 'https://www150.statcan.gc.ca/t1/wds/rest/getChangedCubeList/' . $this->date->format('Y-m-d')
        );
    }
}