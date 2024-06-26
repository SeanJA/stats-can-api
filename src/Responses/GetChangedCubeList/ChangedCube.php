<?php

namespace SeanJA\StatsCanAPI\Responses\GetChangedCubeList;

use SeanJA\StatsCanAPI\ValueObjects\ProductId;

class ChangedCube
{
    public function __construct(
        public readonly int                $responseStatusCode,
        public readonly ProductId          $productId,
        public readonly \DateTimeImmutable $releaseTime,
    )
    {
    }

    /**
     * @param array $data
     * @return self
     * @throws \Exception
     */
    public static function deserialize(array $data)
    {
        return new self(
            $data['responseStatusCode'],
            new ProductId($data['productId']),
            new \DateTimeImmutable($data['releaseTime'])
        );
    }
}