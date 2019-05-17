<?php

declare(strict_types=1);

namespace PanicLabCore\Structs;

use JsonSerializable;
use function get_object_vars;

abstract class Tile implements JsonSerializable
{
    /**
     * @return string[]
     */
    public function jsonSerialize() : array
    {
        return get_object_vars($this);
    }
}
