<?php

declare(strict_types=1);

namespace PanicLabCore\Structs;

class EntryTile extends Tile
{
    /** @var string */
    protected $color;

    public function __construct(string $color)
    {
        $this->color = $color;
    }

    public function getColor() : string
    {
        return $this->color;
    }
}
