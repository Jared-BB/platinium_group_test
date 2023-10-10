<?php

declare(strict_types=1);

namespace App\Domain\Model\Product;

use App\Application\Event\Product\ProductCreatedEvent;
use App\Application\Event\Product\ProductSoldEvent;
use App\Domain\EventStore;
use App\Domain\Model\Bid\Bid;
use App\Domain\Model\Buyer\Buyer;
use App\Infrastructure\Persistence\Doctrine\Repository\Product\MysqlProductRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * Product Entity Model
 *
 * @author Jared Barber
 */
#[ORM\Entity(repositoryClass: MysqlProductRepository::class)]
#[ORM\Table(name: 'product')]
class Product
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: 'uuid', unique: true)]
    private Uuid $id;

    #[ORM\Embedded(class: Name::class, columnPrefix: false)]
    private Name $name;

    #[ORM\Column(name: 'reserve_price', type: 'float')]
    private float $reservePrice;

    #[ORM\Column(name: 'final_price', type: 'float', nullable: true)]
    private ?float $finalPrice = null;

    #[ORM\ManyToOne(targetEntity: Buyer::class)]
    #[ORM\JoinColumn(name: 'sold_to', referencedColumnName: 'id')]
    private ?Buyer $soldTo = null;

    #[ORM\Column(name: 'created_at', type: 'datetime_immutable')]
    private DateTimeImmutable $createdAt;

    #[ORM\OneToMany(targetEntity: Bid::class, mappedBy: 'product')]
    #[ORM\JoinColumn(name: 'id', referencedColumnName: 'product_id')]
    private Collection $bids;

    public function __construct(Uuid $id, Name $name, float $reservePrice)
    {
        $this->id           = $id;
        $this->name         = $name;
        $this->reservePrice = $reservePrice;
        $this->createdAt    = new DateTimeImmutable();
        $this->bids         = new ArrayCollection();

        EventStore::addEvent(
            new ProductCreatedEvent(
                $this->id,
            )
        );
    }

    public function id(): Uuid
    {
        return $this->id;
    }

    public function name(): Name
    {
        return $this->name;
    }

    public function reservePrice(): float
    {
        return $this->reservePrice;
    }

    public function finalPrice(): ?float
    {
        return $this->finalPrice;
    }

    public function isSold(): bool
    {
        return $this->soldTo !== null;
    }

    public function soldTo(): ?Buyer
    {
        return $this->soldTo;
    }

    public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function bids(): Collection
    {
        return $this->bids;
    }

    public function newBid(Buyer $buyer, float $bid): void
    {
        $this->bids->add(
            new Bid(
                Uuid::v1(),
                $buyer,
                $this,
                $bid,
            )
        );
    }

    public function calculateAuctionResult(): void
    {
        // gets only bids that are higher than the reserve price
        $highestBids = array_filter($this->bids->toArray(), fn ($bid) => $bid->bid() >= $this->reservePrice);

        // sorts bids by highest amount
        usort($highestBids, function (Bid $a, Bid $b) {
            return $a->bid() > $b->bid() ? -1 : 1;
        });

        /** @var Bid $winner */
        $winner = array_shift($highestBids);

        if ($winner !== null) {
            // gets the next highest bid that dont belong to the winner
            /** @var Bid $nextHighestBids */
            $nextHighestBids = array_filter($highestBids, fn ($bid) => $bid->buyer() !== $winner->buyer());
            $lastBidNoWinner = array_shift($nextHighestBids);

            if ($lastBidNoWinner !== null) {
                $this->sell($winner->buyer(), $lastBidNoWinner->bid());
            } else {
                $this->sell($winner->buyer(), $this->reservePrice);
            }
        }
    }

    private function sell(Buyer $buyer, float $finalPrice): void
    {
        $this->soldTo     = $buyer;
        $this->finalPrice = $finalPrice;

        EventStore::addEvent(
            new ProductSoldEvent(
                $this->id,
            )
        );
    }
}
