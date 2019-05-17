<?php declare(strict_types=1);

namespace PanicLabCore\Tests\Unit\Services\Validators;

use PanicLabCore\Services\Validators\DiceValidator;
use PHPUnit\Framework\TestCase;

class DiceValidatorTest extends TestCase
{
    public function testValidateDoesNotThrowExceptionValidDice() : void
    {
        $diceValidator = $this->getInstance();

        $diceValidator->validate([
            'germColor' => 'blue',
            'germSize' => 'thick',
            'germStyle' => 'dotted',
            'entryColor' => 'red',
            'entryDirection' => 'left'
        ]);

        self::assertTrue(true);
    }

    public function testValidateThrowsExceptionColorMissing() : void
    {
        $diceValidator = $this->getInstance();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected the key "germColor" to exist.');

        $diceValidator->validate([
            'germSize' => 'thick',
            'germStyle' => 'dotted',
            'entryColor' => 'red',
            'entryDirection' => 'left'
        ]);
    }

    public function testValidateThrowsExceptionSizeMissing() : void
    {
        $diceValidator = $this->getInstance();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected the key "germSize" to exist.');

        $diceValidator->validate([
            'germColor' => 'blue',
            'germStyle' => 'dotted',
            'entryColor' => 'red',
            'entryDirection' => 'left'
        ]);
    }

    public function testValidateThrowsExceptionStyleMissing() : void
    {
        $diceValidator = $this->getInstance();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected the key "germStyle" to exist.');

        $diceValidator->validate([
            'germColor' => 'blue',
            'germSize' => 'thick',
            'entryColor' => 'red',
            'entryDirection' => 'left'
        ]);
    }

    public function testValidateThrowsExceptionEntryColorMissing() : void
    {
        $diceValidator = $this->getInstance();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected the key "entryColor" to exist.');

        $diceValidator->validate([
            'germColor' => 'blue',
            'germSize' => 'thick',
            'germStyle' => 'dotted',
            'entryDirection' => 'left'
        ]);
    }

    public function testValidateThrowsExceptionEntryDirectionMissing() : void
    {
        $diceValidator = $this->getInstance();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected the key "entryDirection" to exist.');

        $diceValidator->validate([
            'germColor' => 'blue',
            'germSize' => 'thick',
            'germStyle' => 'dotted',
            'entryColor' => 'red',
        ]);
    }

    public function testValidateThrowsExceptionInvalidColor() : void
    {
        $diceValidator = $this->getInstance();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected one of: "blue", "orange". Got: "red"');

        $diceValidator->validate([
            'germColor' => 'red',
            'germSize' => 'thick',
            'germStyle' => 'dotted',
            'entryColor' => 'red',
            'entryDirection' => 'left'
        ]);
    }

    public function testValidateThrowsExceptionInvalidSize() : void
    {
        $diceValidator = $this->getInstance();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected one of: "thick", "thin". Got: "huge"');

        $diceValidator->validate([
            'germColor' => 'blue',
            'germSize' => 'huge',
            'germStyle' => 'dotted',
            'entryColor' => 'red',
            'entryDirection' => 'left'
        ]);
    }

    public function testValidateThrowsExceptionInvalidStyle() : void
    {
        $diceValidator = $this->getInstance();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected one of: "streaked", "dotted". Got: "dashed"');

        $diceValidator->validate([
            'germColor' => 'blue',
            'germSize' => 'thick',
            'germStyle' => 'dashed',
            'entryColor' => 'red',
            'entryDirection' => 'left'
        ]);
    }

    public function testValidateThrowsExceptionInvalidEntryColor() : void
    {
        $diceValidator = $this->getInstance();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected one of: "red", "blue", "yellow". Got: "purple"');

        $diceValidator->validate([
            'germColor' => 'blue',
            'germSize' => 'thick',
            'germStyle' => 'dotted',
            'entryColor' => 'purple',
            'entryDirection' => 'left'
        ]);
    }

    public function testValidateThrowsExceptionInvalidEntryDirection() : void
    {
        $diceValidator = $this->getInstance();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected one of: "left", "right". Got: "down"');

        $diceValidator->validate([
            'germColor' => 'blue',
            'germSize' => 'thick',
            'germStyle' => 'dotted',
            'entryColor' => 'red',
            'entryDirection' => 'down'
        ]);
    }

    private function getInstance() : DiceValidator
    {
        return new DiceValidator(
            [ 'blue', 'orange' ],
            [ 'streaked', 'dotted' ],
            [ 'thick', 'thin' ],
            [ 'red', 'blue', 'yellow' ],
            [ 'left', 'right' ]
        );
    }
}
