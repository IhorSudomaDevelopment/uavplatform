<?php

namespace App\ValuesObject;

class DroneStatus
{
    /*** @var string */
    public const WORK = 'БГ';
    /*** @var string */
    public const NOT_WORK = 'Не БГ';
    /*** @var string */
    public const LOST = 'Втрачено';

    /*** @return string[] */
    public static function getList(): array
    {
        return [
            self::WORK => self::WORK,
            self::NOT_WORK => self::NOT_WORK,
            self::LOST => self::LOST,
        ];
    }
}
