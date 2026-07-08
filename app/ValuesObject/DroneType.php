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
    /*** @var string */
    public const NEMESIS = 'Nemesis';
    /*** @var string */
    public const ZHVAVYY = 'Heavy Shot (Жвавий)';
    /*** @var string */
    public const PERUN = 'Перун';

    /*** @return string[] */
    public static function getList(): array
    {
        return [
            self::HEAVY_SHOT => self::HEAVY_SHOT,
            self::BAT => self::BAT,
            self::VAMPIRE => self::VAMPIRE,
            self::NEMESIS => self::NEMESIS,
            self::ZHVAVYY => self::ZHVAVYY,
            self::PERUN => self::PERUN,
        ];
    }
}
