<?php

namespace SeanJA\StatsCanAPI\Responses\GetCodeSets\WDSResponseStatuses;

use Ramsey\Collection\AbstractCollection;
use SeanJA\StatsCanAPI\Interfaces\Deserializable;

class WDSResponseStatuses extends AbstractCollection implements Deserializable
{
    public static function deserialize(array $data): static
    {
        return new static(array_map(function ($data) {
            return WDSResponseStatus::deserialize($data);
        }, $data));
    }

    #[\Override] public function getType(): string
    {
        return WDSResponseStatus::class;
    }
}