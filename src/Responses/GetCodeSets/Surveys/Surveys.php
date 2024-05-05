<?php

namespace SeanJA\StatsCanAPI\Responses\GetCodeSets\Surveys;

use Ramsey\Collection\AbstractCollection;
use SeanJA\StatsCanAPI\Interfaces\Deserializable;

class Surveys extends AbstractCollection implements Deserializable
{
    public static function deserialize(array $data): static
    {
        return new static(array_map(function ($data) {
            return Survey::deserialize($data);
        }, $data));
    }

    #[\Override] public function getType(): string
    {
        return Survey::class;
    }
}