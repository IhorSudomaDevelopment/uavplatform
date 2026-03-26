<?php

namespace App\ValuesObject;

/**
 *
 */
class DroneType
{
    /*** @var string */
    public const HEAVY_SHOT = 'Heavy Shot';
    /*** @var string */
    public const BAT = 'Кажан';
    /*** @var string */
    public const VAMPIRE = 'Вампір';

    /*** @return string[] */
    public static function getList(): array
    {
        return [
            self::HEAVY_SHOT => self::HEAVY_SHOT,
            self::BAT => self::BAT,
            self::VAMPIRE => self::VAMPIRE,
        ];
    }
}
