<?php

namespace PanicLabCore\Tests\Unit\Structs;

use PanicLabCore\Structs\VentTile;
use PHPUnit\Framework\TestCase;

class VentTileTest extends TestCase
{
    public function testGetType() : void
    {
        $ventTile = $this->getInstance();

        // Can be instantiated, everything fine
        self::assertTrue(true);
    }

    private function getInstance() : VentTile
    {
        return new VentTile();
    }
}