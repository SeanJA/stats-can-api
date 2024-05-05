<?php

namespace SeanJA\StatsCanAPI\Responses\GetCodeSets\ClassificationTypes;

use Ramsey\Collection\AbstractCollection;
use SeanJA\StatsCanAPI\Interfaces\Deserializable;

class ClassificationTypes extends AbstractCollection implements Deserializable
{
    public static function deserialize(array $data): static
    {
        return new static(array_map(function ($data) {
            return ClassificationType::deserialize($data);
        }, $data));
    }

    #[\Override] public function getType(): string
    {
        return ClassificationType::class;
    }
}