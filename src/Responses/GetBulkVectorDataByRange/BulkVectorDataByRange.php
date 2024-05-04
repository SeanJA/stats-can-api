<?php

namespace SeanJA\StatsCanAPI\Responses\GetBulkVectorDataByRange;

use Ramsey\Collection\AbstractCollection;
use SeanJA\StatsCanAPI\Responses\ResponseInterface;

class BulkVectorDataByRange extends AbstractCollection implements ResponseInterface
{
    public function getType(): string
    {
        return VectorDataByRange::class;
    }

    #[\Override] public static function fromResponse(array $response): static
    {
        return new static(
            array_map(function ($data) {
                $data['object']['vectorDataPoints'] = $data['object']['vectorDataPoint'];
                unset($data['object']['vectorDataPoint']);
                return VectorDataByRange::deserialize($data['object']);
            }, $response)
        );
    }
}