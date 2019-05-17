<?php

declare(strict_types=1);

namespace PanicLabCore\Structs;

class GermTile extends Tile
{
    /** @var string */
    protected $color;

    /** @var string */
    protected $size;

    /** @var string */
    protected $style;

    public function __construct(string $color, string $size, string $style)
    {
        $this->color = $color;
        $this->size  = $size;
        $this->style = $style;
    }

    public function getColor() : string
    {
        return $this->color;
    }

    public function getSize() : string
    {
        return $this->size;
    }

    public function getStyle() : string
    {
        return $this->style;
    }
}
