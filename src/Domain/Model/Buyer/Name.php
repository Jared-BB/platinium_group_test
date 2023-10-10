<?php

declare(strict_types=1);

namespace App\Domain\Model\Buyer;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * Buyer Name VO
 *
 * @author Jared Barber
 */
#[ORM\Embeddable]
final class Name
{
    public const MIN_LENGTH = 3;
    public const MAX_LENGTH = 50;

    #[ORM\Column(name: 'name', type: 'string', nullable: false)]
    private string $name;

    public function __construct(string $name)
    {
        Assert::lengthBetween($name, self::MIN_LENGTH, self::MAX_LENGTH);
        $this->name = $name;
    }

    public function asString(): string
    {
        return $this->name;
    }
}