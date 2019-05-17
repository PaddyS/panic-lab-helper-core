<?php

namespace PanicLabCore\Tests\Unit\Structs;

use PanicLabCore\Services\Exceptions\TooManyStepsException;
use PanicLabCore\Structs\Step;
use PHPUnit\Framework\TestCase;

class StepTest extends TestCase
{
    public function testGetCurrentIndex() : void
    {
        $step = $this->getInstance();
        self::assertSame(15, $step->getCurrentIndex());
    }

    public function testGetStepCount() : void
    {
        $step = $this->getInstance();
        self::assertSame(0, $step->getStepCount());
    }

    public function testGetMaxStep() : void
    {
        $step = $this->getInstance();
        self::assertSame(5, $step->getMaxStep());
    }

    public function testIncreaseIncreasesStepCount() : void
    {
        $step = $this->getInstance();

        $step->increase();

        self::assertSame(1, $step->getStepCount());
    }

    public function testIncreaseIncreasesCurrentIndex() : void
    {
        $step = $this->getInstance();

        $step->increase();

        self::assertSame(16, $step->getCurrentIndex());
    }

    public function testIncreaseThrowsExceptionOnMaxStep() : void
    {
        $step = $this->getInstance();

        $this->expectException(TooManyStepsException::class);

        for ($i = 0; $i < $step->getMaxStep(); $i++) {
            $step->increase();
        }
    }

    public function testCheckForOverstepHandlesOverstep() : void
    {
        $step = $this->getInstance();
        $step->increase();

        self::assertSame(16, $step->getCurrentIndex());

        $step->checkForOverstep(10);
        self::assertSame(0, $step->getCurrentIndex());

        $step->increase();
        $step->checkForOverstep(10);
        self::assertSame(1, $step->getCurrentIndex());
    }

    public function testSetCurrentIndexSetsCurrentIndex() : void
    {
        $step = $this->getInstance();

        $step->setCurrentIndex(25);
        self::assertSame(25, $step->getCurrentIndex());
    }

    private function getInstance() : Step
    {
        $currentIndex = 15;
        $stepCount = 0;
        $maxSteps = 5;

        return new Step($currentIndex, $stepCount, $maxSteps);
    }
}