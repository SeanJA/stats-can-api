<?php

namespace SeanJA\StatsCanAPI\Responses\GetCodeSets\Subjects;

use Ramsey\Collection\AbstractCollection;
use SeanJA\StatsCanAPI\Interfaces\Deserializable;

class Subjects extends AbstractCollection implements Deserializable
{
    public static function deserialize(array $data): static
    {
        return new static(array_map(function ($data) {
            return Subject::deserialize($data);
        }, $data));
    }

    #[\Override] public function getType(): string
    {
        return Subject::class;
    }
}