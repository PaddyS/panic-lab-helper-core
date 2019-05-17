<?php

declare(strict_types=1);

namespace PanicLabCore\Services;

use PanicLabCore\Services\Exceptions\EntryTileMissingException;
use PanicLabCore\Services\Handlers\TileHandlerCollectorInterface;
use PanicLabCore\Structs\Dice;
use PanicLabCore\Structs\EntryTile;
use PanicLabCore\Structs\GermTile;
use PanicLabCore\Structs\Step;
use PanicLabCore\Structs\Target;
use PanicLabCore\Structs\Tile;
use function array_reverse;
use function count;
use function sprintf;

class CalcService implements CalcServiceInterface
{
    /** @var Tile[] */
    public $tiles;

    /** @var Dice */
    public $diceResult;

    /** @var Target */
    public $target;

    /** @var int */
    public $maxSteps;

    /** @var TileHandlerCollectorInterface */
    public $tileHandlerCollector;

    /** @var Step */
    public $stepStruct;

    public function __construct(TileHandlerCollectorInterface $tileHandler, int $maxSteps)
    {
        $this->tileHandlerCollector = $tileHandler;
        $this->maxSteps             = $maxSteps;
    }

    /**
     * {@inheritdoc}
     */
    public function calculate(array $tiles, Dice $diceResult) : GermTile
    {
        $this->tiles = $tiles;

        $this->prepare($diceResult);

        return $this->step();
    }

    public function prepare(Dice $diceResult) : void
    {
        if ($diceResult->getEntryDirection() === 'left') {
            $this->reverseTiles();
        }

        $this->target     = new Target(
            $diceResult->getGermColor(),
            $diceResult->getGermSize(),
            $diceResult->getGermStyle()
        );
        $this->stepStruct = new Step($this->findStartIndex($diceResult->getEntryColor()), 0, $this->maxSteps);
    }

    public function reverseTiles() : void
    {
        $this->tiles = array_reverse($this->tiles);
    }

    public function findStartIndex(string $entryColor) : int
    {
        foreach ($this->tiles as $tileIndex => $tile) {
            if (! $tile instanceof EntryTile) {
                continue;
            }

            if ($tile->getColor() !== $entryColor) {
                continue;
            }

            return (int) $tileIndex;
        }

        throw new EntryTileMissingException(sprintf('No entry tile with color \'%s\' in the set-up.', $entryColor));
    }

    public function step() : GermTile
    {
        $this->stepStruct->increase();
        $this->stepStruct->checkForOverstep(count($this->tiles));

        /** @var GermTile $currentTile */
        $currentTile = $this->tiles[$this->stepStruct->getCurrentIndex()];

        if ($this->isTargetTile($currentTile)) {
            return $currentTile;
        }

        $this->tileHandlerCollector->handle($this->tiles, $this->target, $this->stepStruct);

        return $this->step();
    }

    public function isTargetTile(Tile $tile) : bool
    {
        if (! $tile instanceof GermTile) {
            return false;
        }

        return $this->target->checkIfSame($tile);
    }
}
