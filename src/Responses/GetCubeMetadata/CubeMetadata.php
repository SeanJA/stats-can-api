<?php

namespace SeanJA\StatsCanAPI\Responses\GetCubeMetadata;

use DateTimeImmutable;
use SeanJA\StatsCanAPI\Interfaces\Deserializable;
use SeanJA\StatsCanAPI\Responses\ResponseInterface;
use SeanJA\StatsCanAPI\ValueObjects\Dimensions\Dimension;
use SeanJA\StatsCanAPI\ValueObjects\Dimensions\Dimensions;
use SeanJA\StatsCanAPI\ValueObjects\ProductId;

class CubeMetadata implements ResponseInterface, Deserializable
{
    public function __construct(
        public readonly int               $responseStatusCode,
        public readonly ProductId         $productId,
        public readonly int|null          $cansimId,
        public readonly string            $cubeTitleEn,
        public readonly string            $cubeTitleFr,
        public readonly DateTimeImmutable $cubeStartDate,
        public readonly DateTimeImmutable $cubeEndDate,
        public readonly int               $frequencyCode,
        public readonly int               $nbSeriesCube,
        public readonly int               $nbDatapointsCube,
        public readonly DateTimeImmutable $releaseTime,
        public readonly int               $archiveStatusCode,
        public readonly string            $archiveStatusEn,
        public readonly string            $archiveStatusFr,
        public readonly array             $subjectCode,
        public readonly array             $surveyCode,
        public readonly Dimensions        $dimension,
        public readonly array             $footnote,
        public readonly array             $correctionFootnote,
        public readonly array             $correction,
    )
    {
    }

    #[\Override] public static function fromResponse(array $response): static
    {
        return self::deserialize($response[0]['object']);
    }

    #[\Override] public static function deserialize(array $data): static
    {
        $data['productId'] = new ProductId($data['productId']);
        $data['cubeStartDate'] = new DateTimeImmutable($data['cubeStartDate']);
        $data['cubeEndDate'] = new DateTimeImmutable($data['cubeEndDate']);
        $data['releaseTime'] = new DateTimeImmutable($data['releaseTime']);
        $data['dimension'] = new Dimensions(
            array_map(function ($data) {
                return Dimension::deserialize($data);
            }, $data['dimension'])
        );

        return new static(...$data);
    }
}