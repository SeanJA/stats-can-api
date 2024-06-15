<?php

namespace SeanJA\StatsCanAPI\Responses\GetCodeSets\Frequencies;

use SeanJA\StatsCanAPI\Interfaces\Deserializable;

class Frequency implements Deserializable
{
    public function __construct(
        public readonly int    $frequencyCode,
        public readonly string $frequencyDescEn,
        public readonly string $frequencyDescFr,
    )
    {
    }

    #[\Override] public static function deserialize(array $data): static
    {
        return new static(...$data);
    }
}