<?php

namespace SeanJA\StatsCanAPI\Responses;

interface Deserializable
{
    public static function deserialize(array $data): self;
}