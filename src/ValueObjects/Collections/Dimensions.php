<?php

namespace SeanJA\StatsCanAPI\ValueObjects\Collections;

use Ramsey\Collection\AbstractCollection;
use SeanJA\StatsCanAPI\ValueObjects\Dimension;

class Dimensions extends AbstractCollection
{
    #[\Override] public function getType(): string
    {
        return Dimension::class;
    }
}