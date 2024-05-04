<?php

namespace SeanJA\StatsCanAPI\Responses;

interface ResponseInterface
{
    public static function fromResponse(array $response): static;
}