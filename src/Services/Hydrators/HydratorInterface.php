<?php

declare(strict_types=1);

namespace PanicLabCore\Services\Hydrators;

use PanicLabCore\Structs\Tile;

interface HydratorInterface
{
    public function supports(string $type) : bool;

    public function hydrate(array $tile) : Tile;

    public function validate(array $tile) : void;
}
