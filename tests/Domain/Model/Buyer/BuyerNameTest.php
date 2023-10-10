<?php

declare(strict_types=1);

namespace App\Tests\Domain\Model\Buyer;

use App\Domain\Model\Buyer\Name;
use PHPUnit\Framework\TestCase;
use Exception;

/**
 * Buyer Name Test
 *
 * @author Jared Barber
 *
 * @covers \App\Domain\Model\Buyer\Name
 */
class BuyerNameTest extends TestCase
{
    public function testCorrectValidName(): void
    {
        $value = 'Buyer name';
        $name = new Name($value);
        self::assertSame($name->asString(), $value);
    }

    public function testShortInvalidName(): void
    {
        $this->expectException(Exception::class);
        new Name('B');
    }

    public function testBigInvalidName(): void
    {
        $this->expectException(Exception::class);
        new Name(str_repeat('A', 100));
    }
}
