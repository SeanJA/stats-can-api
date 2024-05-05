<?php

namespace SeanJA\StatsCanAPI\Responses\GetCodeSets\Frequencies;

use Ramsey\Collection\AbstractCollection;
use SeanJA\StatsCanAPI\Interfaces\Deserializable;

class Frequencies extends AbstractCollection implements Deserializable
{
    public static function deserialize(array $data): static
    {
        return new static(array_map(function ($data) {
            return Frequency::deserialize($data);
        }, $data));
    }

    #[\Override] public function getType(): string
    {
        return Frequency::class;
    }
}