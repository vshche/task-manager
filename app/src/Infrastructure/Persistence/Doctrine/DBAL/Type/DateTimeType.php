<?php

declare(strict_types=1);

namespace TaskManager\Infrastructure\Persistence\Doctrine\DBAL\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\DateTimeImmutableType;
use TaskManager\Domain\ValueObject\DateTime;

class DateTimeType extends DateTimeImmutableType
{
    /**
     * @param DateTime|null $value
     * @param AbstractPlatform $platform
     * @return string|null
     * @throws ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return parent::convertToDatabaseValue($value ? $value->toNative() : null, $platform);
    }

    /**
     * @param string|null            $value
     * @param AbstractPlatform $platform
     * @return DateTime|null
     * @throws ConversionException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?DateTime
    {
        $dateTimeOrNull = parent::convertToPHPValue($value, $platform);

        return $dateTimeOrNull ? new DateTime($dateTimeOrNull) : null;
    }
}
