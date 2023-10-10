<?php

declare(strict_types=1);

namespace App\Tests\Domain\Model\Bid;

use App\Application\Event\Bid\BidCreatedEvent;
use App\Domain\EventStore;
use App\Domain\Model\Bid\Bid;
use App\Domain\Model\Buyer\Buyer;
use App\Domain\Model\Buyer\Name as BuyerName;
use App\Domain\Model\Product\Name as ProductName;
use App\Domain\Model\Product\Product;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

/**
 * Bid Test
 *
 * @author Jared Barber
 *
 * @covers \App\Domain\Model\Bid\Bid
 */
class BidTest extends TestCase
{
    public function testBidProperties(): void
    {
        $id = Uuid::v1();
        $buyer = new Buyer(Uuid::v1(), new BuyerName('Buyer name'));
        $product = new Product(Uuid::v1(), new ProductName('Buyer name'), 100);
        $amount = 110.05;

        $bid = new Bid(
            $id,
            $buyer,
            $product,
            $amount
        );

        self::assertSame($bid->id(), $id);
        self::assertSame($bid->buyer(), $buyer);
        self::assertSame($bid->product(), $product);
        self::assertSame($bid->bid(), $amount);
        self::assertNotNull($bid->createdAt());
        self::assertInstanceOf(BidCreatedEvent::class, EventStore::events()[2]);
    }
}
