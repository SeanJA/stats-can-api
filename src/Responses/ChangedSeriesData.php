<?php

namespace SeanJA\StatsCanAPI\Responses;

use SeanJA\StatsCanAPI\Interfaces\Deserializable;
use SeanJA\StatsCanAPI\ValueObjects\ProductId;
use SeanJA\StatsCanAPI\ValueObjects\VectorDataPoints\VectorDataPoints;

abstract class ChangedSeriesData implements Deserializable, ResponseInterface
{
    public function __construct(
        public readonly int $responseStatusCode,
        public readonly ProductId $productId,
        public readonly string $coordinate,
        public readonly int $vectorId,
        public VectorDataPoints $vectorDataPoint
    ){

    }

    #[\Override] public static function deserialize(array $data): static
    {
        $data['productId'] = new ProductId($data['productId']);
        $data['vectorDataPoint'] = VectorDataPoints::deserialize($data['vectorDataPoint']);

        return new static(...$data);
    }

    #[\Override] public static function fromResponse(array $response): static
    {
        return static::deserialize($response[0]['object']);
    }
}