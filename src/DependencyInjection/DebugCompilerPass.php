<?php

declare(strict_types=1);

namespace PanicLabCore\DependencyInjection;

use PanicLabCore\Services\CalcService;
use PanicLabCore\Services\Debug\DebugCalcService;
use PanicLabCore\Services\Debug\Log\DebugLogger;
use PanicLabCore\Services\Handlers\TileHandlerCollector;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class DebugCompilerPass implements CompilerPassInterface
{
    /** @var string */
    private $environment;

    public function __construct(string $environment)
    {
        $this->environment = $environment;
    }

    /**
     * Overwrites the `CalcService` with its respective debug version `DebugCalcService`
     */
    public function process(ContainerBuilder $container): void
    {
        if ($this->environment !== 'dev') {
            return;
        }

        $serviceId = CalcService::class;
        $debugService = new Definition(
            DebugCalcService::class,
            [
                new Reference(DebugLogger::class),
                $container->getDefinition(TileHandlerCollector::class),
                $container->getParameter('max_steps'),
            ]
        );

        $container->setDefinition($serviceId, $debugService);
    }
}
