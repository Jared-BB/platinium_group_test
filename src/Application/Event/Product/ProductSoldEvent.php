<?php

declare(strict_types=1);

namespace App\Application\Event\Product;

use App\Application\EventInterface;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

/**
 * Product has been sold
 *
 * @author Jared Barber
 */
final class ProductSoldEvent implements EventInterface
{
    public function __construct(
        public readonly Uuid $productId,
        public readonly DateTimeImmutable $occurredAt = new DateTimeImmutable(),
    ) {
    }

    public function occurredAt(): DateTimeImmutable
    {
        return $this->occurredAt;
    }
}
