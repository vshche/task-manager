<?php

declare(strict_types=1);

namespace TaskManager\Domain\ValueObject;

use DateTime as PhpDateTime;
use DateTimeImmutable;
use TaskManager\Domain\Exception\DateTimeException;

final class DateTime
{
    private const FORMAT = 'Y-m-d H:i:s';

    private DateTimeImmutable $dateTime;

    /**
     * @param DateTimeImmutable $dateTime
     */
    public function __construct(DateTimeImmutable $dateTime)
    {
        $this->dateTime = $dateTime;
    }

    /**
     * @throws DateTimeException
     */
    public static function now(): self
    {
        return self::create();
    }

    /**
     * @param string $dateTime
     * @return DateTime
     * @throws DateTimeException
     */
    public static function fromString(string $dateTime): self
    {
        return self::create($dateTime);
    }

    /**
     * @param PhpDateTime $dateTime
     * @return $this
     */
    public static function fromDateTime(PhpDateTime $dateTime): self
    {
        return new self(DateTimeImmutable::createFromMutable($dateTime));
    }

    /**
     * @param string $dateTime
     * @return DateTime
     * @throws DateTimeException
     */
    private static function create(string $dateTime = 'now'): self
    {
        try {
            return new self(new DateTimeImmutable($dateTime));
        } catch (\Exception $e) {
            throw new DateTimeException($e);
        }
    }

    /**
     * @return DateTimeImmutable
     */
    public function toNative(): DateTimeImmutable
    {
        return $this->dateTime;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->dateTime->format(self::FORMAT);
    }
}
