<?php

declare(strict_types=1);

namespace PanicLabCore\Services\Handlers;

use PanicLabCore\Structs\GermTile;
use PanicLabCore\Structs\Step;
use PanicLabCore\Structs\Target;
use PanicLabCore\Structs\Tile;

class GermTileHandler implements TileHandlerInterface
{
    public function supports(Tile $tile): bool
    {
        return $tile instanceof GermTile;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(array $tiles, Target $target, Step $stepStruct): void
    {
        // Nothing to handle
    }
}
