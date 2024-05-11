<?php

namespace SeanJA\StatsCanAPI\Responses;

use SeanJA\StatsCanAPI\Interfaces\Deserializable;
use SeanJA\StatsCanAPI\ValueObjects\Coordinate;
use SeanJA\StatsCanAPI\ValueObjects\ProductId;
use SeanJA\StatsCanAPI\ValueObjects\VectorDataPoints\VectorDataPoints;

abstract class SeriesData implements Deserializable, ResponseInterface
{
    public function __construct(
        public readonly int $responseStatusCode,
        public readonly ProductId $productId,
        public readonly Coordinate $coordinate,
        public readonly int $vectorId,
        public VectorDataPoints $vectorDataPoints
    ){

    }

    #[\Override] public static function deserialize(array $data): static
    {
        $data['productId'] = new ProductId($data['productId']);
        $data['coordinate'] = Coordinate::deserialize($data['coordinate']);
        $data['vectorDataPoints'] = VectorDataPoints::deserialize($data['vectorDataPoints']);
        return new static(...$data);
    }

    #[\Override] public static function fromResponse(array $response): static
    {
        $response[0]['object']['vectorDataPoints'] = $response[0]['object']['vectorDataPoint'];
        unset($response[0]['object']['vectorDataPoint']);
        return static::deserialize($response[0]['object']);
    }
}