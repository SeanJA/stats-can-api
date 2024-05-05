<?php

namespace SeanJA\StatsCanAPI\Responses\GetCodeSets\Terminateds;

use Ramsey\Collection\AbstractCollection;
use SeanJA\StatsCanAPI\Interfaces\Deserializable;

class Terminateds extends AbstractCollection implements Deserializable
{
    public static function deserialize(array $data): static
    {
        return new static(array_map(function ($data) {
            return Terminated::deserialize($data);
        }, $data));
    }

    #[\Override] public function getType(): string
    {
        return Terminated::class;
    }
}