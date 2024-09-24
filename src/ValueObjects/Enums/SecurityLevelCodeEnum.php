<?php

namespace SeanJA\StatsCanAPI\ValueObjects\Enums;
enum SecurityLevelCodeEnum: int
{
    case PUBLIC = 0;
    case SUPPRESSED_TO_MEET_THE_CONFIDENTIALITY_REQUIREMENTS_OF_THE_STATISTICS_ACT = 1;
}
