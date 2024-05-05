<?php

namespace SeanJA\StatsCanAPI\Responses\GetCodeSets\Statuses;

use Ramsey\Collection\AbstractCollection;
use SeanJA\StatsCanAPI\Interfaces\Deserializable;

class Statuses extends AbstractCollection implements Deserializable
{
    public static function deserialize(array $data): static
    {
        return new static(array_map(function ($data) {
            return Status::deserialize($data);
        }, $data));
    }

    #[\Override] public function getType(): string
    {
        return Status::class;
    }
}