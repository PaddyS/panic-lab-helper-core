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

        self::assertCount(2, $testLogger->beforeLogs['calculate'][0]);
        self::assertCount(1, $testLogger->afterLogs['calculate'][0]);

        self::assertArrayHasKey('tiles', $testLogger->beforeLogs['calculate'][0]);
        self::assertArrayHasKey('dice', $testLogger->beforeLogs['calculate'][0]);

        self::assertArrayHasKey('foundTile', $testLogger->afterLogs['calculate'][0]);
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

        self::assertCount(2, $testLogger->beforeLogs['prepare'][0]);
        self::assertCount(1, $testLogger->afterLogs['prepare'][0]);

        self::assertArrayHasKey('tiles', $testLogger->beforeLogs['prepare'][0]);
        self::assertArrayHasKey('dice', $testLogger->beforeLogs['prepare'][0]);

        self::assertArrayHasKey('tiles', $testLogger->afterLogs['prepare'][0]);
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

        self::assertCount(1, $testLogger->beforeLogs['reverseTiles'][0]);
        self::assertCount(1, $testLogger->afterLogs['reverseTiles'][0]);

        self::assertArrayHasKey('tiles', $testLogger->beforeLogs['reverseTiles'][0]);

        self::assertArrayHasKey('tiles', $testLogger->afterLogs['reverseTiles'][0]);
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

        self::assertCount(1, $testLogger->beforeLogs['findStartIndex'][0]);
        self::assertCount(1, $testLogger->afterLogs['findStartIndex'][0]);

        self::assertArrayHasKey('entryColor', $testLogger->beforeLogs['findStartIndex'][0]);

        self::assertArrayHasKey('startIndex', $testLogger->afterLogs['findStartIndex'][0]);
    }

    public function testIsTargetTileShouldLog() : void
    {
        $testLogger = new TestDebugLogger();
        $debugCalcService = $this->getInstance($testLogger);
        $debugCalcService->target = new Target('orange', 'thick', 'streaked');
        $debugCalcService->isTargetTile(new GermTile('orange', 'thick', 'streaked'));

        self::assertCount(1, $testLogger->beforeLogs['isTargetTile']);
        self::assertCount(1, $testLogger->afterLogs['isTargetTile']);

        self::assertCount(2, $testLogger->beforeLogs['isTargetTile'][0]);
        self::assertCount(1, $testLogger->afterLogs['isTargetTile'][0]);

        self::assertArrayHasKey('searchedTile', $testLogger->beforeLogs['isTargetTile'][0]);
        self::assertArrayHasKey('targetTile', $testLogger->beforeLogs['isTargetTile'][0]);

        self::assertArrayHasKey('isTargetTile', $testLogger->afterLogs['isTargetTile'][0]);
    }

    public function testCalculateExecutesParent() : void
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

        self::assertNull($debugCalcService->tiles);
        $debugCalcService->calculate($tiles, $diceResult);
        self::assertNotNull($debugCalcService->tiles);
    }

    public function testPrepareExecutesParent() : void
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

        self::assertNull($debugCalcService->target);
        $debugCalcService->prepare($diceResult);
        self::assertNotNull($debugCalcService->target);
    }

    public function testReverseTilesExecutesParent() : void
    {
        $tileHydrator = self::$container->get(Hydrator::class);
        $tiles = $tileHydrator->hydrate(include __DIR__ . '/../../_fixtures/tiles.php');

        $testLogger = new TestDebugLogger();
        $debugCalcService = $this->getInstance($testLogger);
        $debugCalcService->tiles = $tiles;

        self::assertSame($tiles[0], $debugCalcService->tiles[0]);
        $debugCalcService->reverseTiles();
        self::assertNotSame($tiles[0], $debugCalcService->tiles[0]);
    }

    public function testFindStartIndexExecutesParent() : void
    {
        $tileHydrator = self::$container->get(Hydrator::class);
        $tiles = $tileHydrator->hydrate(include __DIR__ . '/../../_fixtures/tiles.php');

        $testLogger = new TestDebugLogger();
        $debugCalcService = $this->getInstance($testLogger);
        $debugCalcService->tiles = $tiles;

        $startIndex = $debugCalcService->findStartIndex('yellow');

        self::assertNotNull($startIndex);
    }

    public function testIsTargetTileExecutesParent() : void
    {
        $testLogger = new TestDebugLogger();
        $debugCalcService = $this->getInstance($testLogger);
        $debugCalcService->target = new Target('orange', 'thick', 'streaked');

        $isTargetTile = $debugCalcService->isTargetTile(new GermTile('orange', 'thick', 'streaked'));

        self::assertNotNull($isTargetTile);
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