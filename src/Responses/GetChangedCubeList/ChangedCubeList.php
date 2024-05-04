<?php

namespace SeanJA\StatsCanAPI\Responses\GetChangedCubeList;

use Ramsey\Collection\AbstractCollection;
use SeanJA\StatsCanAPI\Responses\ResponseInterface;

class ChangedCubeList extends AbstractCollection implements ResponseInterface
{
    public function getType(): string
    {
        return ChangedCube::class;
    }

    public static function fromResponse(array $response): static
    {
        return new static(
            array_map(
                function ($data) {
                    return ChangedCube::deserialize($data);
                }, $response['object']
            )
        );
    }
}