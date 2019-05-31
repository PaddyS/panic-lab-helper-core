<?php

declare(strict_types=1);

namespace PanicLabCore\Services\Handlers;

use PanicLabCore\Structs\Step;
use PanicLabCore\Structs\SwitchTile;
use PanicLabCore\Structs\Target;
use PanicLabCore\Structs\Tile;

class SwitchTileHandler implements TileHandlerInterface
{
    public function supports(Tile $tile): bool
    {
        return $tile instanceof SwitchTile;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(array $tiles, Target $target, Step $stepStruct): void
    {
        /** @var SwitchTile $tile */
        $tile = $tiles[$stepStruct->getCurrentIndex()];

        $this->change($tile->getType(), $target);
    }

    public function change(string $switchType, Target $target): void
    {
        if ($switchType === 'color') {
            $this->switchColor($target);
        }

        if ($switchType === 'size') {
            $this->switchSize($target);
        }

        if ($switchType !== 'style') {
            return;
        }

        $this->switchStyle($target);
    }

    public function switchColor(Target $target): void
    {
        if ($target->getGermColor() === 'blue') {
            $target->setGermColor('orange');
        } else {
            $target->setGermColor('blue');
        }
    }

    public function switchSize(Target $target): void
    {
        if ($target->getGermSize() === 'thick') {
            $target->setGermSize('thin');
        } else {
            $target->setGermSize('thick');
        }
    }

    public function switchStyle(Target $target): void
    {
        if ($target->getGermStyle() === 'dotted') {
            $target->setGermStyle('streaked');
        } else {
            $target->setGermStyle('dotted');
        }
    }
}
