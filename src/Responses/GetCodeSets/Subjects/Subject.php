<?php

namespace SeanJA\StatsCanAPI\Responses\GetCodeSets\Subjects;

use SeanJA\StatsCanAPI\Interfaces\Deserializable;

class Subject implements Deserializable
{
    public function __construct(
        public readonly int $subjectCode,
        public readonly string $subjectEn,
        public readonly string $subjectFr
    ){}

    #[\Override] public static function deserialize(array $data): static
    {
        return new static(...$data);
    }
}