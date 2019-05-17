<?php

declare(strict_types=1);

namespace PanicLabCore\Services;

use PanicLabCore\Structs\Dice;
use PanicLabCore\Structs\GermTile;
use PanicLabCore\Structs\Tile;

interface CalcServiceInterface
{
    /**
     * @param Tile[] $tiles
     */
    public function calculate(array $tiles, Dice $diceResult) : GermTile;

    public function prepare(Dice $diceResult) : void;

    public function step() : GermTile;

    public function reverseTiles() : void;

    public function findStartIndex(string $entryColor) : int;

    public function isTargetTile(Tile $tile) : bool;
}
