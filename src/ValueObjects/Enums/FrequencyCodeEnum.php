<?php

namespace SeanJA\StatsCanAPI\ValueObjects\Enums;
enum FrequencyCodeEnum: int
{
    case ANNUAL = 12;
    case BIMONTHLY = 7;
    case BIWEEKLY = 4;
    case DAILY = 1;
    case EVERY_10_YEARS = 17;
    case EVERY_2_YEARS = 13;
    case EVERY_3_YEARS = 14;
    case EVERY_4_YEARS = 15;
    case EVERY_5_YEARS = 16;
    case MONTHLY = 6;
    case OCCASIONAL = 18;
    case OCCASIONAL_DAILY = 21;
    case OCCASIONAL_MONTHLY = 20;
    case OCCASIONAL_QUARTERLY = 19;
    case QUARTERLY = 9;
    case SEMI_ANNUAL = 11;
    case WEEKLY = 2;
}
