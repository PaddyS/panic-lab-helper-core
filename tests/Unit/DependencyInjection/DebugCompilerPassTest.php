<?php declare(strict_types=1);

namespace PanicLabCore\Tests\Unit\DependencyInjection;

use PanicLabCore\DependencyInjection\DebugCompilerPass;
use PanicLabCore\Services\CalcService;
use PanicLabCore\Services\Debug\DebugCalcService;
use PanicLabCore\Services\Handlers\EntryTileHandler;
use PanicLabCore\Services\Handlers\TileHandlerCollector;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class DebugCompilerPassTest extends TestCase
{
    public function testProcessRewritesCalcServiceDevEnv() : void
    {
        $compilerPass = $this->getInstance();
        $containerBuilder = $this->createContainerBuilder();

        $compilerPass->process($containerBuilder);

        $calcService = $containerBuilder->getDefinition(CalcService::class);

        self::assertSame(DebugCalcService::class, $calcService->getClass());
    }

    public function testProcessDoesNotRewriteCalcServiceDevProd() : void
    {
        $compilerPass = $this->getInstance('prod');
        $containerBuilder = $this->createContainerBuilder();

        $compilerPass->process($containerBuilder);

        $calcService = $containerBuilder->getDefinition(CalcService::class);

        self::assertSame(CalcService::class, $calcService->getClass());
    }

    private function getInstance($environment = 'dev'): DebugCompilerPass
    {
        return new DebugCompilerPass($environment);
    }

    private function createContainerBuilder() : ContainerBuilder
    {
        $containerBuilder = new ContainerBuilder();

        $containerBuilder->setDefinition(
            TileHandlerCollector::class,
            new Definition(TileHandlerCollector::class, [
                new TaggedServices()
            ])
        );

        $containerBuilder->setParameter('max_steps', 10000);
        $containerBuilder->setDefinition(
            CalcService::class,
            new Definition(
                CalcService::class,
                [
                    $containerBuilder->getParameter('max_steps'),
                    $containerBuilder->getDefinition(TileHandlerCollector::class)
                ]
            )
        );

        return $containerBuilder;
    }
}

class TaggedServices implements \IteratorAggregate
{
    public function getIterator() : ?\Traversable
    {
        return new \ArrayIterator([
            new EntryTileHandler()
        ]);
    }
}