<?php declare(strict_types=1);

namespace PanicLabCore\Tests\Unit\Services\Hydrators;

use PanicLabCore\Services\Hydrators\EntryHydrator;
use PanicLabCore\Services\Validators\EntryValidator;
use PanicLabCore\Structs\EntryTile;
use PHPUnit\Framework\TestCase;

class EntryHydratorTest extends TestCase
{
    public function testSupportsReturnsTrue() : void
    {
        $entryHydrator = $this->getInstance();
        self::assertTrue($entryHydrator->supports('entry'));
    }

    public function testSupportsReturnsFalse() : void
    {
        $entryHydrator = $this->getInstance();
        self::assertFalse($entryHydrator->supports('dice'));
    }

    public function testHydrateTurnsArrayIntoObject() : void
    {
        $entryHydrator = $this->getInstance();

        /** @var EntryTile $entryTile */
        $entryTile = $entryHydrator->hydrate([
            'additional' => [
                'color' => 'red'
            ]
        ]);

        self::assertInstanceOf(EntryTile::class, $entryTile);

        self::assertSame('red', $entryTile->getColor());
    }

    public function testValidateTriggersValidator() : void
    {
        $entryTileValidator = new EntryTileValidatorMock();
        $entryHydrator = $this->getInstance($entryTileValidator);

        $entryHydrator->validate([
            'color' => 'blue'
        ]);

        self::assertTrue($entryTileValidator->called);
    }

    private function getInstance(EntryValidator $entryValidator = null): EntryHydrator
    {
        if (!$entryValidator) {
            $entryValidator = new EntryValidator(
                [
                    'blue',
                    'red',
                    'yellow'
                ]
            );
        }

        return new EntryHydrator($entryValidator);
    }
}

class EntryTileValidatorMock extends EntryValidator
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