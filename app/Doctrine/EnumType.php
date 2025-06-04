<?php

namespace App\Doctrine;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class EnumType extends Type
{
    const ENUM = 'enum';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        // Use 'values' key, which Laravel provides for enum columns
        if (!isset($fieldDeclaration['values']) || !is_array($fieldDeclaration['values'])) {
            throw new \InvalidArgumentException('Enum values must be provided in the field declaration.');
        }

        $values = array_map(function ($val) {
            return "'" . $val . "'";
        }, $fieldDeclaration['values']);

        return "ENUM(" . implode(", ", $values) . ")";
    }

    public function getName()
    {
        return self::ENUM;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }
}
