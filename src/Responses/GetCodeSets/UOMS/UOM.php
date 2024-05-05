<?php

namespace SeanJA\StatsCanAPI\Responses\GetCodeSets\UOMS;

use SeanJA\StatsCanAPI\Interfaces\Deserializable;

class UOM implements Deserializable
{
    public function __construct(
        public readonly int $memberUomCode,
        public readonly string|null $memberUomEn,
        public readonly string|null $memberUomFr
    ){}

    #[\Override] public static function deserialize(array $data): static
    {
        return new static(...$data);
    }
}