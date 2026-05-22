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
    /*** @var string */
    public const ON_WAREHOUSE = 'На майстерні';

    /*** @return string[] */
    public static function getList(): array
    {
        return [
            self::WORK => self::WORK,
            self::NOT_WORK => self::NOT_WORK,
            self::LOST => self::LOST,
            self::ON_WAREHOUSE => self::ON_WAREHOUSE,
        ];
    }
}
