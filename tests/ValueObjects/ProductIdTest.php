<?php

namespace Tests\SeanJA\StatsCanAPI\ValueObjects;

use SeanJA\StatsCanAPI\ValueObjects\ProductId;
use Tests\SeanJA\StatsCanAPI\TestCase;

class ProductIdTest extends TestCase
{
    public function testCanConstructShortestProductId()
    {
        $productId = new ProductId(12345678);
        $this->assertInstanceOf(ProductId::class, $productId);
        $this->assertEquals('12', $productId->subject);
        $this->assertEquals('34', $productId->productType);
        $this->assertEquals('5678', $productId->sequentialNumbers);
        $this->assertEquals(null, $productId->tableOrCube);
    }

    public function testCanConstructLongestProductId()
    {
        $productId = new ProductId(1234567890);
        $this->assertInstanceOf(ProductId::class, $productId);
        $this->assertEquals('12', $productId->subject);
        $this->assertEquals('34', $productId->productType);
        $this->assertEquals('5678', $productId->sequentialNumbers);
        $this->assertEquals('90', $productId->tableOrCube);
    }

    public function testCantConstructProductIdOver10Digits()
    {
        $this->expectException(\InvalidArgumentException::class);
        new ProductId(12345678901);
    }

    public function testCantConstructProductIdUnder8Digits()
    {
        $this->expectException(\InvalidArgumentException::class);
        new ProductId(1234567);
    }

    public function testToStringShort()
    {
        $productId = new ProductId(12345678);
        $this->assertEquals('12345678', (string)$productId);
    }

    public function testToStringLong()
    {
        $productId = new ProductId(1234567890);
        $this->assertEquals('1234567890', (string)$productId);
    }

    public function testJsonSerializeShort()
    {
        $productId = new ProductId(12345678);
        $this->assertEquals(12345678, json_encode($productId));
    }

    public function testJsonSerializeLong()
    {
        $productId = new ProductId(1234567890);
        $this->assertEquals(1234567890, json_encode($productId));
    }
}