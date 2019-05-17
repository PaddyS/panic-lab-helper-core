<?php

namespace PanicLabCore\Tests\Unit\Structs;

use PanicLabCore\Structs\Dice;
use PHPUnit\Framework\TestCase;

class DiceTest extends TestCase
{
    public function testGetGermColor() : void
    {
        $dice = $this->getInstance();
        self::assertSame('orange', $dice->getGermColor());
    }

    public function testGetGermSize() : void
    {
        $dice = $this->getInstance();
        self::assertSame('thick', $dice->getGermSize());
    }

    public function testGetGermStyle() : void
    {
        $dice = $this->getInstance();
        self::assertSame('dotted', $dice->getGermStyle());
    }

    public function testGetEntryColor() : void
    {
        $dice = $this->getInstance();
        self::assertSame('red', $dice->getEntryColor());
    }

    public function testGetEntryDirection() : void
    {
        $dice = $this->getInstance();
        self::assertSame('left', $dice->getEntryDirection());
    }

    private function getInstance() : Dice
    {
        return new Dice(
            'orange',
            'thick',
            'dotted',
            'red',
            'left'
        );
    }
}