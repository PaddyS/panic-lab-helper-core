<?php

declare(strict_types=1);

namespace PanicLabCore\Services\Hydrators;

use PanicLabCore\Services\Exceptions\InvalidTileTypeException;
use PanicLabCore\Structs\Tile;
use Traversable;
use Webmozart\Assert\Assert;
use function iterator_to_array;
use function sprintf;

class HydrationCollector implements HydrationCollectorInterface
{
    /** @var HydratorInterface[] */
    private $tileHydrators;

    public function __construct(Traversable $tileHydrators)
    {
        $this->tileHydrators = iterator_to_array($tileHydrators, false);
    }

    public function supports(string $type) : bool
    {
        // Nothing to be done here
        return true;
    }

    public function hydrate(array $tile) : Tile
    {
        $this->validate($tile);

        foreach ($this->tileHydrators as $tileHydrator) {
            if (! $tileHydrator->supports($tile['type'])) {
                continue;
            }

            $tileHydrator->validate($tile);

            return $tileHydrator->hydrate($tile);
        }

        throw new InvalidTileTypeException(
            sprintf(
                'The provided type \'%s\’ seems to be invalid. No matching hydrator found.',
                $tile['type']
            )
        );
    }

    public function validate(array $tile) : void
    {
        Assert::keyExists($tile, 'type');
    }
}
