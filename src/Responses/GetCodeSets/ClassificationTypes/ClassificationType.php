<?php

namespace SeanJA\StatsCanAPI\Responses\GetCodeSets\ClassificationTypes;

use SeanJA\StatsCanAPI\Interfaces\Deserializable;

class ClassificationType implements Deserializable
{
    public function __construct(
        public readonly int    $classificationTypeCode,
        public readonly string $classificationTypeEn,
        public readonly string $classificationTypeFr
    )
    {
    }

    #[\Override] public static function deserialize(array $data): static
    {
        return new static(...$data);
    }
}