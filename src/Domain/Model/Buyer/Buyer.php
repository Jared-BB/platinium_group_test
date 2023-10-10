<?php

declare(strict_types=1);

namespace App\Domain\Model\Buyer;

use App\Application\Event\Buyer\BuyerCreatedEvent;
use App\Domain\EventStore;
use App\Domain\Model\Bid\Bid;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * Buyer Entity Model
 *
 * @author Jared Barber
 */
#[ORM\Entity]
#[ORM\Table(name: 'buyer')]
class Buyer
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: 'uuid', unique: true)]
    private Uuid $id;

    #[ORM\Embedded(class: Name::class, columnPrefix: false)]
    private Name $name;

    #[ORM\Column(name: 'created_at', type: 'datetime_immutable')]
    private DateTimeImmutable $createdAt;

    #[ORM\OneToMany(targetEntity: Bid::class, mappedBy: 'buyer')]
    #[ORM\JoinColumn(name: 'id', referencedColumnName: 'buyer_id')]
    private Collection $bids;

    public function __construct(Uuid $id, Name $name)
    {
        $this->id        = $id;
        $this->name      = $name;
        $this->createdAt = new DateTimeImmutable();
        $this->bids      = new ArrayCollection();

        EventStore::addEvent(
            new BuyerCreatedEvent(
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

    public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function bids(): Collection
    {
        return $this->bids;
    }
}
