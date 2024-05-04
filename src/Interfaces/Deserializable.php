<?php

namespace SeanJA\StatsCanAPI\Interfaces;

interface Deserializable
{
    public static function deserialize(array $data): static;
}