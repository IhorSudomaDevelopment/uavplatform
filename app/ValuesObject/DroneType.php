<?php

namespace App\ValuesObject;

/**
 *
 */
class DroneType
{
    /*** @var string */
    public const VAMPIRE = 'Вампір';
    /*** @var string */
    public const HEAVY_SHOT = 'Heavy Shot';
    /*** @var string */
    public const ZHVAVYY = 'Heavy Shot (Жвавий)';
    /*** @var string */
    public const BAT = 'Кажан';
    /*** @var string */
    public const NEMESIS = 'Nemesis';
    /*** @var string */
    public const NEMESIS_K = 'Nemesis K';
    /*** @var string */
    public const NEMESIS_XS = 'Nemesis XS';
    /*** @var string */
    public const PERUN = 'Perun X9';
    /*** @var string */
    public const SHTURM = 'SHTURM 32.D';

    /*** @return string[] */
    public static function getList(): array
    {
        return [
            self::VAMPIRE => self::VAMPIRE,
            self::HEAVY_SHOT => self::HEAVY_SHOT,
            self::ZHVAVYY => self::ZHVAVYY,
            self::BAT => self::BAT,
            self::NEMESIS => self::NEMESIS,
            self::NEMESIS_K => self::NEMESIS_K,
            self::NEMESIS_XS => self::NEMESIS_XS,
            self::PERUN => self::PERUN,
            self::SHTURM => self::SHTURM,
        ];
    }
}
