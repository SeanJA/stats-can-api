<?php

namespace SeanJA\StatsCanAPI\Responses\GetCodeSets;

use SeanJA\StatsCanAPI\Interfaces\Deserializable;
use SeanJA\StatsCanAPI\Responses\GetCodeSets\ClassificationTypes\ClassificationTypes;
use SeanJA\StatsCanAPI\Responses\GetCodeSets\Frequencies\Frequencies;
use SeanJA\StatsCanAPI\Responses\GetCodeSets\Scalars\Scalars;
use SeanJA\StatsCanAPI\Responses\GetCodeSets\SecurityLevels\SecurityLevels;
use SeanJA\StatsCanAPI\Responses\GetCodeSets\Statuses\Statuses;
use SeanJA\StatsCanAPI\Responses\GetCodeSets\Subjects\Subjects;
use SeanJA\StatsCanAPI\Responses\GetCodeSets\Surveys\Surveys;
use SeanJA\StatsCanAPI\Responses\GetCodeSets\Symbols\Symbols;
use SeanJA\StatsCanAPI\Responses\GetCodeSets\Terminateds\Terminateds;
use SeanJA\StatsCanAPI\Responses\GetCodeSets\UOMS\UOMS;
use SeanJA\StatsCanAPI\Responses\GetCodeSets\WDSResponseStatuses\WDSResponseStatuses;
use SeanJA\StatsCanAPI\Responses\ResponseInterface;

class CodeSets implements ResponseInterface, Deserializable
{

    public function __construct(
        public readonly Scalars             $scalars,
        public readonly Frequencies         $frequencies,
        public readonly Symbols             $symbols,
        public readonly Statuses            $statuses,
        public readonly UOMS                $uoms,
        public readonly Surveys             $surveys,
        public readonly Subjects            $subjects,
        public readonly ClassificationTypes $classificationTypes,
        public readonly SecurityLevels      $securityLevels,
        public readonly Terminateds         $terminateds,
        public readonly WDSResponseStatuses $wdsResponseStatuses
    )
    {
    }

    #[\Override] public static function deserialize(array $data): static
    {
        return new static(
            scalars: Scalars::deserialize($data['scalar']),
            frequencies: Frequencies::deserialize($data['frequency']),
            symbols: Symbols::deserialize($data['symbol']),
            statuses: Statuses::deserialize($data['status']),
            uoms: UOMS::deserialize($data['uom']),
            surveys: Surveys::deserialize($data['survey']),
            subjects: Subjects::deserialize($data['subject']),
            classificationTypes: ClassificationTypes::deserialize($data['classificationType']),
            securityLevels: SecurityLevels::deserialize($data['securityLevel']),
            terminateds: Terminateds::deserialize($data['terminated']),
            wdsResponseStatuses: WDSResponseStatuses::deserialize($data['wdsResponseStatus']),
        );
    }

    #[\Override] public static function fromResponse(array $response): static
    {
        return static::deserialize($response['object']);
    }
}