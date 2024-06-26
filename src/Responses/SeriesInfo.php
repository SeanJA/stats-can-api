<?php

namespace SeanJA\StatsCanAPI\Responses;

use SeanJA\StatsCanAPI\Interfaces\Deserializable;
use SeanJA\StatsCanAPI\ValueObjects\Coordinate;
use SeanJA\StatsCanAPI\ValueObjects\ProductId;

abstract class SeriesInfo implements Deserializable, ResponseInterface
{
    public function __construct(
        public readonly int         $responseStatusCode,
        public readonly ProductId   $productId,
        public readonly Coordinate  $coordinate,
        public readonly int         $vectorId,
        public readonly int|null    $frequencyCode,
        public readonly int|null    $scalarFactorCode,
        public readonly int|null    $decimals,
        public readonly int|null    $terminated,
        public readonly string|null $seriesTitleEn,
        public readonly string|null $seriesTitleFr,
        public readonly int|null    $memberUomCode
    )
    {
    }

    #[\Override] public static function fromResponse(array $response): static
    {
        $object = $response[0]['object'];
        // normalize the data
        $object['seriesTitleEn'] = $object['SeriesTitleEn'];
        $object['seriesTitleFr'] = $object['SeriesTitleFr'];
        unset(
            $object['SeriesTitleEn'],
            $object['SeriesTitleFr']
        );

        return static::deserialize($object);
    }

    #[\Override] public static function deserialize(array $data): static
    {
        $data['coordinate'] = Coordinate::deserialize($data['coordinate']);
        $data['productId'] = new ProductId($data['productId']);
        return new static(...$data);
    }
}