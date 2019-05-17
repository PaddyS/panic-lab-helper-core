<?php

declare(strict_types=1);

namespace PanicLabCore\Services\Hydrators;

use PanicLabCore\Services\Validators\ValidatorInterface;
use PanicLabCore\Structs\EntryTile;
use PanicLabCore\Structs\Tile;

class EntryHydrator implements HydratorInterface
{
    /** @var ValidatorInterface */
    private $entryValidator;

    public function __construct(ValidatorInterface $entryValidator)
    {
        $this->entryValidator = $entryValidator;
    }

    public function supports(string $type) : bool
    {
        return $type === 'entry';
    }

    public function hydrate(array $tile) : Tile
    {
        return new EntryTile($tile['additional']['color']);
    }

    public function validate(array $tile) : void
    {
        $this->entryValidator->validate($tile);
    }
}
