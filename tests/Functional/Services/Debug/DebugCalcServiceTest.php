<?php

namespace PanicLabCore\Tests\Functional\Services\Debug;

use PanicLabCore\Services\Debug\DebugCalcService;
use PanicLabCore\Services\Handlers\EntryTileHandler;
use PanicLabCore\Services\Handlers\TileHandlerCollector;
use PanicLabCore\Structs\Dice;
use PanicLabCore\Structs\GermTile;
use PanicLabCore\Structs\Target;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use PanicLabCore\Services\Hydrators\Hydrator;

class DebugCalcServiceTest extends KernelTestCase
{
    public function setUp() : void
    {
        self::bootKernel();
    }

    public function testCalculateShouldLog() : void
    {
        $tileHydrator = self::$container->get(Hydrator::class);

        $tiles = $tileHydrator->hydrate(include __DIR__ . '/../../_fixtures/tiles.php');
        $diceResult = new Dice(
            'blue',
            'thick',
            'dotted',
            'yellow',
            'right',
        );

        $testLogger = new TestDebugLogger();
        $this->getInstance($testLogger)->calculate($tiles, $diceResult);

        self::assertCount(1, $testLogger->beforeLogs['calculate']);
        self::assertCount(1, $testLogger->afterLogs['calculate']);
    }

    public function testPrepareShouldLog() : void
    {
        $tileHydrator = self::$container->get(Hydrator::class);
        $tiles = $tileHydrator->hydrate(include __DIR__ . '/../../_fixtures/tiles.php');

        $diceResult = new Dice(
            'blue',
            'thick',
            'dotted',
            'yellow',
            'right',
        );

        $testLogger = new TestDebugLogger();
        $debugCalcService = $this->getInstance($testLogger);
        $debugCalcService->tiles = $tiles;
        $debugCalcService->prepare($diceResult);

        self::assertCount(1, $testLogger->beforeLogs['prepare']);
        self::assertCount(1, $testLogger->afterLogs['prepare']);
    }

    public function testReverseTilesShouldLog() : void
    {
        $tileHydrator = self::$container->get(Hydrator::class);
        $tiles = $tileHydrator->hydrate(include __DIR__ . '/../../_fixtures/tiles.php');

        $testLogger = new TestDebugLogger();
        $debugCalcService = $this->getInstance($testLogger);
        $debugCalcService->tiles = $tiles;
        $debugCalcService->reverseTiles();

        self::assertCount(1, $testLogger->beforeLogs['reverseTiles']);
        self::assertCount(1, $testLogger->afterLogs['reverseTiles']);
    }

    public function testFindStartIndexShouldLog() : void
    {
        $tileHydrator = self::$container->get(Hydrator::class);
        $tiles = $tileHydrator->hydrate(include __DIR__ . '/../../_fixtures/tiles.php');

        $testLogger = new TestDebugLogger();
        $debugCalcService = $this->getInstance($testLogger);
        $debugCalcService->tiles = $tiles;
        $debugCalcService->findStartIndex('yellow');

        self::assertCount(1, $testLogger->beforeLogs['findStartIndex']);
        self::assertCount(1, $testLogger->afterLogs['findStartIndex']);
    }

    public function testIsTargetTileShouldLog() : void
    {
        $testLogger = new TestDebugLogger();
        $debugCalcService = $this->getInstance($testLogger);
        $debugCalcService->target = new Target('orange', 'thick', 'streaked');
        $debugCalcService->isTargetTile(new GermTile('orange', 'thick', 'streaked'));

        self::assertCount(1, $testLogger->beforeLogs['isTargetTile']);
        self::assertCount(1, $testLogger->afterLogs['isTargetTile']);
    }

    private function getInstance(TestDebugLogger $testLogger): DebugCalcService
    {
        return new DebugCalcService(
            $testLogger,
            new TileHandlerCollector(
                new \ArrayIterator([
                    new EntryTileHandler()
                ])
            ),
            10000
        );
    }
}