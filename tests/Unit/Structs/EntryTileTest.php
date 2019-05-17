<?php

namespace PanicLabCore\Tests\Unit\Structs;

use PanicLabCore\Structs\EntryTile;
use PHPUnit\Framework\TestCase;

class EntryTileTest extends TestCase
{
    public function testGetColor() : void
    {
        $entryTile = $this->getInstance();
        self::assertSame('red', $entryTile->getColor());
    }

    private function getInstance() : EntryTile
    {
        return new EntryTile('red');
    }
}