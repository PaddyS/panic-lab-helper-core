<?php

declare(strict_types=1);

namespace PanicLabCore\Services\Handlers;

use PanicLabCore\Structs\Step;
use PanicLabCore\Structs\Target;

class TileHandlerCollector implements TileHandlerCollectorInterface
{
    /** @var \Traversable */
    private $tileHandlers;

    public function __construct(\Traversable $tileHandlers)
    {
        $this->tileHandlers = $tileHandlers;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(array $tiles, Target $target, Step $stepStruct): void
    {
        /** @var TileHandlerInterface $tileHandler */
        foreach ($this->tileHandlers as $tileHandler) {
            $tile = $tiles[$stepStruct->getCurrentIndex()];
            if (!$tileHandler->supports($tile)) {
                continue;
            }

            $tileHandler->handle($tiles, $target, $stepStruct);
        }
    }
}
