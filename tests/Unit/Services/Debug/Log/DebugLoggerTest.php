<?php declare(strict_types=1);

namespace PanicLabCore\Tests\Unit\Services\Debug\Log;

use PanicLabCore\Services\Debug\Log\DebugLogger;
use PHPUnit\Framework\TestCase;

class DebugLoggerTest extends TestCase
{
    public function testLogBefore() : void
    {
        $testMonologLogger = new TestLogger();
        $debugLogger = $this->getInstance($testMonologLogger);
        $debugLogger->logBefore('foo', ['foo' => 'bar']);

        self::assertCount(1, $testMonologLogger->loggedStrings);
        self::assertSame('Before \'foo\' with params: {"foo":"bar"}', $testMonologLogger->loggedStrings[0]);
    }

    public function testLogAfter() : void
    {
        $testMonologLogger = new TestLogger();
        $debugLogger = $this->getInstance($testMonologLogger);
        $debugLogger->logAfter('foo', ['foo' => 'bar']);

        self::assertCount(1, $testMonologLogger->loggedStrings);
        self::assertSame('After \'foo\' with result: {"foo":"bar"}', $testMonologLogger->loggedStrings[0]);
    }

    private function getInstance(TestLogger $testLogger): DebugLogger
    {
        return new DebugLogger($testLogger);
    }
}