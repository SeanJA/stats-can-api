<?php

namespace SeanJA\StatsCanAPI\Responses\GetCodeSets\Statuses;

use SeanJA\StatsCanAPI\Interfaces\Deserializable;

class Status implements Deserializable
{
    public function __construct(
        public readonly int         $statusCode,
        public readonly string|null $statusRepresentationEn,
        public readonly string|null $statusRepresentationFr,
        public readonly string      $statusDescEn,
        public readonly string      $statusDescFr
    )
    {
    }

    #[\Override] public static function deserialize(array $data): static
    {
        return new static(...$data);
    }
}