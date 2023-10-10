<?php

declare(strict_types=1);

namespace App\Domain;

use App\Application\EventInterface;

/**
 * @author Jared Barber
 */
class EventStore
{
    private static array $events = [];

    public static function addEvent(EventInterface $event): void
    {
        static::$events[] = $event;
    }

    public static function events(): array
    {
        return self::$events;
    }

    public static function clear(): void
    {
        static::$events = [];
    }
}