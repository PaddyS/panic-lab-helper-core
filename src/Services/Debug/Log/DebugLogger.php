<?php

declare(strict_types=1);

namespace PanicLabCore\Services\Debug\Log;

use function json_encode;
use Psr\Log\LoggerInterface;

class DebugLogger implements DebugLoggerInterface
{
    /** @var LoggerInterface */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function logBefore(string $method, array $params): void
    {
        $this->logger->info(
            'Before \'' . $method . '\' with params: ' . json_encode($params)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function logAfter(string $method, array $result): void
    {
        $this->logger->info(
            'After \'' . $method . '\' with result: ' . json_encode($result)
        );
    }
}
