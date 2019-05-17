<?php

namespace PanicLabCore\Tests\Unit\Structs;

use PanicLabCore\Structs\GermTile;
use PHPUnit\Framework\TestCase;

class GermTileTest extends TestCase
{
    public function testGetColor() : void
    {
        $germ = $this->getInstance();
        self::assertSame('orange', $germ->getColor());
    }

    public function testGetSize() : void
    {
        $germ = $this->getInstance();
        self::assertSame('thick', $germ->getSize());
    }

    public function testGetStyle() : void
    {
        $germ = $this->getInstance();
        self::assertSame('dotted', $germ->getStyle());
    }

    private function getInstance() : GermTile
    {
        return new GermTile('orange', 'thick', 'dotted');
    }
}