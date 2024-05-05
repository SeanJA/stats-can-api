<?php

namespace SeanJA\StatsCanAPI\Responses\GetCodeSets\Terminateds;

use SeanJA\StatsCanAPI\Interfaces\Deserializable;

class Terminated implements Deserializable
{
    public function __construct(
        public readonly int $codeId,
        public readonly string $codeTextEn,
        public readonly string $codeTextFr,
        public readonly string|null $displayCodeEn,
        public readonly string|null $displayCodeFr,

    ){}

    #[\Override] public static function deserialize(array $data): static
    {
        return new static(...$data);
    }
}