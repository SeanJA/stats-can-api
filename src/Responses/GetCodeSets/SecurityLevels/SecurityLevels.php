<?php

namespace SeanJA\StatsCanAPI\Responses\GetCodeSets\SecurityLevels;

use Ramsey\Collection\AbstractCollection;
use SeanJA\StatsCanAPI\Interfaces\Deserializable;

class SecurityLevels extends AbstractCollection implements Deserializable
{
    public static function deserialize(array $data): static
    {
        return new static(array_map(function ($data) {
            return SecurityLevel::deserialize($data);
        }, $data));
    }

    #[\Override] public function getType(): string
    {
        return SecurityLevel::class;
    }
}