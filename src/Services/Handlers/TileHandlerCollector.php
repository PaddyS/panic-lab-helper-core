<?php

declare(strict_types=1);

namespace PanicLabCore\Services\Handlers;

use PanicLabCore\Structs\Step;
use PanicLabCore\Structs\Target;
use Traversable;

class TileHandlerCollector implements TileHandlerCollectorInterface
{
    /** @var TileHandlerInterface[] */
    private $tileHandlers;

    public function __construct(Traversable $tileHandlers)
    {
        $this->tileHandlers = $tileHandlers;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(array $tiles, Target $target, Step $stepStruct) : void
    {
        foreach ($this->tileHandlers as $tileHandler) {
            $tile = $tiles[$stepStruct->getCurrentIndex()];
            if (! $tileHandler->supports($tile)) {
                continue;
            }

            $tileHandler->handle($tiles, $target, $stepStruct);
        }
    }
}
