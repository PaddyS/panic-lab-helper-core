<?php

declare(strict_types=1);

namespace PanicLabCore\Services\Debug\Log;

use Psr\Log\LoggerInterface;
use function json_encode;

class DebugLogger implements DebugLoggerInterface
{
    /** @var LoggerInterface */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * {@inheritDoc}
     */
    public function logBefore(string $method, array $params) : void
    {
        $this->logger->info(
            'Before \'' . $method . '\' with params: ' . json_encode($params)
        );
    }

    /**
     * {@inheritDoc}
     */
    public function logAfter(string $method, array $result) : void
    {
        $this->logger->info(
            'After \'' . $method . '\' with result: ' . json_encode($result)
        );
    }
}
