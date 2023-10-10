<?php

declare(strict_types=1);

namespace App\Tests\Domain\Model\Product\Exception;

use App\Domain\Model\Product\Exception\ProductNotFoundException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

/**
 * Product NotFoundException Test
 *
 * @author Jared Barber
 *
 * @covers \App\Domain\Model\Product\Exception\ProductNotFoundException
 */
class ProductNotFoundExceptionTest extends TestCase
{
    public function testExceptionThrown(): void
    {
        $this->expectException(ProductNotFoundException::class);
        throw ProductNotFoundException::becauseDoesNotExists(Uuid::v1());
    }
}