<?php

namespace SeanJA\StatsCanAPI\Responses\GetCodeSets\Scalars;

use SeanJA\StatsCanAPI\Interfaces\Deserializable;

class Scalar implements Deserializable
{
    public function __construct(
        public readonly int    $scalarFactorCode,
        public readonly string $scalarFactorDescEn,
        public readonly string $scalarFactorDescFr,
    )
    {
    }

    #[\Override] public static function deserialize(array $data): static
    {
        return new static(...$data);
    }
}