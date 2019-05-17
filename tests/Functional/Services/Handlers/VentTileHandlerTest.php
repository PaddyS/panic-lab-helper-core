<?php declare(strict_types=1);

namespace PanicLabCore\Tests\Functional\Services\Handlers;

use PanicLabCore\Services\Handlers\VentTileHandler;
use PanicLabCore\Services\Hydrators\Hydrator;
use PanicLabCore\Structs\GermTile;
use PanicLabCore\Structs\Step;
use PanicLabCore\Structs\Target;
use PanicLabCore\Structs\VentTile;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class VentTileHandlerTest extends KernelTestCase
{
    public function setUp() : void
    {
        self::bootKernel();
    }

    public function testSupportsShouldReturnTrueVentTile() : void
    {
        $ventTileHandler = $this->getInstance();

        self::assertTrue($ventTileHandler->supports(new VentTile()));
    }

    public function testSupportsShouldReturnFalseGermTile() : void
    {
        $ventTileHandler = $this->getInstance();

        self::assertFalse($ventTileHandler->supports(new GermTile('orange', 'thick', 'dotted')));
    }

    public function testHandleSetsNewIndex() : void
    {
        $ventTileHandler = $this->getInstance();
        $tileHydrator = self::$container->get(Hydrator::class);

        $tiles = $tileHydrator->hydrate(include __DIR__ . '/../../_fixtures/tiles.php');

        $step = new Step(4, 0, 10000);
        $ventTileHandler->handle(
            $tiles,
            new Target('orange', 'thick', 'dotted'),
            $step
        );

        self::assertSame(8, $step->getCurrentIndex());
    }

    public function testHandleDealsWithResetToBeginning() : void
    {
        $ventTileHandler = $this->getInstance();
        $tileHydrator = self::$container->get(Hydrator::class);

        $tiles = $tileHydrator->hydrate(include __DIR__ . '/../../_fixtures/tiles.php');

        // Index 15 was the last possible vent. Next one is back at the beginning again
        $step = new Step(15, 0, 10000);
        $ventTileHandler->handle(
            $tiles,
            new Target('orange', 'thick', 'dotted'),
            $step
        );

        self::assertSame(4, $step->getCurrentIndex());
    }

    private function getInstance() : VentTileHandler
    {
        return new VentTileHandler();
    }
}