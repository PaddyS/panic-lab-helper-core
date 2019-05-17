<?php declare(strict_types=1);

namespace PanicLabCore\Tests\Unit\Services\Hydrators;

use PanicLabCore\Services\Hydrators\DiceHydrator;
use PanicLabCore\Services\Validators\DiceValidator;
use PanicLabCore\Structs\Dice;
use PHPUnit\Framework\TestCase;

class DiceHydratorTest extends TestCase
{
    public function testSupportsReturnsTrue() : void
    {
        $diceHydrator = $this->getInstance();
        self::assertTrue($diceHydrator->supports('dice'));
    }

    public function testSupportsReturnsFalse() : void
    {
        $diceHydrator = $this->getInstance();
        self::assertTrue($diceHydrator->supports('entry'));
    }

    public function testHydrateTurnsArrayIntoObject() : void
    {
        $diceHydrator = $this->getInstance();

        /** @var Dice $dice */
        $dice = $diceHydrator->hydrate([
            'germColor' => 'orange',
            'germSize' => 'thick',
            'germStyle' => 'dotted',
            'entryColor' => 'red',
            'entryDirection' => 'left'
        ]);

        self::assertInstanceOf(Dice::class, $dice);

        self::assertSame('orange', $dice->getGermColor());
        self::assertSame('thick', $dice->getGermSize());
        self::assertSame('dotted', $dice->getGermStyle());
        self::assertSame('red', $dice->getEntryColor());
        self::assertSame('left', $dice->getEntryDirection());
    }

    public function testValidateTriggersValidator() : void
    {
        $diceValidator = new DiceValidatorMock();
        $diceHydrator = $this->getInstance($diceValidator);

        $diceHydrator->validate([
            'germColor' => 'orange',
            'germSize' => 'thick',
            'germStyle' => 'dotted',
            'entryColor' => 'red',
            'entryDirection' => 'left'
        ]);

        self::assertTrue($diceValidator->called);
    }

    private function getInstance(DiceValidator $diceValidator = null): DiceHydrator
    {
        if (!$diceValidator) {
            $diceValidator = new DiceValidator(
                ['orange', 'blue'],
                ['thick', 'thin'],
                ['streaked', 'dotted'],
                ['red', 'yellow', 'blue'],
                ['left', 'right']
            );
        }

        return new DiceHydrator($diceValidator);
    }
}

class DiceValidatorMock extends DiceValidator
{
    public $called = false;

    public function __construct()
    {
    }

    public function validate(array $diceData): void
    {
        $this->called = true;
    }
}
