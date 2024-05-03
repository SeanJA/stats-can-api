<?php

namespace SeanJA\StatsCanAPI\Responses\GetCubeMetadata;

use SeanJA\StatsCanAPI\Responses\Deserializable;
use SeanJA\StatsCanAPI\Responses\ResponseInterface;

class CubeMetadata implements Deserializable, ResponseInterface
{
    #[\Override] public static function deserialize(array $data): self
    {
        var_dump($data);
        die();
    }

    #[\Override] public static function fromResponse(array $response): self
    {
        var_dump($response);
        die();
    }
}