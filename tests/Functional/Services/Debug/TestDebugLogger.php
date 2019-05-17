<?php declare(strict_types=1);

namespace PanicLabCore\Tests\Functional\Services\Debug;

use PanicLabCore\Services\Debug\Log\DebugLogger;

class TestDebugLogger extends DebugLogger
{
    public $beforeLogs = [];
    public $afterLogs = [];

    public function __construct()
    {
    }

    public function logBefore(string $method, array $params): void
    {
        $this->beforeLogs[$method][] = $params;
    }

    public function logAfter(string $method, array $result): void
    {
        $this->afterLogs[$method][] = $result;
    }
}