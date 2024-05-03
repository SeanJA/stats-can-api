<?php

namespace SeanJA\StatsCanAPI\ValueObjects\Dimensions;

use Ramsey\Collection\AbstractCollection;

class Dimensions extends AbstractCollection
{
    #[\Override] public function getType(): string
    {
        return Dimension::class;
    }
}