<?php

declare(strict_types=1);

namespace PanicLabCore\Services\Handlers;

use PanicLabCore\Structs\Step;
use PanicLabCore\Structs\Target;
use Traversable;
use function iterator_to_array;

class TileHandlerCollector implements TileHandlerCollectorInterface
{
    /** @var TileHandlerInterface[] */
    private $tileHandlers;

    public function __construct(Traversable $tileHandlers)
    {
        $this->tileHandlers = iterator_to_array($tileHandlers, false);
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
