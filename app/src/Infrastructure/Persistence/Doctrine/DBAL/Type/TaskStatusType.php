<?php

declare(strict_types=1);

namespace TaskManager\Infrastructure\Persistence\Doctrine\DBAL\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use TaskManager\Domain\ValueObject\TaskStatus;

class TaskStatusType extends StringType
{
    /**
     * @param TaskStatus $value
     * @param AbstractPlatform $platform
     * @return string|null
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (!$value) {
            return null;
        }

        return (string) $value;
    }

    /**
     * @param string|null $value
     * @param AbstractPlatform $platform
     * @return TaskStatus|null
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?TaskStatus
    {
        if (!$value) {
            return null;
        }
        return new TaskStatus($value);
    }
}
