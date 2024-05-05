<?php

namespace SeanJA\StatsCanAPI\Responses\GetCodeSets\Scalars;

use Ramsey\Collection\AbstractCollection;
use SeanJA\StatsCanAPI\Interfaces\Deserializable;

class Scalars extends AbstractCollection implements Deserializable
{
    public static function deserialize(array $data): static
    {
        return new static(array_map(function ($data) {
            return Scalar::deserialize($data);
        }, $data));
    }

    #[\Override] public function getType(): string
    {
        return Scalar::class;
    }
}