<?php

declare(strict_types=1);

namespace App\Application;

use DateTimeImmutable;

/**
 * @author Jared Barber
 */
interface EventInterface
{
    public function occurredAt(): DateTimeImmutable;
}