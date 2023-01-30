<?php

declare(strict_types=1);

namespace Tests\Karma8\SubscriptionNotifier\Shared\Model;

use Generator;
use Karma8\SubscriptionNotifier\Shared\Assert\ValidationFailedException;
use Karma8\SubscriptionNotifier\Shared\Model\Email;
use PHPUnit\Framework\TestCase;
use Tests\Karma8\SubscriptionNotifier\Random;

final class EmailTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider validEmailValueDataProvider
     */
    public function name_creates_with_valid_value(string $value, string $expectedValue): void
    {
        $sut = new Email($value);

        self::assertSame($expectedValue, $sut->value);
    }

    /**
     * @test
     *
     * @dataProvider invalidEmailValueDataProvider
     */
    public function name_does_not_create_with_invalid_value(string $value): void
    {
        $this->expectException(ValidationFailedException::class);

        new Email($value);
    }

    /**
     * @return Generator<array<int, string>>
     */
    public function validEmailValueDataProvider(): Generator
    {
        yield 'email with minimal length' => ['a@a.a', 'a@a.a'];

        yield 'email with plus and slug' => ['test+12@karma8.com', 'test+12@karma8.com'];

        yield 'email with space at the end' => ['test@karma8.com ', 'test@karma8.com'];

        yield 'email with space at the start' => [' test@karma8.com', 'test@karma8.com'];

        yield 'email with space at the start and end' => [' test@karma8.com ', 'test@karma8.com'];
    }

    /**
     * @return Generator<array<int, string>>
     */
    public function invalidEmailValueDataProvider(): Generator
    {
        yield 'empty email' => [''];

        yield 'email consists of spaces only' => ['   '];

        yield 'email of wrong format' => [Random::string()];

        yield 'email from at' => ['@'];

        yield 'email from 1 character' => ['a'];

        yield 'email from name and at' => ['a@'];

        yield 'email from at and domain name' => ['@a'];

        yield 'email without name' => ['@a.a'];

        yield 'email without name and top-level domain' => ['@a.'];

        yield 'email without domain name' => ['a@.a'];

        yield 'email without domain top-level domain' => ['a@a.'];

        yield 'email without domain top-level domain and dot' => ['a@a'];
    }
}
