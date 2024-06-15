<?php

namespace SeanJA\StatsCanAPI\ValueObjects\VectorDataPoints;

use SeanJA\StatsCanAPI\Interfaces\Deserializable;

class VectorDataPoint implements Deserializable
{
    public function __construct(
        public readonly \DateTimeImmutable      $refPer,
        public readonly \DateTimeImmutable|null $refPer2,
        public readonly \DateTimeImmutable      $refPerRaw,
        public readonly \DateTimeImmutable|null $refPerRaw2,
        public readonly string|null             $value,
        public readonly int                     $decimals,
        public readonly int                     $scalarFactorCode,
        public readonly int                     $symbolCode,
        public readonly int                     $statusCode,
        public readonly int                     $securityLevelCode,
        public readonly \DateTimeImmutable      $releaseTime,
        public readonly int                     $frequencyCode,
    )
    {
    }

    #[\Override] public static function deserialize(array $data): static
    {
        $data['refPer'] = new \DateTimeImmutable($data['refPer']);
        $data['refPerRaw'] = new \DateTimeImmutable($data['refPerRaw']);
        $data['refPer2'] = $data['refPer2'] ? new \DateTimeImmutable($data['refPer2']) : null;
        $data['refPerRaw2'] = $data['refPerRaw2'] ? new \DateTimeImmutable($data['refPerRaw2']) : null;
        $data['releaseTime'] = new \DateTimeImmutable($data['releaseTime']);

        return new static(...$data);
    }
}