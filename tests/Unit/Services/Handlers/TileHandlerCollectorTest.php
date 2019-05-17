<?php declare(strict_types=1);

namespace PanicLabCore\Tests\Unit\Services\Handlers;

use PanicLabCore\Services\Handlers\EntryTileHandler;
use PanicLabCore\Services\Handlers\SwitchTileHandler;
use PanicLabCore\Services\Handlers\TileHandlerCollector;
use PanicLabCore\Structs\Step;
use PanicLabCore\Structs\SwitchTile;
use PanicLabCore\Structs\Target;
use PHPUnit\Framework\TestCase;

class TileHandlerCollectorTest extends TestCase
{
    public function testHandleFindsProperHandler() : void
    {
        $tileHandlerCollector = $this->getInstance();

        $target = new Target('orange', 'thick', 'dotted');

        $tileHandlerCollector->handle(
            [
                new SwitchTile('size')
            ],
            $target,
            new Step(0, 0, 10000)
        );

        self::assertSame('thin', $target->getGermSize());
    }

    private function getInstance() : TileHandlerCollector
    {
        return new TileHandlerCollector(
            new \ArrayIterator([
                new SwitchTileHandler(),
                new EntryTileHandler()
            ])
        );
    }
}
