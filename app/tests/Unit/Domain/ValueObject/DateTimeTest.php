<?php

declare(strict_types=1);

namespace TaskManager\Tests\Unit\Domain\ValueObject;

use DateTime as PhpDateTime;
use PHPUnit\Framework\TestCase;
use TaskManager\Domain\Exception\DateTimeException;
use TaskManager\Domain\ValueObject\DateTime;

class DateTimeTest extends TestCase
{
    public function testCreate(): void
    {
        $native = new \DateTimeImmutable();
        $vo = new DateTime($native);
        self::assertInstanceOf(DateTime::class, $vo);
        self::assertInstanceOf(\DateTimeInterface::class, $vo->toNative());
    }

    public function testNow(): void
    {
        $vo = DateTime::now();
        self::assertInstanceOf(DateTime::class, $vo);
    }

    /**
     * @param string $expected
     * @param string $dateTimeString
     *
     * @dataProvider fromStringDataProvider
     */
    public function testFromString(string $expected, string $dateTimeString): void
    {
        $vo = DateTime::fromString($dateTimeString);
        self::assertEquals($expected, (string) $vo);
    }

    public function testFromInvalidString(): void
    {
        $this->expectException(DateTimeException::class);
        DateTime::fromString('invalid string');
    }

    public function testFromDateTime(): void
    {
        $native = new PhpDateTime();
        $vo = DateTime::fromDateTime($native);
        self::assertEquals($native, $vo->toNative());
    }

    /**
     * @return iterable
     */
    public function fromStringDataProvider(): iterable
    {
        yield ['2020-01-01T00:00:00', '2020-01-01'];
        yield ['2020-01-01T00:00:00', '2020/01/01'];
        yield ['2020-01-01T12:12:12', '2020-01-01 12:12:12'];
    }
}
