<?php

namespace SeanJA\StatsCanAPI\Responses;

use SeanJA\StatsCanAPI\Interfaces\Deserializable;

class DownloadableFile implements ResponseInterface, Deserializable
{
    public function __construct(
        public readonly string $uri
    )
    {

    }

    #[\Override] public static function fromResponse(array $response): static
    {
        return static::deserialize([
            'uri' => $response['object']
        ]);
    }

    #[\Override] public static function deserialize(array $data): static
    {
        return new static(...$data);
    }
}