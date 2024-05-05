<?php

namespace SeanJA\StatsCanAPI\Responses\GetCodeSets\Surveys;

use SeanJA\StatsCanAPI\Interfaces\Deserializable;

class Survey implements Deserializable
{
    public function __construct(
        public readonly int $surveyCode,
        public readonly string $surveyEn,
        public readonly string $surveyFr
    ){}

    #[\Override] public static function deserialize(array $data): static
    {
        return new static(...$data);
    }
}