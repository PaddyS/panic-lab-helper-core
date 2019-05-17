<?php declare(strict_types=1);

namespace PanicLabCore\Tests\Unit\Services\Hydrators;

use PanicLabCore\Services\Hydrators\GermHydrator;
use PanicLabCore\Services\Validators\GermValidator;
use PanicLabCore\Structs\GermTile;
use PHPUnit\Framework\TestCase;

class GermHydratorTest extends TestCase
{
    public function testSupportsReturnsTrue() : void
    {
        $germHydrator = $this->getInstance();
        self::assertTrue($germHydrator->supports('germ'));
    }

    public function testSupportsReturnsFalse() : void
    {
        $germHydrator = $this->getInstance();
        self::assertFalse($germHydrator->supports('dice'));
    }

    public function testHydrateTurnsArrayIntoObject() : void
    {
        $germHydrator = $this->getInstance();

        /** @var GermTile $germTile */
        $germTile = $germHydrator->hydrate([
            'additional' => [
                'color' => 'orange',
                'size' => 'thin',
                'style' => 'streaked',
            ]
        ]);

        self::assertInstanceOf(GermTile::class, $germTile);

        self::assertSame('orange', $germTile->getColor());
        self::assertSame('thin', $germTile->getSize());
        self::assertSame('streaked', $germTile->getStyle());
    }

    public function testValidateTriggersValidator() : void
    {
        $germTileValidator = new GermTileValidatorMock();
        $germHydrator = $this->getInstance($germTileValidator);

        $germHydrator->validate([
            'color' => 'orange',
            'size' => 'thin',
            'style' => 'streaked',
        ]);

        self::assertTrue($germTileValidator->called);
    }

    private function getInstance(GermValidator $germValidator = null): GermHydrator
    {
        if (!$germValidator) {
            $germValidator = new GermValidator(
                [ 'blue', 'orange' ],
                [ 'streaked', 'dotted' ],
                [ 'thick', 'thin' ]
            );
        }

        return new GermHydrator($germValidator);
    }
}

class GermTileValidatorMock extends GermValidator
{
    public $called = false;

    public function __construct()
    {
    }

    public function validate(array $entryData): void
    {
        $this->called = true;
    }
}