<?php

declare(strict_types=1);

namespace App\Domain\Model\Product\Exception;

use Exception;
use Symfony\Component\Uid\Uuid;

/**
 * @author Jared Barber
 */
class ProductNotFoundException extends Exception
{
    public static function becauseDoesNotExists(Uuid $productId): self
    {
        return new self("Product not found by: {$productId}");
    }
}