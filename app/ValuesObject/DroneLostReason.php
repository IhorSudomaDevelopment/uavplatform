<?php

namespace App\ValuesObject;

class DroneLostReason
{
    /*** @var string */
    public const KILLED_BY_A_FPV = 'Збито ФПВ';
    /*** @var string */
    public const KILLED_BY_A_WEAPON = 'Збито зброєю';
    /*** @var string */
    public const SUPPRESSION = 'Подавлення';
    public const OTHER = 'Інше';

    /*** @return string[] */
    public static function getList(): array
    {
        return [
            self::KILLED_BY_A_FPV => self::KILLED_BY_A_FPV,
            self::KILLED_BY_A_WEAPON => self::KILLED_BY_A_WEAPON,
            self::SUPPRESSION => self::SUPPRESSION,
            self::OTHER => self::OTHER,
        ];
    }
}
