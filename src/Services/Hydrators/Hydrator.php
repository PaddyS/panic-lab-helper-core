<?php

declare(strict_types=1);

namespace PanicLabCore\Services\Hydrators;

use PanicLabCore\Structs\Tile;

final class Hydrator
{
    /** @var HydrationCollectorInterface */
    private $hydrationCollector;

    public function __construct(HydrationCollectorInterface $hydrationCollector)
    {
        $this->hydrationCollector = $hydrationCollector;
    }

    /**
     * @return Tile[]
     */
    public function hydrate(array $tiles) : array
    {
        $tileStructs = [];
        foreach ($tiles as $tile) {
            $tileStructs[] = $this->hydrationCollector->hydrate($tile);
        }

        return $tileStructs;
    }
}
