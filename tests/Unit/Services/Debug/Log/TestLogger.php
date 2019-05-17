<?php declare(strict_types=1);

namespace PanicLabCore\Tests\Unit\Services\Debug\Log;

use Psr\Log\LoggerInterface;

class TestLogger implements LoggerInterface
{
    public $loggedStrings = [];

    public function info($message, array $context = array()): void
    {
        $this->loggedStrings[] = $message;
    }

    public function emergency($message, array $context = array()): void
    {
    }

    public function alert($message, array $context = array()): void
    {
    }

    public function critical($message, array $context = array()): void
    {
    }

    public function error($message, array $context = array()): void
    {
    }

    public function warning($message, array $context = array()): void
    {
    }

    public function notice($message, array $context = array()): void
    {
    }

    public function debug($message, array $context = array()): void
    {
    }

    public function log($level, $message, array $context = array()): void
    {
    }
}