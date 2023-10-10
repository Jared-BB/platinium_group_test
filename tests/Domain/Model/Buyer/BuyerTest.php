<?php

declare(strict_types=1);

namespace App\Tests\Domain\Model\Buyer;

use App\Application\Event\Buyer\BuyerCreatedEvent;
use App\Domain\EventStore;
use App\Domain\Model\Buyer\Buyer;
use App\Domain\Model\Buyer\Name;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

/**
 * Buyer Test
 *
 * @author Jared Barber
 *
 * @covers \App\Domain\Model\Buyer\Buyer
 */
class BuyerTest extends TestCase
{
    public function testBuyerProperties(): void
    {
        $id = Uuid::v1();
        $name = new Name('Buyer name');

        $buyer = new Buyer($id, $name);

        self::assertSame($buyer->id(), $id);
        self::assertSame($buyer->name(), $name);
        self::assertNotNull($buyer->createdAt());
        self::assertEmpty($buyer->bids()->toArray());
        self::assertInstanceOf(BuyerCreatedEvent::class, EventStore::events()[0]);
    }
}
