<?php declare(strict_types=1);

namespace PanicLabCore\Tests\Unit\Services\Handlers;

use PanicLabCore\Services\Handlers\SwitchTileHandler;
use PanicLabCore\Structs\GermTile;
use PanicLabCore\Structs\Step;
use PanicLabCore\Structs\SwitchTile;
use PanicLabCore\Structs\Target;
use PHPUnit\Framework\TestCase;

class SwitchTileHandlerTest extends TestCase
{
    public function testSupportsShouldReturnTrueSwitchTile() : void
    {
        $switchTileHandler = $this->getInstance();

        self::assertTrue($switchTileHandler->supports(new SwitchTile('color')));
    }

    public function testSupportsShouldReturnFalseGermTile() : void
    {
        $switchTileHandler = $this->getInstance();

        self::assertFalse($switchTileHandler->supports(new GermTile('orange', 'thick', 'dotted')));
    }

    public function testHandleShouldSwitchProperly() : void
    {
        $switchTileHandler = $this->getInstance();

        $target = new Target('orange', 'thick', 'dotted');

        $switchTileHandler->handle(
            [
                new SwitchTile('size'),
            ],
            $target,
            new Step(0, 0, 10000)
        );

        self::assertSame('thin', $target->getGermSize());
    }

    public function testChangeShouldChangeColor() : void
    {
        $switchTileHandler = $this->getInstance();

        $target = new Target('orange', 'thick', 'dotted');
        $switchTileHandler->change('color', $target);

        self::assertSame('blue', $target->getGermColor());
    }

    public function testChangeShouldChangeSize() : void
    {
        $switchTileHandler = $this->getInstance();

        $target = new Target('orange', 'thick', 'dotted');
        $switchTileHandler->change('size', $target);

        self::assertSame('thin', $target->getGermSize());
    }

    public function testChangeShouldChangeStyle() : void
    {
        $switchTileHandler = $this->getInstance();

        $target = new Target('orange', 'thick', 'dotted');
        $switchTileHandler->change('style', $target);

        self::assertSame('streaked', $target->getGermStyle());
    }

    public function testSwitchColorWorks() : void
    {
        $switchTileHandler = $this->getInstance();

        $target = new Target('orange', 'thick', 'dotted');
        $switchTileHandler->switchColor($target);

        self::assertSame('blue', $target->getGermColor());

        $switchTileHandler->switchColor($target);
        self::assertSame('orange', $target->getGermColor());
    }

    public function testSwitchSizeWorks() : void
    {
        $switchTileHandler = $this->getInstance();

        $target = new Target('orange', 'thick', 'dotted');
        $switchTileHandler->switchSize($target);

        self::assertSame('thin', $target->getGermSize());

        $switchTileHandler->switchSize($target);
        self::assertSame('thick', $target->getGermSize());
    }

    public function testSwitchStyleWorks() : void
    {
        $switchTileHandler = $this->getInstance();

        $target = new Target('orange', 'thick', 'dotted');
        $switchTileHandler->switchStyle($target);

        self::assertSame('streaked', $target->getGermStyle());

        $switchTileHandler->switchStyle($target);
        self::assertSame('dotted', $target->getGermStyle());
    }

    private function getInstance() : SwitchTileHandler
    {
        return new SwitchTileHandler();
    }
}