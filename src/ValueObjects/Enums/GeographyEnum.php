<?php

namespace SeanJA\StatsCanAPI\ValueObjects\Enums;

enum GeographyEnum: string
{
    case CANADA = 'Canada';
    CASE NEWFOUNDLAND_AND_LABRADOR = "St. John's, Newfoundland and Labrador";
    CASE PEI = "Charlottetown and Summerside, Prince Edward Island";
    CASE NOVA_SCOTIA = "Halifax, Nova Scotia";
    CASE NEW_BRUNSWICK = "Saint John, New Brunswick";
    CASE QUEBEC = "Québec, Quebec";
    CASE MONTREAL = "Montréal, Quebec";
    CASE OTTAWA = "Ottawa-Gatineau, Ontario part, Ontario/Quebec";
    CASE TORONTO = "Toronto, Ontario";
    CASE THUNDER_BAY = "Thunder Bay, Ontario";
    CASE MANITOBA =  "Winnipeg, Manitoba";
    CASE REGINA_SASKATCHEWAN = "Regina, Saskatchewan";
    CASE SASKATOON_SASKATCHEWAN = "Saskatoon, Saskatchewan";
    CASE EDMONTON_ALBERTA ="Edmonton, Alberta";
    CASE CALGARY_ALBERTA ="Calgary, Alberta";
    CASE VANCOUVER_BC = "Vancouver, British Columbia";
    CASE VICTORIA_BC = "Victoria, British Columbia";
    CASE WHITEHORSE = "Whitehorse, Yukon";
    CASE YELLOWKNIFE = "Yellowknife, Northwest Territories";
}