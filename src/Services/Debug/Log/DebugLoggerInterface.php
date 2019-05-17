<?php

declare(strict_types=1);

namespace PanicLabCore\Services\Debug\Log;

interface DebugLoggerInterface
{
    /**
     * @param mixed[] $params
     */
    public function logBefore(string $method, array $params) : void;

    /**
     * @param mixed[] $result
     */
    public function logAfter(string $method, array $result) : void;
}
