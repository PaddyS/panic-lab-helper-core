<?php declare(strict_types=1);

namespace PanicLabCore\Tests\Functional\Services;

use PanicLabCore\Services\CalcService;
use PanicLabCore\Services\Exceptions\EntryTileMissingException;
use PanicLabCore\Services\Exceptions\TooManyStepsException;
use PanicLabCore\Services\Handlers\TileHandlerCollector;
use PanicLabCore\Structs\Dice;
use PanicLabCore\Structs\EntryTile;
use PanicLabCore\Structs\GermTile;
use PanicLabCore\Structs\Step;
use PanicLabCore\Structs\SwitchTile;
use PanicLabCore\Structs\Target;
use PanicLabCore\Structs\VentTile;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CalcServiceTest extends KernelTestCase
{
    public function setUp() : void
    {
        self::bootKernel();
    }

    public function testFindStartIndex() : void
    {
        $calcService = $this->getInstance();

        $calcService->tiles = [
            // Invalid tile is skipped
            new SwitchTile('color'),
            new EntryTile('red')
        ];

        self::assertSame(1, $calcService->findStartIndex('red'));

        $calcService->tiles = [
            new SwitchTile('color'),
            // Invalid entry tile is skipped
            new EntryTile('red'),
            new VentTile(),
            new EntryTile('blue')
        ];

        self::assertSame(3, $calcService->findStartIndex('blue'));
    }

    public function testFindStartIndexThrowsException() : void
    {
        $calcService = $this->getInstance();

        $calcService->tiles = [
            new SwitchTile('color'),
            new EntryTile('red')
        ];

        $this->expectException(EntryTileMissingException::class);
        $this->expectExceptionMessage('No entry tile with color \'blue\' in the set-up.');

        $calcService->findStartIndex('blue');
    }

    public function testReverseTiles() : void
    {
        $calcService = $this->getInstance();

        $calcService->tiles = [
            new SwitchTile('color'),
            new VentTile()
        ];

        $calcService->reverseTiles();

        self::assertInstanceOf(VentTile::class, $calcService->tiles[0]);
    }

    public function testPrepareReversesTilesEntryDirectionLeft() : void
    {
        $calcService = $this->getInstance();

        $calcService->tiles = [
            new SwitchTile('color'),
            new EntryTile('red'),
            new VentTile()
        ];

        $calcService->prepare(
            new Dice('orange', 'thick', 'streaked', 'red', 'left')
        );

        self::assertInstanceOf(VentTile::class, $calcService->tiles[0]);
    }

    public function testPrepareSetsNewTarget() : void
    {
        $calcService = $this->getInstance();

        $calcService->tiles = [
            new SwitchTile('color'),
            new EntryTile('red'),
            new VentTile()
        ];

        $calcService->prepare(
            new Dice('orange', 'thick', 'streaked', 'red', 'left')
        );

        self::assertNotNull($calcService->target);
        self::assertInstanceOf(Target::class, $calcService->target);

        self::assertSame('orange', $calcService->target->getGermColor());
        self::assertSame('thick', $calcService->target->getGermSize());
        self::assertSame('streaked', $calcService->target->getGermStyle());
    }

    public function testPrepareSetsNewStepStruct() : void
    {
        $calcService = $this->getInstance();
        $calcService->maxSteps = 5;

        $calcService->tiles = [
            new SwitchTile('color'),
            new EntryTile('red'),
            new VentTile()
        ];

        $calcService->prepare(
            new Dice('orange', 'thick', 'streaked', 'red', 'left')
        );

        self::assertNotNull($calcService->stepStruct);
        self::assertInstanceOf(Step::class, $calcService->stepStruct);

        self::assertSame(5, $calcService->stepStruct->getMaxStep());
        self::assertSame(1, $calcService->stepStruct->getCurrentIndex());
        self::assertSame(0, $calcService->stepStruct->getStepCount());
    }

    public function testIsTargetTileReturnsFalseNoGermTile() : void
    {
        $calcService = $this->getInstance();

        self::assertFalse($calcService->isTargetTile(new VentTile()));
    }

    public function testIsTargetTileReturnsFalseWrongGermTile() : void
    {
        $calcService = $this->getInstance();
        $calcService->target = new Target('orange', 'thick', 'streaked');

        self::assertFalse($calcService->isTargetTile(new GermTile('orange', 'thick', 'dotted')));
    }

    public function testIsTargetTileReturnsTrueWrongGermTile() : void
    {
        $calcService = $this->getInstance();
        $calcService->target = new Target('orange', 'thick', 'streaked');

        self::assertTrue($calcService->isTargetTile(new GermTile('orange', 'thick', 'streaked')));
    }

    public function testCalculateSetsTiles() : void
    {
        $calcService = $this->getInstance();

        $calcService->calculate(
            [
                new EntryTile('red'),
                new GermTile('orange', 'thick', 'dotted')
            ],
            new Dice('orange', 'thick', 'dotted', 'red', 'left')
        );

        self::assertNotNull($calcService->tiles);
        self::assertCount(2, $calcService->tiles);
    }

    public function testStepTakesStepsAsExpected() : void
    {
        $calcService = $this->getInstance();
        $calcService->target = new Target('orange', 'thin', 'streaked');
        $calcService->tiles = [
            new EntryTile('red'),
            new SwitchTile('color'),
            new GermTile('orange', 'thick', 'streaked'),
            new VentTile(),
            new EntryTile('blue'),
            new VentTile(),
            new GermTile('blue', 'thin', 'streaked')
        ];

        $calcService->stepStruct = new Step(0, 0, 1000);

        $calcService->step();

        self::assertSame(4, $calcService->stepStruct->getStepCount());
    }

    public function testStepThrowsExceptionMaxSteps() : void
    {
        $calcService = $this->getInstance();
        $calcService->target = new Target('orange', 'thin', 'streaked');
        $calcService->tiles = [
            new EntryTile('red'),
            new SwitchTile('color'),
            new GermTile('orange', 'thick', 'streaked'),
            new VentTile(),
            new EntryTile('blue'),
            new VentTile(),
            new GermTile('blue', 'thin', 'streaked')
        ];

        $calcService->stepStruct = new Step(0, 0, 3);

        $this->expectException(TooManyStepsException::class);
        $this->expectExceptionMessage('Step limit of 3 reached');

        $calcService->step();
    }

    public function testCalculateFindsProperTile() : void
    {
        $calcService = $this->getInstance();
        $calcService->target = new Target('orange', 'thin', 'streaked');

        $calcService->stepStruct = new Step(0, 0, 10000);

        $tile = $calcService->calculate(
            require __DIR__ . '/_fixtures/setup.php',
            new Dice('blue', 'thick', 'streaked', 'red', 'right')
        );

        self::assertSame('blue', $tile->getColor());
        self::assertSame('thick', $tile->getSize());
        self::assertSame('streaked', $tile->getStyle());

        self::assertSame(43, $calcService->stepStruct->getStepCount());
    }

    private function getInstance() : CalcService
    {
        return new CalcService(
            self::$container->get(TileHandlerCollector::class),
            self::$container->getParameter('max_steps')
        );
    }
}
