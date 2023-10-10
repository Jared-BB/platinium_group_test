<?php

declare(strict_types=1);

namespace App\Application\Event\Bid;

use App\Application\EventInterface;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

/**
 * Bid has been created
 *
 * @author Jared Barber
 */
final class BidCreatedEvent implements EventInterface
{
    public function __construct(
        public readonly Uuid $bidId,
        public readonly DateTimeImmutable $occurredAt = new DateTimeImmutable(),
    ) {
    }

    public function occurredAt(): DateTimeImmutable
    {
        return $this->occurredAt;
    }
}
