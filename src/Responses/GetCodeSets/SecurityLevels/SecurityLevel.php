<?php

namespace SeanJA\StatsCanAPI\Responses\GetCodeSets\SecurityLevels;

use SeanJA\StatsCanAPI\Interfaces\Deserializable;

class SecurityLevel implements Deserializable
{
    public function __construct(
        public readonly int         $securityLevelCode,
        public readonly string|null $securityLevelRepresentationEn,
        public readonly string|null $securityLevelRepresentationFr,
        public readonly string      $securityLevelDescEn,
        public readonly string      $securityLevelDescFr,

    )
    {
    }

    #[\Override] public static function deserialize(array $data): static
    {
        return new static(...$data);
    }
}