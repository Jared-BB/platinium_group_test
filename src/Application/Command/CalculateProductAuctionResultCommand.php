<?php

declare(strict_types=1);

namespace App\Application\Command;

use Symfony\Component\Uid\Uuid;

/**
 * @author Jared Barber
 */
final class CalculateProductAuctionResultCommand
{
    public function __construct(
        public readonly Uuid $productId,
    ) {
    }
}
