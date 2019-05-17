<?php

declare(strict_types=1);

namespace PanicLabCore\Services\Validators;

interface ValidatorInterface
{
    public function validate(array $tile) : void;
}
