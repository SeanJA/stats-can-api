<?php

namespace SeanJA\StatsCanAPI\Responses\GetCodeSets\Symbols;

use SeanJA\StatsCanAPI\Interfaces\Deserializable;

class Symbol implements Deserializable
{
    public function __construct(
        public readonly int $symbolCode,
        public readonly string|null $symbolRepresentationEn,
        public readonly string|null $symbolRepresentationFr,
        public readonly string $symbolDescEn,
        public readonly string $symbolDescFr
    ){}

    #[\Override] public static function deserialize(array $data): static
    {
        return new static(...$data);
    }
}