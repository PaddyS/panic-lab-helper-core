<?php declare(strict_types=1);

namespace PanicLabCore\Tests\Unit\Services\Handlers;

use PanicLabCore\Services\Handlers\GermTileHandler;
use PanicLabCore\Structs\EntryTile;
use PanicLabCore\Structs\GermTile;
use PHPUnit\Framework\TestCase;

class GermTileHandlerTest extends TestCase
{
    public function testSupportsShouldReturnTrueGermTile() : void
    {
        $germTileHandler = $this->getInstance();

        self::assertTrue($germTileHandler->supports(new GermTile('orange', 'thick', 'dotted')));
    }

    public function testSupportsShouldReturnFalseEntryTile() : void
    {
        $germTileHandler = $this->getInstance();

        self::assertFalse($germTileHandler->supports(new EntryTile('red')));
    }

    private function getInstance() : GermTileHandler
    {
        return new GermTileHandler();
    }
}