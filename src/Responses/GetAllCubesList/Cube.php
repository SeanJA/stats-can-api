<?php

namespace SeanJA\StatsCanApi\Responses\GetAllCubesList;

use DateTimeImmutable;
use SeanJA\StatsCanApi\ValueObjects\Collections\Dimensions;
use SeanJA\StatsCanApi\ValueObjects\Dimension;
use SeanJA\StatsCanApi\ValueObjects\ProductId;

class Cube
{

    public function __construct(
        public readonly ProductId         $productId,
        public readonly string|null       $cansimId,
        public readonly string            $cubeTitleEn,
        public readonly string            $cubeTitleFr,
        public readonly DateTimeImmutable $cubeStartDate,
        public readonly DateTimeImmutable $cubeEndDate,
        public readonly DateTimeImmutable $releaseTime,
        public readonly bool               $archived,
        public readonly array               $subjectCode,
        public readonly array               $surveyCode,
        public readonly int               $frequencyCode,
        public readonly array             $corrections,
        public readonly Dimensions        $dimensions
    )
    {
    }

    /**
     * @param array $data
     * @return self
     * @throws \Exception
     */
    public static function deserialize(array $data): self
    {
        return new self(
            new ProductId($data['productId']),
            $data['cansimId'],
            $data['cubeTitleEn'],
            $data['cubeTitleFr'],
            new DateTimeImmutable($data['cubeStartDate']),
            new DateTimeImmutable($data['cubeEndDate']),
            new DateTimeImmutable($data['releaseTime']),
            $data['archived'] === "1",
            (array)$data['subjectCode'],
            (array)$data['surveyCode'],
            $data['frequencyCode'],
            $data['corrections'],
            new Dimensions(array_map(function ($data) {
                return Dimension::deserialize($data);
            }, $data['dimensions']))
        );
    }
}