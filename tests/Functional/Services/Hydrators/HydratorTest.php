<?php declare(strict_types=1);

namespace PanicLabCore\Tests\Functional\Services\Hydrators;

use PanicLabCore\Services\Hydrators\HydrationCollector;
use PanicLabCore\Services\Hydrators\Hydrator;
use PanicLabCore\Structs\SwitchTile;
use PanicLabCore\Structs\VentTile;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class HydratorTest extends KernelTestCase
{
    public function setUp() : void
    {
        self::bootKernel();
    }

    public function testHydrateConvertsTileArrayIntoStructs() : void
    {
        $tiles = $this->getInstance()->hydrate([
            [
                'type' => 'switch',
                'additional' => [
                    'type' => 'color'
                ]
            ], [
                'type' => 'vent'
            ]
        ]);

        self::assertInstanceOf(SwitchTile::class, $tiles[0]);
        self::assertInstanceOf(VentTile::class, $tiles[1]);
    }

    private function getInstance() : Hydrator
    {
        $hydrationCollector = self::$container->get(HydrationCollector::class);

        return new Hydrator($hydrationCollector);
    }
}
