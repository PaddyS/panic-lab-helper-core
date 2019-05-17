<?php declare(strict_types=1);

namespace PanicLabCore\Tests\Unit\Services\Validators;

use PanicLabCore\Services\Validators\GermValidator;
use PHPUnit\Framework\TestCase;

class GermValidatorTest extends TestCase
{
    public function testValidateDoesNotThrowExceptionValidGerm() : void
    {
        $diceValidator = $this->getInstance();

        $diceValidator->validate([
            'additional' => [
                'color' => 'blue',
                'size' => 'thick',
                'style' => 'dotted',
            ]
        ]);

        self::assertTrue(true);
    }

    public function testValidateThrowsExceptionAdditionalMissing() : void
    {
        $germValidator = $this->getInstance();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected the key "additional" to exist.');

        $germValidator->validate([]);
    }

    public function testValidateThrowsExceptionColorMissing() : void
    {
        $germValidator = $this->getInstance();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected the key "color" to exist.');

        $germValidator->validate([
            'additional' => [
                'size' => 'thick',
                'style' => 'dotted',
            ]
        ]);
    }

    public function testValidateThrowsExceptionSizeMissing() : void
    {
        $germValidator = $this->getInstance();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected the key "size" to exist.');

        $germValidator->validate([
            'additional' => [
                'color' => 'blue',
                'style' => 'dotted',
            ]
        ]);
    }

    public function testValidateThrowsExceptionStyleMissing() : void
    {
        $germValidator = $this->getInstance();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected the key "style" to exist.');

        $germValidator->validate([
            'additional' => [
                'color' => 'blue',
                'size' => 'thick',
            ]
        ]);
    }

    public function testValidateThrowsExceptionInvalidColor() : void
    {
        $germValidator = $this->getInstance();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected one of: "blue", "orange". Got: "black"');

        $germValidator->validate([
            'additional' => [
                'color' => 'black',
                'size' => 'thick',
                'style' => 'dotted',
            ]
        ]);
    }

    public function testValidateThrowsExceptionInvalidSize() : void
    {
        $germValidator = $this->getInstance();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected one of: "thick", "thin". Got: "tiny"');

        $germValidator->validate([
            'additional' => [
                'color' => 'blue',
                'size' => 'tiny',
                'style' => 'dotted',
            ]
        ]);
    }

    public function testValidateThrowsExceptionInvalidStyle() : void
    {
        $germValidator = $this->getInstance();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected one of: "streaked", "dotted". Got: "funky"');

        $germValidator->validate([
            'additional' => [
                'color' => 'blue',
                'size' => 'thick',
                'style' => 'funky',
            ]
        ]);
    }

    private function getInstance() : GermValidator
    {
        return new GermValidator(
            [ 'blue', 'orange' ],
            [ 'streaked', 'dotted' ],
            [ 'thick', 'thin' ],
        );
    }
}
