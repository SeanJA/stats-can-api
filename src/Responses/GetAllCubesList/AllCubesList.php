<?php

namespace SeanJA\StatsCanAPI\Responses\GetAllCubesList;

use Ramsey\Collection\AbstractCollection;
use SeanJA\StatsCanAPI\Responses\ResponseInterface;

class AllCubesList extends AbstractCollection implements ResponseInterface
{
    public function getType(): string
    {
        return Cube::class;
    }

    #[\Override] public static function fromResponse(array $response): static
    {
        return new self(
            array_map(function ($data) {
                return Cube::deserialize($data);
            }, $response)
        );
    }


}