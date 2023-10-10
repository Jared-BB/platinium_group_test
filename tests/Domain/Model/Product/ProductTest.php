<?php

declare(strict_types=1);

namespace App\Tests\Domain\Model\Product;

use App\Application\Event\Product\ProductCreatedEvent;
use App\Application\Event\Product\ProductSoldEvent;
use App\Domain\EventStore;
use App\Domain\Model\Buyer\Buyer;
use App\Domain\Model\Buyer\Name as BuyerName;
use App\Domain\Model\Product\Name as ProductName;
use App\Domain\Model\Product\Product;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

/**
 * Product Test
 *
 * @author Jared Barber
 *
 * @covers \App\Domain\Model\Product\Product
 */
class ProductTest extends TestCase
{
    public function setUp(): void
    {
        EventStore::clear();
    }

    public function tearDown(): void
    {
        EventStore::clear();
    }

    public function testProductProperties(): void
    {
        $id = Uuid::v1();
        $name = new ProductName('Product name');
        $reservePrice = 100.00;

        $product = new Product($id, $name, $reservePrice);

        self::assertSame($product->id(), $id);
        self::assertSame($product->name(), $name);
        self::assertSame($product->reservePrice(), $reservePrice);
        self::assertNull($product->soldTo());
        self::assertNotNull($product->createdAt());
        self::assertEmpty($product->bids()->toArray());
        self::assertInstanceOf(ProductCreatedEvent::class, EventStore::events()[0]);
    }

    public function testCalculateAuctionResultWithNoBids(): void
    {
        $product = new Product(Uuid::v1(), new ProductName('Product name'), 100);

        $product->calculateAuctionResult();

        self::assertNull($product->soldTo());
        self::assertNull($product->finalPrice());
    }

    public function testCalculateAuctionResultWithALowerBid(): void
    {
        $product = new Product(Uuid::v1(), new ProductName('Product name'), 100);

        $buyer_A = new Buyer(Uuid::v1(), new BuyerName('Buyer name A'));
        $product->newBid($buyer_A, 90);

        $product->calculateAuctionResult();

        self::assertNull($product->soldTo());
        self::assertNull($product->finalPrice());
    }

    public function testCalculateAuctionResultWithAValidWinner(): void
    {
        $product = new Product(Uuid::v1(), new ProductName('Product name'), 100);

        $buyer_A = new Buyer(Uuid::v1(), new BuyerName('Buyer name A'));
        $buyer_C = new Buyer(Uuid::v1(), new BuyerName('Buyer name C'));
        $buyer_D = new Buyer(Uuid::v1(), new BuyerName('Buyer name D'));
        $buyer_E = new Buyer(Uuid::v1(), new BuyerName('Buyer name E'));

        $product->newBid($buyer_A, 110);
        $product->newBid($buyer_A, 130);
        $product->newBid($buyer_C, 125);
        $product->newBid($buyer_D, 105);
        $product->newBid($buyer_D, 115);
        $product->newBid($buyer_D, 90);
        $product->newBid($buyer_E, 132);
        $product->newBid($buyer_E, 135);
        $product->newBid($buyer_E, 140);

        $product->calculateAuctionResult();

        self::assertSame($product->soldTo(), $buyer_E);
        self::assertSame($product->finalPrice(), 130.00);

        $productSoldEvent = array_filter(EventStore::events(), fn ($event) => $event instanceof ProductSoldEvent);
        self::assertNotEmpty($productSoldEvent);
    }

    public function testCalculateAuctionResultWithAValidWinnerButNonHighSecondaryBid(): void
    {
        $product = new Product(Uuid::v1(), new ProductName('Product name'), 100);

        $buyer_A = new Buyer(Uuid::v1(), new BuyerName('Buyer name A'));

        $product->newBid($buyer_A, 110);

        $product->calculateAuctionResult();

        self::assertSame($product->soldTo(), $buyer_A);
        self::assertSame($product->finalPrice(), 100.00);

        $productSoldEvent = array_filter(EventStore::events(), fn ($event) => $event instanceof ProductSoldEvent);
        self::assertNotEmpty($productSoldEvent);
    }
}
