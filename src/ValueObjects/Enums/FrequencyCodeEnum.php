<?php

namespace SeanJA\StatsCanAPI\ValueObjects\Enums;
enum FrequencyCodeEnum: int
{
    case DAILY = 1;
    case SEMIANNUAL = 11;
    case ANNUAL = 12;
    case EVERY_2_YEARS = 13;
    case EVERY_3_YEARS = 14;
    case EVERY_4_YEARS = 15;
    case EVERY_5_YEARS = 16;
    case EVERY_10_YEARS = 17;
    case OCCASIONAL = 18;
    case OCCASIONAL_QUARTERLY = 19;
    case WEEKLY = 2;
    case OCCASIONAL_MONTHLY = 20;
    case OCCASIONAL_DAILY = 21;
    case BIWEEKLY = 4;
    case MONTHLY = 6;
    case BIMONTHLY = 7;
    case QUARTERLY = 9;
}