<?php

namespace SeanJA\StatsCanAPI\ValueObjects\Dimensions;

use SeanJA\StatsCanAPI\Responses\Deserializable;

class Member implements Deserializable
{
    public function __construct(
        public readonly int         $memberId,
        public readonly int|null    $parentMemberId,
        public readonly string      $memberNameEn,
        public readonly string      $memberNameFr,
        public readonly string|null $classificationCode,
        public readonly string|null $classificationTypeCode,
        public readonly string|null $geoLevel,
        public readonly string|null $vintage,
        public readonly int         $terminated,
        public readonly int|null    $memberUomCode,
    )
    {
    }

    #[\Override] public static function deserialize(array $data): self
    {
        return new self(...$data);
    }
}