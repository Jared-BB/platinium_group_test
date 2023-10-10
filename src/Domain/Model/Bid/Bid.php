<?php

declare(strict_types=1);

namespace App\Domain\Model\Bid;

use App\Application\Event\Bid\BidCreatedEvent;
use App\Domain\EventStore;
use App\Domain\Model\Buyer\Buyer;
use App\Domain\Model\Product\Product;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * Bid Entity Model
 *
 * @author Jared Barber
 */
#[ORM\Entity]
#[ORM\Table(name: 'bid')]
class Bid
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: 'uuid', unique: true)]
    private Uuid $id;

    #[ORM\ManyToOne(targetEntity: Buyer::class, inversedBy: 'bids')]
    #[ORM\JoinColumn(name: 'buyer_id', referencedColumnName: 'id')]
    private Buyer $buyer;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'bids')]
    #[ORM\JoinColumn(name: 'product_id', referencedColumnName: 'id')]
    private Product $product;

    #[ORM\Column(name: 'bid', type: 'float')]
    private float $bid;

    #[ORM\Column(name: 'created_at', type: 'datetime_immutable')]
    private DateTimeImmutable $createdAt;

    public function __construct(Uuid $id, Buyer $buyer, Product $product, float $bid)
    {
        $this->id        = $id;
        $this->buyer     = $buyer;
        $this->product   = $product;
        $this->bid       = $bid;
        $this->createdAt = new DateTimeImmutable();

        EventStore::addEvent(
            new BidCreatedEvent(
                $this->id,
            )
        );
    }

    public function id(): Uuid
    {
        return $this->id;
    }

    public function buyer(): Buyer
    {
        return $this->buyer;
    }

    public function product(): Product
    {
        return $this->product;
    }

    public function bid(): float
    {
        return $this->bid;
    }

    public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
