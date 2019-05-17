<?php

declare(strict_types=1);

namespace PanicLabCore\Services\Validators;

use Webmozart\Assert\Assert;

class SwitchValidator implements ValidatorInterface
{
    /** @var string[] */
    private $switchTypes;

    public function __construct(array $switchTypes)
    {
        $this->switchTypes = $switchTypes;
    }

    public function validate(array $tile) : void
    {
        Assert::keyExists($tile, 'additional');

        $additional = $tile['additional'];
        Assert::keyExists($additional, 'type');
        Assert::oneOf($tile['additional']['type'], $this->switchTypes);
    }
}
