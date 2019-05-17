<?php

use PanicLabCore\Structs\{
    EntryTile,
    GermTile,
    VentTile,
    SwitchTile
};

return [
    new EntryTile('red'),
    new GermTile('blue', 'thin', 'streaked'),
    new VentTile(),
    new GermTile('orange', 'thin', 'dotted'),
    new GermTile('orange', 'thick', 'dotted'),
    new EntryTile('yellow'),
    new GermTile('blue', 'thin', 'streaked'),
    new SwitchTile('color'),
    new GermTile('blue', 'thick', 'dotted'),
    new GermTile('orange', 'thin', 'streaked'),
    new GermTile('blue', 'thick', 'streaked'),
    new GermTile('orange', 'thick', 'streaked'),
    new EntryTile('blue'),
    new GermTile('blue', 'thick', 'streaked'),
    new VentTile(),
    new GermTile('orange', 'thin', 'streaked'),
    new SwitchTile('size'),
    new GermTile('blue', 'thick', 'dotted'),
    new GermTile('orange', 'thin', 'dotted'),
    new GermTile('orange', 'thick', 'streaked'),
    new GermTile('blue', 'thin', 'dotted'),
    new SwitchTile('style'),
    new VentTile(),
    new GermTile('blue', 'thin', 'dotted'),
    new GermTile('orange', 'thick', 'dotted'),
];