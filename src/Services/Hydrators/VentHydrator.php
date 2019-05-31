<?php

declare(strict_types=1);

namespace PanicLabCore\Services\Hydrators;

use PanicLabCore\Structs\Tile;
use PanicLabCore\Structs\VentTile;

class VentHydrator implements HydratorInterface
{
    public function supports(string $type): bool
    {
        return $type === 'vent';
    }

    public function hydrate(array $tile): Tile
    {
        return new VentTile();
    }

    public function validate(array $tile): void
    {
        // No validation necessary
    }
}
