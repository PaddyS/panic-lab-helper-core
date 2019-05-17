<?php declare(strict_types=1);

namespace PanicLabCore\Tests\Unit\Services\Hydrators;

use PanicLabCore\Services\Hydrators\SwitchHydrator;
use PanicLabCore\Services\Validators\SwitchValidator;
use PanicLabCore\Structs\SwitchTile;
use PHPUnit\Framework\TestCase;

class SwitchHydratorTest extends TestCase
{
    public function testSupportsReturnsTrue() : void
    {
        $switchHydrator = $this->getInstance();
        self::assertTrue($switchHydrator->supports('switch'));
    }

    public function testSupportsReturnsFalse() : void
    {
        $switchHydrator = $this->getInstance();
        self::assertFalse($switchHydrator->supports('dice'));
    }

    public function testHydrateTurnsArrayIntoObject() : void
    {
        $switchHydrator = $this->getInstance();

        /** @var SwitchTile $switchTile */
        $switchTile = $switchHydrator->hydrate([
            'additional' => [
                'type' => 'size',
            ]
        ]);

        self::assertInstanceOf(SwitchTile::class, $switchTile);

        self::assertSame('size', $switchTile->getType());
    }

    public function testValidateTriggersValidator() : void
    {
        $switchValidator = new SwitchTileValidatorMock();
        $switchHydrator = $this->getInstance($switchValidator);

        $switchHydrator->validate([
            'type' => 'style',
        ]);

        self::assertTrue($switchValidator->called);
    }

    private function getInstance(SwitchValidator $switchValidator = null): SwitchHydrator
    {
        if (!$switchValidator) {
            $switchValidator = new SwitchValidator(
                [ 'color', 'size', 'style' ],
            );
        }

        return new SwitchHydrator($switchValidator);
    }
}

class SwitchTileValidatorMock extends SwitchValidator
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