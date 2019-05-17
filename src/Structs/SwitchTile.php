<?php

declare(strict_types=1);

namespace PanicLabCore\Structs;

class SwitchTile extends Tile
{
    /** @var string */
    protected $type;

    public function __construct(string $type)
    {
        $this->type = $type;
    }

    public function getType() : string
    {
        return $this->type;
    }
}
