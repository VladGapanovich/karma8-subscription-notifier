<?php

declare(strict_types=1);

namespace Tests\Karma8\SubscriptionNotifier\User\Model;

use Generator;
use Karma8\SubscriptionNotifier\Shared\Assert\ValidationFailedException;
use Karma8\SubscriptionNotifier\User\Domain\Model\Name;
use PHPUnit\Framework\TestCase;

final class NameTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider validNameValueDataProvider
     */
    public function name_creates_with_valid_value(string $value, string $expectedValue): void
    {
        $sut = new Name($value);

        self::assertSame($expectedValue, $sut->value);
    }

    /**
     * @test
     *
     * @dataProvider invalidNameValueDataProvider
     */
    public function name_does_not_create_with_invalid_value(string $value): void
    {
        $this->expectException(ValidationFailedException::class);

        new Name($value);
    }

    /**
     * @return Generator<array<int, string>>
     */
    public function validNameValueDataProvider(): Generator
    {
        yield 'name from 1 character' => ['1', '1'];

        yield 'name with space at the end' => ['1 ', '1'];

        yield 'name with space at the start' => [' This is quite long name', 'This is quite long name'];

        yield 'name with space at the start and end' => [' This is quite long name ', 'This is quite long name'];
    }

    /**
     * @return Generator<array<int, string>>
     */
    public function invalidNameValueDataProvider(): Generator
    {
        yield 'empty name' => [''];

        yield 'name consists of spaces only' => ['   '];
    }
}
