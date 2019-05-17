<?php

declare(strict_types=1);

namespace PanicLabCore\Services\Handlers;

use PanicLabCore\Structs\Step;
use PanicLabCore\Structs\Target;
use PanicLabCore\Structs\Tile;
use PanicLabCore\Structs\VentTile;
use function count;

class VentTileHandler implements TileHandlerInterface
{
    public function supports(Tile $tile) : bool
    {
        return $tile instanceof VentTile;
    }

    /**
     * @param Tile[] $tiles
     */
    public function handle(array $tiles, Target $target, Step $stepStruct) : void
    {
        $allVents = [];

        foreach ($tiles as $key => $tile) {
            if (! ($tile instanceof VentTile)) {
                continue;
            }

            $allVents[] = (int) $key;
        }

        $nextVentIndex = 0;
        $totalVents    = count($allVents);
        foreach ($allVents as $ventKey => $ventIndex) {
            if ($ventIndex !== $stepStruct->getCurrentIndex()) {
                continue;
            }

            $ventKey = (int) $ventKey;
            // Currently active vent is last vent
            if ($ventKey + 1 === $totalVents) {
                $nextVentIndex = $allVents[0];
            } else {
                $nextVentIndex = $allVents[$ventKey + 1];
            }
        }

        $stepStruct->setCurrentIndex($nextVentIndex);
    }
}
