<?php

declare(strict_types=1);

namespace PanicLabCore\Services\Validators;

use Webmozart\Assert\Assert;

class EntryValidator implements ValidatorInterface
{
    /** @var string[] */
    private $entryColors;

    public function __construct(array $entryColors)
    {
        $this->entryColors = $entryColors;
    }

    public function validate(array $tile) : void
    {
        Assert::keyExists($tile, 'additional');

        $additional = $tile['additional'];

        Assert::keyExists($additional, 'color');
        Assert::oneOf($additional['color'], $this->entryColors);
    }
}
