<?php

declare(strict_types=1);

namespace App\Application\Event\Buyer;

use App\Application\EventInterface;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

/**
 * Buyer has been created
 *
 * @author Jared Barber
 */
final class BuyerCreatedEvent implements EventInterface
{
    public function __construct(
        public readonly Uuid $buyerId,
        public readonly DateTimeImmutable $occurredAt = new DateTimeImmutable(),
    ) {
    }

    public function occurredAt(): DateTimeImmutable
    {
        return $this->occurredAt;
    }
}
