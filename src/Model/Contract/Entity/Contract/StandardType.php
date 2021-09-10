<?php

declare(strict_types=1);

namespace App\Model\Contract\Entity\Contract;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class StandardType extends StringType
{
    public const NAME = 'contract_contract_standard';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof Standard ? $value->getValue() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return !empty($value) ? new Standard($value) : null;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform) : bool
    {
        return true;
    }
}
