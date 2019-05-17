<?php declare(strict_types=1);

namespace PanicLabCore\Tests\Unit\Services\Validators;

use PanicLabCore\Services\Validators\SwitchValidator;
use PHPUnit\Framework\TestCase;

class SwitchValidatorTest extends TestCase
{
    public function testValidateDoesNotThrowExceptionValidSwitch() : void
    {
        $switchValidator = $this->getInstance();

        $switchValidator->validate([
            'additional' => [
                'type' => 'color'
            ]
        ]);

        self::assertTrue(true);
    }

    public function testValidateThrowsExceptionAdditionalMissing() : void
    {
        $switchValidator = $this->getInstance();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected the key "additional" to exist.');

        $switchValidator->validate([]);
    }

    public function testValidateThrowsExceptionTypeMissing() : void
    {
        $switchValidator = $this->getInstance();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected the key "type" to exist.');

        $switchValidator->validate([
            'additional' => []
        ]);
    }

    public function testValidateThrowsExceptionInvalidType() : void
    {
        $switchValidator = $this->getInstance();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected one of: "color", "size", "style". Got: "mood"');

        $switchValidator->validate([
            'additional' => [
                'type' => 'mood'
            ]
        ]);
    }

    private function getInstance() : SwitchValidator
    {
        return new SwitchValidator([
            'color',
            'size',
            'style'
        ]);
    }
}
