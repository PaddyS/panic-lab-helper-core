<?php

declare(strict_types=1);

namespace PanicLabCore\Services\Debug;

use PanicLabCore\Services\CalcService;
use PanicLabCore\Services\Debug\Log\DebugLoggerInterface;
use PanicLabCore\Services\Handlers\TileHandlerCollectorInterface;
use PanicLabCore\Structs;

class DebugCalcService extends CalcService
{
    /** @var DebugLoggerInterface */
    private $debugLogger;

    public function __construct(
        DebugLoggerInterface $debugLogger,
        TileHandlerCollectorInterface $tileHandlerCollector,
        int $maxSteps
    ) {
        $this->debugLogger = $debugLogger;

        parent::__construct($tileHandlerCollector, $maxSteps);
    }

    /**
     * {@inheritdoc}
     */
    public function calculate(array $tiles, Structs\Dice $diceResult) : Structs\GermTile
    {
        $this->debugLogger->logBefore('calculate', ['Tiles' => $tiles, 'Dice' => $diceResult]);
        $foundTile = parent::calculate($tiles, $diceResult);
        $this->debugLogger->logAfter('calculate', [$foundTile]);

        return $foundTile;
    }

    public function prepare(Structs\Dice $diceResult) : void
    {
        $this->debugLogger->logBefore('prepare', ['Dice' => $diceResult, 'Tiles' => $this->tiles]);
        parent::prepare($diceResult);
        $this->debugLogger->logAfter('prepare', ['Tiles' => $this->tiles]);
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTiles() : void
    {
        $this->debugLogger->logBefore('reverseTiles', ['Tiles' => $this->tiles]);
        parent::reverseTiles();
        $this->debugLogger->logAfter('reverseTiles', ['Tiles' => $this->tiles]);
    }

    /**
     * {@inheritdoc}
     */
    public function findStartIndex(string $entryColor) : int
    {
        $this->debugLogger->logBefore('findStartIndex', ['Entry color' => $entryColor]);
        $startIndex = parent::findStartIndex($entryColor);
        $this->debugLogger->logAfter('findStartIndex', ['Start index' => $startIndex]);

        return $startIndex;
    }

    /**
     * {@inheritdoc}
     */
    public function isTargetTile(Structs\Tile $tile) : bool
    {
        $this->debugLogger->logBefore('isTargetTile', ['Searched tile' => $tile, 'Target tile' => $this->target]);
        $isTargetTile = parent::isTargetTile($tile);
        $this->debugLogger->logAfter('isTargetTile', ['Is target tile' => $isTargetTile]);

        return $isTargetTile;
    }
}
