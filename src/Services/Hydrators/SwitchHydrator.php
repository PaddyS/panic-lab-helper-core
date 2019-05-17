<?php

declare(strict_types=1);

namespace PanicLabCore\Services\Hydrators;

use PanicLabCore\Services\Validators\ValidatorInterface;
use PanicLabCore\Structs\SwitchTile;
use PanicLabCore\Structs\Tile;

class SwitchHydrator implements HydratorInterface
{
    /** @var ValidatorInterface */
    private $switchValidator;

    public function __construct(ValidatorInterface $switchValidator)
    {
        $this->switchValidator = $switchValidator;
    }

    public function supports(string $type) : bool
    {
        return $type === 'switch';
    }

    public function hydrate(array $tile) : Tile
    {
        return new SwitchTile($tile['additional']['type']);
    }

    public function validate(array $tile) : void
    {
        $this->switchValidator->validate($tile);
    }
}
