<?php

namespace SeanJA\StatsCanAPI\ValueObjects\Dimensions;

use Ramsey\Collection\AbstractCollection;
use SeanJA\StatsCanAPI\Interfaces\Deserializable;

class Dimensions extends AbstractCollection implements Deserializable
{
    public static function deserialize(array $data): static
    {
        return new static(array_map(function ($data) {
            return Dimension::deserialize($data);
        }, $data));
    }

    #[\Override] public function getType(): string
    {
        return Dimension::class;
    }
}