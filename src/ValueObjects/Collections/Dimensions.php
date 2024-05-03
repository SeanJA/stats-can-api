<?php

namespace SeanJA\StatsCanApi\ValueObjects\Collections;

use Ramsey\Collection\AbstractCollection;
use SeanJA\StatsCanApi\ValueObjects\Dimension;

class Dimensions extends AbstractCollection
{
    #[\Override] public function getType(): string
    {
        return Dimension::class;
    }
}