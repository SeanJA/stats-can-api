<?php

namespace SeanJA\StatsCanAPI\Requests;

use GuzzleHttp\Psr7\Request;

interface RequestInterface
{
    public function __invoke(): Request;
}