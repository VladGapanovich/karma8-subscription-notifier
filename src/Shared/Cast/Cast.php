<?php

declare(strict_types=1);

namespace Karma8\SubscriptionNotifier\Shared\Cast;

use DateInterval;
use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Decimal\Decimal;
use LogicException;
use Stringable;
use Throwable;

final class Cast
{
    public static function string(mixed $value): string
    {
        if (is_scalar($value) || $value instanceof Stringable) {
            return (string) $value;
        }

        throw new InvalidTypeException('string', gettype($value));
    }

    public static function int(mixed $value): int
    {
        if (true === $value || false === $int = filter_var($value, FILTER_VALIDATE_INT)) {
            throw new InvalidTypeException('int', gettype($value));
        }

        return $int;
    }

    public static function float(mixed $value): float
    {
        if (class_exists(Decimal::class) && $value instanceof Decimal) {
            return $value->toFloat();
        }

        if (true === $value || false === $float = filter_var($value, FILTER_VALIDATE_FLOAT)) {
            throw new InvalidTypeException('float', gettype($value));
        }

        return $float;
    }

    /**
     * @see bool()
     */
    public static function boolean(mixed $value): bool
    {
        return self::bool($value);
    }

    public static function bool(mixed $value): bool
    {
        if (null === $value || null === $bool = filter_var($value, FILTER_VALIDATE_BOOL, FILTER_NULL_ON_FAILURE)) {
            throw new InvalidTypeException('bool', gettype($value));
        }

        return $bool;
    }

    /**
     * @return array<array-key, mixed>
     */
    public static function array(mixed $value): array
    {
        if (is_array($value)) {
            return $value;
        }

        if (is_iterable($value)) {
            return iterator_to_array($value);
        }

        throw new InvalidTypeException('array|iterable', gettype($value));
    }

    public static function dateTimeImmutable(mixed $value, mixed $rawDateTimeZone = null): DateTimeImmutable
    {
        $dateTimeZone = null !== $rawDateTimeZone ? self::dateTimeZone($rawDateTimeZone) : null;

        if ($value instanceof DateTimeInterface) {
            $dateTime = DateTimeImmutable::createFromInterface($value);

            return null === $dateTimeZone ? $dateTime : $dateTime->setTimezone($dateTimeZone);
        }

        try {
            return new DateTimeImmutable(self::string($value), $dateTimeZone);
        } catch (Throwable) {
            throw new InvalidTypeException('DateTime string', gettype($value));
        }
    }

    public static function dateTimeZone(mixed $value): DateTimeZone
    {
        if ($value instanceof DateTimeZone) {
            return $value;
        }

        try {
            return new DateTimeZone(self::string($value));
        } catch (Throwable) {
            throw new InvalidTypeException('DateTimeZone string', gettype($value));
        }
    }

    public static function dateInterval(mixed $value): DateInterval
    {
        if ($value instanceof DateInterval) {
            return $value;
        }

        try {
            return new DateInterval(self::string($value));
        } catch (Throwable) {
            throw new InvalidTypeException('DateInterval string', gettype($value));
        }
    }

    public static function decimal(mixed $value): Decimal
    {
        if (!class_exists(Decimal::class)) {
            throw new LogicException('You can not use the "decimal" method if the Decimal package is not available. Try running "composer require php-decimal/php-decimal".');
        }

        try {
            return ($value instanceof Decimal) ? $value : new Decimal((string) self::float($value));
        } catch (Throwable) {
            throw new InvalidTypeException('Decimal string', gettype($value));
        }
    }
}
