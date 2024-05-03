<?php

namespace SeanJA\StatsCanAPI\ValueObjects\Dimensions;

use SeanJA\StatsCanAPI\Responses\Deserializable;

class Dimension implements Deserializable
{

    public function __construct(
        public readonly string     $dimensionNameEn,
        public readonly string     $dimensionNameFr,
        public readonly int        $dimensionPositionId,
        public readonly bool       $hasUom,
        public readonly array|null $member = null
    )
    {
    }

    public static function deserialize(array $data): self
    {
        if(isset($data['hasUOM'])){
            $data['hasUom'] = $data['hasUOM'];
            unset($data['hasUOM']);
        }
        if (isset($data['member'])) {
            $data['member'] = array_map(function (array $member) {
                return Member::deserialize($member);
            }, $data['member']);
        }
        return new self(
            ...$data
        );
    }
}