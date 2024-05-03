<?php

namespace SeanJA\StatsCanApi\ValueObjects;

class Dimension
{

    public function __construct(
        public readonly string $dimensionNameEn,
        public readonly string $dimensionNameFr,
        public readonly int    $dimensionPositionId,
        public readonly bool   $hasUOM
    )
    {
    }

    public static function deserialize(array $data): self
    {
        return new self(
            $data['dimensionNameEn'],
            $data['dimensionNameFr'],
            $data['dimensionPositionId'],
            $data['hasUOM'],
        );
    }
}