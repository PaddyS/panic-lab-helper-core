<?php

namespace PanicLabCore\Tests\Unit\Structs;

use PanicLabCore\Structs\GermTile;
use PanicLabCore\Structs\Target;
use PHPUnit\Framework\TestCase;

class TargetTest extends TestCase
{
    public function testGetGermColor() : void
    {
        $target = $this->getInstance();
        self::assertSame('orange', $target->getGermColor());
    }

    public function testGetGermSize() : void
    {
        $target = $this->getInstance();
        self::assertSame('thick', $target->getGermSize());
    }

    public function testGetGermStyle() : void
    {
        $target = $this->getInstance();
        self::assertSame('dotted', $target->getGermStyle());
    }

    public function testSetGermColor() : void
    {
        $target = $this->getInstance();
        $target->setGermColor('blue');
        self::assertSame('blue', $target->getGermColor());
    }

    public function testSetGermSize() : void
    {
        $target = $this->getInstance();
        $target->setGermSize('thick');
        self::assertSame('thick', $target->getGermSize());
    }

    public function testSetGermStyle() : void
    {
        $target = $this->getInstance();
        $target->setGermStyle('dotted');
        self::assertSame('dotted', $target->getGermStyle());
    }

    public function testCheckIfSameShouldBeTrue() : void
    {
        $target = $this->getInstance();

        $validTile = new GermTile('orange', 'thick', 'dotted');

        self::assertTrue($target->checkIfSame($validTile));
    }

    public function testCheckIfSameShouldBeFalseWrongColor() : void
    {
        $target = $this->getInstance();

        self::assertFalse(
            $target->checkIfSame(
                new GermTile('blue', 'thick', 'dotted')
            )
        );
    }

    public function testCheckIfSameShouldBeFalseWrongSize() : void
    {
        $target = $this->getInstance();

        self::assertFalse(
            $target->checkIfSame(
                new GermTile('orange', 'thin', 'dotted')
            )
        );
    }

    public function testCheckIfSameShouldBeFalseWrongStyle() : void
    {
        $target = $this->getInstance();

        self::assertFalse(
            $target->checkIfSame(
                new GermTile('orange', 'thick', 'streaked')
            )
        );
    }

    public function testJsonSerialize() : void
    {
        $target = $this->getInstance();
        $string = json_encode($target);

        self::assertSame('{"germColor":"orange","germSize":"thick","germStyle":"dotted"}', $string);

        $target->setGermColor('blue');
        $string = json_encode($target);
        self::assertSame('{"germColor":"blue","germSize":"thick","germStyle":"dotted"}', $string);
    }

    private function getInstance() : Target
    {
        return new Target('orange', 'thick', 'dotted');
    }
}