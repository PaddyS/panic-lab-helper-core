<?php declare(strict_types=1);

namespace PanicLabCore\Tests\Unit\Services\Hydrators;

use PanicLabCore\Services\Hydrators\VentHydrator;
use PanicLabCore\Services\Validators\VentValidator;
use PanicLabCore\Structs\VentTile;
use PHPUnit\Framework\TestCase;

class VentHydratorTest extends TestCase
{
    public function testSupportsReturnsTrue() : void
    {
        $ventHydrator = $this->getInstance();
        self::assertTrue($ventHydrator->supports('vent'));
    }

    public function testSupportsReturnsFalse() : void
    {
        $ventHydrator = $this->getInstance();
        self::assertFalse($ventHydrator->supports('dice'));
    }

    public function testHydrateTurnsArrayIntoObject() : void
    {
        /** @var VentTile $ventTile */
        $ventTile = $this->getInstance()->hydrate([]);

        self::assertInstanceOf(VentTile::class, $ventTile);
    }

    private function getInstance() : VentHydrator
    {
        return new VentHydrator();
    }
}