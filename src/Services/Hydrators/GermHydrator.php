<?php

declare(strict_types=1);

namespace PanicLabCore\Services\Hydrators;

use PanicLabCore\Services\Validators\ValidatorInterface;
use PanicLabCore\Structs\GermTile;
use PanicLabCore\Structs\Tile;

class GermHydrator implements HydratorInterface
{
    /** @var ValidatorInterface */
    private $germValidator;

    public function __construct(ValidatorInterface $germValidator)
    {
        $this->germValidator = $germValidator;
    }

    public function supports(string $type) : bool
    {
        return $type === 'germ';
    }

    public function hydrate(array $tile) : Tile
    {
        $additional = $tile['additional'];

        return new GermTile(
            $additional['color'],
            $additional['size'],
            $additional['style']
        );
    }

    public function validate(array $tile) : void
    {
        $this->germValidator->validate($tile);
    }
}
