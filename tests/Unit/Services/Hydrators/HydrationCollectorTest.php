<?php declare(strict_types=1);

namespace PanicLabCore\Tests\Unit\Services\Hydrators;

use PanicLabCore\Services\Exceptions\InvalidTileTypeException;
use PanicLabCore\Services\Hydrators\HydrationCollector;
use PanicLabCore\Services\Hydrators\HydratorInterface;
use PanicLabCore\Services\Hydrators\SwitchHydrator;
use PanicLabCore\Services\Validators\SwitchValidator;
use PanicLabCore\Structs\SwitchTile;
use PanicLabCore\Structs\Tile;
use PanicLabCore\Structs\VentTile;
use PHPUnit\Framework\TestCase;

class HydrationCollectorTest extends TestCase
{
    public function testSupportsShouldAlwaysReturnTrue() : void
    {
        $hydrationCollector = $this->getInstance();
        self::assertTrue($hydrationCollector->supports('foo'));
    }

    public function testHydrateRedirectsToProperHydrator() : void
    {
        $hydrationCollector = $this->getInstance();

        $hydratedResult = $hydrationCollector->hydrate([
            'type' => 'switch',
            'additional' => [
                'type' => 'color'
            ]
        ]);

        self::assertInstanceOf(SwitchTile::class, $hydratedResult);
    }

    public function testHydrateSkipsInvalidHydrator() : void
    {
        $invalidHydrator = new InvalidHydratorMock();

        $hydrationCollector = $this->getInstance([ $invalidHydrator ]);

        $hydrationCollector->hydrate([
            'type' => 'switch',
            'additional' => [
                'type' => 'color'
            ]
        ]);

        self::assertTrue($invalidHydrator->supportChecked);
    }

    public function testHydrateShouldThrowExceptionInvalidTileType() : void
    {
        $hydrationCollector = $this->getInstance();

        $this->expectException(InvalidTileTypeException::class);
        $this->expectExceptionMessage('The provided type \'invalid\’ seems to be invalid. No matching hydrator found.');

        $hydrationCollector->hydrate([
            'type' => 'invalid'
        ]);
    }

    public function testThrowsExceptionTypeMissing() : void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected the key "type" to exist.');


        $this->getInstance()->validate([
            'notType' => 'invalid'
        ]);
    }

    private function getInstance(array $additionalHydrators = []): HydrationCollector
    {
        $hydrators = [
            new SwitchHydrator(
                new SwitchValidator(['color', 'size', 'style'])
            )
        ];

        $hydrators = array_merge($additionalHydrators, $hydrators);

        return new HydrationCollector(
            new \ArrayIterator($hydrators)
        );
    }
}

class InvalidHydratorMock implements HydratorInterface
{
    public $supportChecked = false;

    public function supports(string $type): bool
    {
        $this->supportChecked = true;
        return false;
    }

    public function hydrate(array $tile): Tile
    {
        return new VentTile();
    }

    public function validate(array $tile): void
    {
    }
}