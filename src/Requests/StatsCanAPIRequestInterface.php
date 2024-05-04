<?php

namespace SeanJA\StatsCanAPI\Requests;

use GuzzleHttp\Psr7\Request;

interface StatsCanAPIRequestInterface
{
    public function __invoke(): Request;
}