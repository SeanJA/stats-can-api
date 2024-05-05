<?php

namespace SeanJA\StatsCanAPI\Responses\GetCodeSets\Symbols;

use Ramsey\Collection\AbstractCollection;
use SeanJA\StatsCanAPI\Interfaces\Deserializable;

class Symbols extends AbstractCollection implements Deserializable
{
    public static function deserialize(array $data): static
    {
        return new static(array_map(function ($data) {
            return Symbol::deserialize($data);
        }, $data));
    }

    #[\Override] public function getType(): string
    {
        return Symbol::class;
    }
}