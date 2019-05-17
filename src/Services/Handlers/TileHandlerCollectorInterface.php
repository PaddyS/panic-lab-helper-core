<?php

declare(strict_types=1);

namespace PanicLabCore\Services\Handlers;

use PanicLabCore\Structs\Step;
use PanicLabCore\Structs\Target;
use PanicLabCore\Structs\Tile;

interface TileHandlerCollectorInterface
{
    /**
     * @param Tile[] $tile
     */
    public function handle(array $tile, Target $target, Step $stepStruct) : void;
}
