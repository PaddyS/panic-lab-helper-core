<?php

declare(strict_types=1);

namespace PanicLabCore\Services\Handlers;

use PanicLabCore\Structs\Step;
use PanicLabCore\Structs\Target;
use PanicLabCore\Structs\Tile;

interface TileHandlerInterface
{
    public function supports(Tile $tile): bool;

    /**
     * @param Tile[] $tiles
     */
    public function handle(array $tiles, Target $target, Step $stepStruct): void;
}
