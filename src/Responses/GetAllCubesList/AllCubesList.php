<?php

namespace SeanJA\StatsCanAPI\Responses\GetAllCubesList;

use Ramsey\Collection\AbstractCollection;

class AllCubesList extends AbstractCollection
{
    public function getType(): string
    {
        return Cube::class;
    }
}