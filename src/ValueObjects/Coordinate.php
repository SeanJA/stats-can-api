<?php

namespace SeanJA\StatsCanAPI\ValueObjects;

use SeanJA\StatsCanAPI\Interfaces\Deserializable;

/**
 * Coordinate is a concatenation of the member ID values for each dimension. One value per dimension.
 * (i.e. "1.3.1.1.1.1.0.0.0.0" ) A table PID number combined with a coordinate will identify a
 * unique time series of data points.
 */
class Coordinate implements \JsonSerializable, Deserializable
{
    public function __construct(
        private int $dimension1 = 0,
        private int $dimension2 = 0,
        private int $dimension3 = 0,
        private int $dimension4 = 0,
        private int $dimension5 = 0,
        private int $dimension6 = 0,
        private int $dimension7 = 0,
        private int $dimension8 = 0,
        private int $dimension9 = 0,
        private int $dimension10 = 0
    )
    {
    }


    public function getValue(): string
    {
        return implode('.', [
            $this->dimension1,
            $this->dimension2,
            $this->dimension3,
            $this->dimension4,
            $this->dimension5,
            $this->dimension6,
            $this->dimension7,
            $this->dimension8,
            $this->dimension9,
            $this->dimension10
        ]);
    }

    public function jsonSerialize(): string
    {
        return $this->getValue();
    }

    public static function deserialize(mixed $data): static
    {
        $data = explode('.', $data);
        $data = array_map(function ($data) {
            return (int)$data;
        }, $data);
        return new static(...$data);
    }

    public function setDimension(int $dimensionPosition, int $memberId): void
    {
        $position = 'dimension' . $dimensionPosition;
        $this->$position = $memberId;
    }
}