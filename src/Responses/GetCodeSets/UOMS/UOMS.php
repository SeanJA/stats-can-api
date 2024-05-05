<?php

namespace SeanJA\StatsCanAPI\Responses\GetCodeSets\UOMS;

use Ramsey\Collection\AbstractCollection;
use SeanJA\StatsCanAPI\Interfaces\Deserializable;

class UOMS extends AbstractCollection implements Deserializable
{
    public static function deserialize(array $data): static
    {
        return new static(array_map(function ($data) {
            return UOM::deserialize($data);
        }, $data));
    }

    #[\Override] public function getType(): string
    {
        return UOM::class;
    }
}