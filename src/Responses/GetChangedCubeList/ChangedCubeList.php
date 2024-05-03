<?php

namespace SeanJA\StatsCanApi\Responses\GetChangedCubeList;

use Ramsey\Collection\AbstractCollection;

class ChangedCubeList extends AbstractCollection
{
    public function getType(): string
    {
        return ChangedCube::class;
    }
}