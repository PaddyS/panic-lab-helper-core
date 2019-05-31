<?php

declare(strict_types=1);

namespace PanicLabCore\Services\Validators;

use Webmozart\Assert\Assert;

class DiceValidator implements ValidatorInterface
{
    /** @var string[] */
    private $germColors;

    /** @var string[] */
    private $germStyles;

    /** @var string[] */
    private $germSizes;

    /** @var string[] */
    private $entryColors;

    /** @var string[] */
    private $entryDirections;

    /**
     * @param string[] $germColors
     * @param string[] $germStyles
     * @param string[] $germSizes
     * @param string[] $entryColors
     * @param string[] $entryDirections
     */
    public function __construct(
        array $germColors,
        array $germStyles,
        array $germSizes,
        array $entryColors,
        array $entryDirections
    ) {
        $this->germColors = $germColors;
        $this->germStyles = $germStyles;
        $this->germSizes = $germSizes;
        $this->entryColors = $entryColors;
        $this->entryDirections = $entryDirections;
    }

    public function validate(array $diceData): void
    {
        Assert::keyExists($diceData, 'germColor');
        Assert::keyExists($diceData, 'germSize');
        Assert::keyExists($diceData, 'germStyle');
        Assert::keyExists($diceData, 'entryColor');
        Assert::keyExists($diceData, 'entryDirection');

        Assert::oneOf($diceData['germColor'], $this->germColors);
        Assert::oneOf($diceData['germSize'], $this->germSizes);
        Assert::oneOf($diceData['germStyle'], $this->germStyles);
        Assert::oneOf($diceData['entryColor'], $this->entryColors);
        Assert::oneOf($diceData['entryDirection'], $this->entryDirections);
    }
}
