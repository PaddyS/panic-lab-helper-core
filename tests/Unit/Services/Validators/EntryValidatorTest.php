<?php declare(strict_types=1);

namespace PanicLabCore\Tests\Unit\Services\Validators;

use PanicLabCore\Services\Validators\EntryValidator;
use PHPUnit\Framework\TestCase;

class EntryValidatorTest extends TestCase
{
    public function testValidateDoesNotThrowExceptionValidEntry() : void
    {
        $entryValidator = $this->getInstance();

        $entryValidator->validate([
            'additional' => [
                'color' => 'red'
            ]
        ]);

        self::assertTrue(true);
    }

    public function testValidateThrowsExceptionAdditionalMissing() : void
    {
        $entryValidator = $this->getInstance();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected the key "additional" to exist.');

        $entryValidator->validate([]);
    }

    public function testValidateThrowsExceptionColorMissing() : void
    {
        $entryValidator = $this->getInstance();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected the key "color" to exist.');

        $entryValidator->validate([
            'additional' => []
        ]);
    }

    public function testValidateThrowsExceptionInvalidColor() : void
    {
        $entryValidator = $this->getInstance();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected one of: "red", "blue", "yellow". Got: "purple"');

        $entryValidator->validate([
            'additional' => [
                'color' => 'purple'
            ]
        ]);
    }

    private function getInstance() : EntryValidator
    {
        return new EntryValidator([
            'red',
            'blue',
            'yellow'
        ]);
    }
}
