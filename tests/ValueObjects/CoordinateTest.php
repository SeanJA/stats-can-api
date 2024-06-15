<?php

namespace Tests\SeanJA\StatsCanAPI\ValueObjects;

use SeanJA\StatsCanAPI\ValueObjects\Coordinate;
use Tests\SeanJA\StatsCanAPI\TestCase;

class CoordinateTest extends TestCase
{
    public function testCanConstruct()
    {
        $coordinate = new Coordinate();
        $this->assertInstanceOf(Coordinate::class, $coordinate);
    }

    public function testCanConstructWithAllParams()
    {
        $coordinate = new Coordinate(
            1, 2, 3, 4, 5, 6, 7, 8, 9, 10
        );
        $this->assertInstanceOf(Coordinate::class, $coordinate);
    }

    public function testCannotConstructWithInvalidCoordinate()
    {
        $this->expectException(\Error::class);
        new Coordinate("test");
    }

    public function testGetValue()
    {
        $coordinate = new Coordinate(1);
        $this->assertEquals('1.0.0.0.0.0.0.0.0.0', $coordinate->getValue());
    }

    public function testGetValueSet10th()
    {
        $coordinate = new Coordinate(dimension1: 1, dimension10: 10);
        $this->assertEquals('1.0.0.0.0.0.0.0.0.10', $coordinate->getValue());
    }

    public function testSetDimension()
    {
        $coordinate = new Coordinate(dimension1: 1, dimension10: 10);
        $this->assertEquals('1.0.0.0.0.0.0.0.0.10', $coordinate->getValue());
        $coordinate->setDimension(10, 20);
        $this->assertEquals('1.0.0.0.0.0.0.0.0.20', $coordinate->getValue());
    }

}