<?php

declare(strict_types=1);

namespace App\Account\Infrastructure\Persistence\Doctrine\Type;

use App\Account\Domain\Id;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\StringType;

final class IdType extends StringType
{
    public function convertToPHPValue($value, AbstractPlatform $platform): ?Id
    {
        if ($value === null) {
            return null;
        }

        return new Id((string)$value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof Id || is_string($value)) {
            return (string)$value;
        }

        throw ConversionException::conversionFailedInvalidType(
            $value,
            $this->getName(),
            ['null', Id::class],
        );
    }

    public function getName(): string
    {
        return 'account_id';
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
