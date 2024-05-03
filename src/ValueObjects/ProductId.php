<?php

namespace SeanJA\StatsCanApi\ValueObjects;

/**
 * Representative / default view product ID for a table:
 */
class ProductId
{
    public readonly string $subject;
    public readonly string $productType;
    public readonly string $sequentialNumbers;
    public readonly string|null $tableOrCube;

    public function __construct(
        public readonly int $value
    )
    {
        if (strlen($this->value) > 10) {
            throw new \InvalidArgumentException('product id must be less than 10 digits long');
        }
        if (strlen($this->value) < 8) {
            throw new \InvalidArgumentException('product id must be at least 8 digits long');
        }
        $this->subject = substr($this->value, 0, 2);
        $this->productType = substr($this->value, 2, 2);
        $this->sequentialNumbers = substr($this->value, 4, 4);
        if (strlen($this->value) === 10) {
            $this->tableOrCube = substr($this->value, 8, 2);
        } else {
            $this->tableOrCube = null;
        }
    }
}