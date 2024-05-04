<?php

namespace SeanJA\StatsCanAPI\Requests;

use GuzzleHttp\Psr7\Request;

class GetDataFromVectorByReferencePeriodRange implements StatsCanAPIRequestInterface
{
    public function __construct(
        private readonly array              $vectorIds,
        private readonly \DateTimeInterface $startRefPeriod,
        private readonly \DateTimeInterface $endDataPointReleaseDate
    )
    {
    }

    public function __invoke(): Request
    {
        $vectorIds = array_map(function ($id) {
            return '"' . $id . '"';
        }, $this->vectorIds);
        return new Request(
            'GET',
            'https://www150.statcan.gc.ca/t1/wds/rest/getDataFromVectorByReferencePeriodRange?' .
            'vectorIds=' . implode(',', $vectorIds) .
            '&startRefPeriod=' . $this->startRefPeriod->format('Y-m-d')
            . '&endReferencePeriod=' . $this->endDataPointReleaseDate->format('Y-m-d')
        );
    }
}