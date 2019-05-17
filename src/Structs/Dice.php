<?php

declare(strict_types=1);

namespace PanicLabCore\Structs;

class Dice extends Tile
{
    /** @var string */
    protected $germColor;

    /** @var string */
    protected $germSize;

    /** @var string */
    protected $germStyle;

    /** @var string */
    protected $entryColor;

    /** @var string */
    protected $entryDirection;

    public function __construct(
        string $germColor,
        string $germSize,
        string $germStyle,
        string $entryColor,
        string $entryDirection
    ) {
        $this->germColor      = $germColor;
        $this->germSize       = $germSize;
        $this->germStyle      = $germStyle;
        $this->entryColor     = $entryColor;
        $this->entryDirection = $entryDirection;
    }

    public function getGermColor() : string
    {
        return $this->germColor;
    }

    public function getGermSize() : string
    {
        return $this->germSize;
    }

    public function getGermStyle() : string
    {
        return $this->germStyle;
    }

    public function getEntryColor() : string
    {
        return $this->entryColor;
    }

    public function getEntryDirection() : string
    {
        return $this->entryDirection;
    }
}
