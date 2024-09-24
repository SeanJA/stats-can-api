<?php

namespace SeanJA\StatsCanAPI\ValueObjects\Enums;
enum ScalarCodeEnum: int
{
    case BILLIONS = 9;
    case HUNDREDS = 2;
    case HUNDREDS_OF_MILLIONS = 8;
    case HUNDREDS_OF_THOUSANDS = 5;
    case MILLIONS = 6;
    case TENS = 1;
    case TENS_OF_MILLIONS = 7;
    case TENS_OF_THOUSANDS = 4;
    case THOUSANDS = 3;
    case UNITS = 0;
}
