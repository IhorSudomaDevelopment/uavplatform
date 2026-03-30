<?php

namespace App\ValuesObject;

class PositionStatus
{
    /*** @var string */
    public const WORK = 'БГ';
    /*** @var string */
    public const NOT_WORK = 'Не БГ';
    /*** @var string */
    public const DESTROYED = 'Знищена';

    /*** @return string[] */
    public static function getList(): array
    {
        return [
            self::WORK => self::WORK,
            self::NOT_WORK => self::NOT_WORK,
            self::DESTROYED => self::DESTROYED,
        ];
    }
}
