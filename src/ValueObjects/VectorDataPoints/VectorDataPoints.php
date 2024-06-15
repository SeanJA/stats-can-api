<?php

namespace SeanJA\StatsCanAPI\ValueObjects\VectorDataPoints;

use Ramsey\Collection\AbstractCollection;
use SeanJA\StatsCanAPI\Interfaces\Deserializable;

class VectorDataPoints extends AbstractCollection implements Deserializable
{
    public static function deserialize(array $data): static
    {
        return new static(array_map(function ($data) {
            return VectorDatapoint::deserialize($data);
        }, $data));
    }

    #[\Override] public function getType(): string
    {
        return VectorDatapoint::class;
    }
}