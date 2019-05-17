<?php

declare(strict_types=1);

namespace PanicLabCore\Structs;

use JsonSerializable;
use function get_object_vars;

class Target implements JsonSerializable
{
    /** @var string */
    protected $germColor;

    /** @var string */
    protected $germSize;

    /** @var string */
    protected $germStyle;

    public function __construct(string $germColor, string $germSize, string $germStyle)
    {
        $this->germColor = $germColor;
        $this->germSize  = $germSize;
        $this->germStyle = $germStyle;
    }

    public function setGermColor(string $germColor) : void
    {
        $this->germColor = $germColor;
    }

    public function setGermSize(string $germSize) : void
    {
        $this->germSize = $germSize;
    }

    public function setGermStyle(string $germStyle) : void
    {
        $this->germStyle = $germStyle;
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

    public function checkIfSame(GermTile $tile) : bool
    {
        if ($tile->getColor() !== $this->getGermColor()) {
            return false;
        }

        if ($tile->getSize() !== $this->getGermSize()) {
            return false;
        }

        return $tile->getStyle() === $this->getGermStyle();
    }

    /**
     * @return string[]
     */
    public function jsonSerialize() : array
    {
        return get_object_vars($this);
    }
}
