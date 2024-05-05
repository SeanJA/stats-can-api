<?php

namespace SeanJA\StatsCanAPI\Responses\GetCodeSets\WDSResponseStatuses;

use SeanJA\StatsCanAPI\Interfaces\Deserializable;

class WDSResponseStatus implements Deserializable
{
    public function __construct(
        public readonly int $codeId,
        public readonly string $codeTextEn,
        public readonly string $codeTextFr
    ){}

    #[\Override] public static function deserialize(array $data): static
    {
        return new static(...$data);
    }
}