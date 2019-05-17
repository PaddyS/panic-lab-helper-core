<?php declare(strict_types=1);

namespace PanicLabCore\Tests\Unit\Services\Handlers;

use PanicLabCore\Services\Handlers\EntryTileHandler;
use PanicLabCore\Structs\EntryTile;
use PanicLabCore\Structs\GermTile;
use PHPUnit\Framework\TestCase;

class EntryTileHandlerTest extends TestCase
{
    public function testSupportsShouldReturnTrueEntryTile() : void
    {
        $entryTileHandler = $this->getInstance();

        self::assertTrue($entryTileHandler->supports(new EntryTile('red')));
    }

    public function testSupportsShouldReturnFalseGermTile() : void
    {
        $entryTileHandler = $this->getInstance();

        self::assertFalse($entryTileHandler->supports(new GermTile('orange', 'thick', 'dotted')));
    }

    private function getInstance() : EntryTileHandler
    {
        return new EntryTileHandler();
    }
}