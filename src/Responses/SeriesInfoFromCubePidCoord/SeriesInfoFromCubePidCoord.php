<?php

namespace SeanJA\StatsCanAPI\Responses\SeriesInfoFromCubePidCoord;

use SeanJA\StatsCanAPI\Responses\Deserializable;
use SeanJA\StatsCanAPI\Responses\ResponseInterface;
use SeanJA\StatsCanAPI\ValueObjects\ProductId;

class SeriesInfoFromCubePidCoord implements ResponseInterface, Deserializable
{
    public function __construct(
        public readonly int $responseStatusCode,
        public readonly ProductId $productId,
        public readonly string $coordinate,
        public readonly int $vectorId,
        public readonly int $frequencyCode,
        public readonly int $scalarFactorCode,
        public readonly int $decimals,
        public readonly int $terminated,
        public readonly string $seriesTitleEn,
        public readonly string $seriesTitleFr,
        public readonly int $memberUomCode
    ){}

    #[\Override] public static function fromResponse(array $response): self
    {
        return SeriesInfoFromCubePidCoord::deserialize($response[0]['object']);
    }

    #[\Override] public static function deserialize(array $data): self
    {
        $data['productId'] = new ProductId($data['productId']);
        // normalize the data
        $data['seriesTitleEn'] = $data['SeriesTitleEn'];
        $data['seriesTitleFr'] = $data['SeriesTitleFr'];
        unset(
            $data['SeriesTitleEn'],
            $data['SeriesTitleFr']
        );

        return new self(...$data);
    }
}