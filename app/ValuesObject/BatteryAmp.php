<?php

namespace App\ValuesObject;

/**
 *
 */
class BatteryAmp
{
    /*** @var string */
    public const AMP_61 = '64A';
    /*** @var string */
    public const AMP_64 = '61A';
    /*** @var string */
    public const AMP_66 = '66A';
    /*** @var string */
    public const AMP_71 = '71A';
    /*** @var string */
    public const AMP_72 = '72A';
    /*** @var string */
    public const AMP_73 = '73A';
    /*** @var string */
    public const AMP_74 = '74A';
    /*** @var string */
    public const AMP_75 = '75A';
    /*** @var string */
    public const AMP_76 = '76A';
    /*** @var string */
    public const AMP_85 = '85A';

    /*** @return string[] */
    public static function getList(): array
    {
        return [
            self::AMP_61 => self::AMP_61,
            self::AMP_64 => self::AMP_64,
            self::AMP_66 => self::AMP_66,
            self::AMP_71 => self::AMP_71,
            self::AMP_72 => self::AMP_72,
            self::AMP_73 => self::AMP_73,
            self::AMP_74 => self::AMP_74,
            self::AMP_75 => self::AMP_75,
            self::AMP_76 => self::AMP_76,
            self::AMP_85 => self::AMP_85,
        ];
    }
}
