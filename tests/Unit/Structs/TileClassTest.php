<?php

namespace PanicLabCore\Tests\Unit\Structs;

use PanicLabCore\Structs\Dice;
use PHPUnit\Framework\TestCase;

class TileClassTest extends TestCase
{
    public function testJsonSerialize() : void
    {
        $dice = new Dice(
            'orange',
            'thick',
            'dotted',
            'red',
            'left',
        );

        $string = json_encode($dice);

        self::assertSame('{"germColor":"orange","germSize":"thick","germStyle":"dotted","entryColor":"red","entryDirection":"left"}', $string);
    }
}