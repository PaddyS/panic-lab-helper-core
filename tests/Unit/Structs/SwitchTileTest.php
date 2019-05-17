<?php

namespace PanicLabCore\Tests\Unit\Structs;

use PanicLabCore\Structs\SwitchTile;
use PHPUnit\Framework\TestCase;

class SwitchTileTest extends TestCase
{
    public function testGetType() : void
    {
        $switchType = $this->getInstance();
        self::assertSame('size', $switchType->getType());
    }

    private function getInstance() : SwitchTile
    {
        return new SwitchTile('size');
    }
}