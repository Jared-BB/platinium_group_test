<?php

declare(strict_types=1);

namespace App\Tests\Domain\Model\Product;

use App\Domain\Model\Product\Name;
use PHPUnit\Framework\TestCase;
use Exception;

/**
 * Product Name Test
 *
 * @author Jared Barber
 *
 * @covers \App\Domain\Model\Product\Name
 */
class ProductNameTest extends TestCase
{
    public function testCorrectValidName(): void
    {
        $value = 'Product name';
        $name = new Name($value);
        self::assertSame($name->asString(), $value);
    }

    public function testShortInvalidName(): void
    {
        $this->expectException(Exception::class);
        new Name('SHORT');
    }

    public function testBigInvalidName(): void
    {
        $this->expectException(Exception::class);
        new Name(str_repeat('A', 150));
    }
}
