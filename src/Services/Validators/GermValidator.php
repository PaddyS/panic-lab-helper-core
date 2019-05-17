<?php

declare(strict_types=1);

namespace PanicLabCore\Services\Validators;

use Webmozart\Assert\Assert;

class GermValidator implements ValidatorInterface
{
    /** @var string[] */
    private $germColors;

    /** @var string[] */
    private $germStyles;

    /** @var string[] */
    private $germSizes;

    /**
     * @param string[] $germColors
     * @param string[] $germStyles
     * @param string[] $germSizes
     */
    public function __construct(array $germColors, array $germStyles, array $germSizes)
    {
        $this->germColors = $germColors;
        $this->germStyles = $germStyles;
        $this->germSizes  = $germSizes;
    }

    public function validate(array $tile) : void
    {
        Assert::keyExists($tile, 'additional');

        $additionalData = $tile['additional'];

        Assert::keyExists($additionalData, 'color');
        Assert::keyExists($additionalData, 'style');
        Assert::keyExists($additionalData, 'size');

        Assert::oneOf($additionalData['color'], $this->germColors);
        Assert::oneOf($additionalData['style'], $this->germStyles);
        Assert::oneOf($additionalData['size'], $this->germSizes);
    }
}
