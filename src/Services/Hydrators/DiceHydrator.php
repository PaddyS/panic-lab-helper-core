<?php

declare(strict_types=1);

namespace PanicLabCore\Services\Hydrators;

use PanicLabCore\Services\Validators\ValidatorInterface;
use PanicLabCore\Structs\Dice;
use PanicLabCore\Structs\Tile;

class DiceHydrator implements HydratorInterface
{
    /** @var ValidatorInterface */
    private $diceValidator;

    public function __construct(ValidatorInterface $diceValidator)
    {
        $this->diceValidator = $diceValidator;
    }

    public function supports(string $type) : bool
    {
        return true;
    }

    public function hydrate(array $diceData) : Tile
    {
        return new Dice(
            $diceData['germColor'],
            $diceData['germSize'],
            $diceData['germStyle'],
            $diceData['entryColor'],
            $diceData['entryDirection']
        );
    }

    public function validate(array $diceData) : void
    {
        $this->diceValidator->validate($diceData);
    }
}
