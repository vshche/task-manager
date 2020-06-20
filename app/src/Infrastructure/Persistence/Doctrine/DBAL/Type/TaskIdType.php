<?php

declare(strict_types=1);

namespace TaskManager\Infrastructure\Persistence\Doctrine\DBAL\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Ramsey\Uuid\Doctrine\UuidType;
use Ramsey\Uuid\UuidInterface;
use TaskManager\Domain\ValueObject\TaskId;

class TaskIdType extends UuidType
{
    public const NAME = 'task_id';

    /**
     * @param UuidInterface|string|null $value
     * @param AbstractPlatform                       $platform
     * @return TaskId
     * @throws ConversionException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?TaskId
    {
        $uuidOrNul = parent::convertToPHPValue($value, $platform);

        if ($uuidOrNul !== null) {
            return TaskId::fromString((string) $uuidOrNul);
        }

        return null;
    }
}
