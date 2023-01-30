<?php

declare(strict_types=1);

namespace Tests\Karma8\SubscriptionNotifier;

class Random
{
    public static function boolean(): bool
    {
        return (bool) random_int(0, 1);
    }

    public static function int(int $digits = 6): int
    {
        return random_int(10 ** ($digits - 1), (10 ** $digits) - 1);
    }

    public static function string(int $length = 10): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return array_reduce(
            range(1, $length),
            static function (string $result) use ($characters): string {
                return $result . $characters[random_int(0, strlen($characters) - 1)];
            },
            '',
        );
    }

    public static function float(int $precision = 2, int $digits = null): float
    {
        $value = round(random_int(1, (10 ** $precision) - 1) / (10 ** $precision), $precision);

        if ((null !== $digits) && ($digits > $precision)) {
            $value += self::int($digits - $precision);
        }

        return $value;
    }

    public static function email(string $domain = 'test.karma8.com'): string
    {
        return sprintf('%s@%s', self::string(), $domain);
    }

    public static function associativeArray(int $elements = null): array
    {
        if ((null === $elements) || ($elements <= 0)) {
            return self::associativeArray(self::int(1));
        }

        return array_reduce(
            range(1, $elements),
            static function (array $result): array {
                $result[self::string()] = self::string();

                return $result;
            },
            [],
        );
    }

    public static function arraySubset(array $values, int $min = 1, int $max = null): array
    {
        return array_map(
            static fn ($key) => $values[$key],
            (array) array_rand($values, random_int($min, $max ?? count($values))),
        );
    }

    public static function range(int $min = 0, int $max = 9): array
    {
        return range($min, random_int($min, $max));
    }

    /**
     * @return mixed
     */
    public static function fromArray(array $values)
    {
        $key = array_rand($values, 1);

        return $values[$key];
    }

    public static function ip(): string
    {
        return sprintf('%d.%d.%d.%d', random_int(1, 255), random_int(0, 255), random_int(0, 255), random_int(0, 255));
    }
}
