<?php

declare(strict_types=1);

namespace PanicLabCore\Structs;

use PanicLabCore\Services\Exceptions\TooManyStepsException;
use function sprintf;

class Step
{
    /** @var int */
    private $currentIndex;

    /** @var int */
    private $stepCount;

    /** @var int */
    private $maxStep;

    public function __construct(int $currentIndex, int $stepCount, int $maxStep)
    {
        $this->currentIndex = $currentIndex;
        $this->stepCount = $stepCount;
        $this->maxStep = $maxStep;
    }

    public function getCurrentIndex(): int
    {
        return $this->currentIndex;
    }

    public function getStepCount(): int
    {
        return $this->stepCount;
    }

    public function getMaxStep(): int
    {
        return $this->maxStep;
    }

    /**
     * @throws TooManyStepsException
     */
    public function increase(): void
    {
        ++$this->stepCount;

        if ($this->stepCount === $this->maxStep) {
            throw new TooManyStepsException(sprintf('Step limit of %d reached', $this->maxStep));
        }

        ++$this->currentIndex;
    }

    public function checkForOverstep(int $totalCount): void
    {
        if ($this->currentIndex <= $totalCount - 1) {
            return;
        }

        $this->currentIndex = 0;
    }

    public function setCurrentIndex(int $currentIndex): void
    {
        $this->currentIndex = $currentIndex;
    }
}
