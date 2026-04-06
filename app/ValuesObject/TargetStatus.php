<?php

namespace App\ValuesObject;

class TargetStatus
{
    /*** @var string */
    public const NA = '-';
    /*** @var string */
    public const DELIVERED = 'Доставлено';
    /*** @var string */
    public const AFFECTED = 'Уражено';
    /*** @var string */
    public const AFFECTED_AFTER_ADJUSTMENT = 'Уражено (за коригуванням)';
    /*** @var string */
    public const AFFECTED_BY_SIGNATURES = 'Уражено (по тепловим сигнатурах)';
    /*** @var string */
    public const AFFECTED_BY_COORDS = 'Уражено (за координатами)';
    /*** @var string */
    public const NOT_AFFECTED_NO_DETONATION = 'Не уражено (без детонації)';
    /*** @var string */
    public const NOT_AFFECTED_MISSING_TARGET = 'Не уражено (відсутня ціль)';
    /*** @var string */
    public const NOT_AFFECTED_LOSS_OF_SIDE = 'Не уражено (втрата борта)';
    /*** @var string */
    public const NOT_AFFECTED_NOT_HEAT = 'Не уражено (невлучання)';
    /*** @var string */
    public const NOT_AFFECTED_SUPPRESSION = 'Не уражено (подавлення)';
    /*** @var string */
    public const NOT_AFFECTED_ACB = 'Не уражено (просадка АКБ)';
    /*** @var string */
    public const MINED = 'Заміновано';
    /*** @var string */
    public const NOT_MINED = 'Не заміновано';
    /*** @var string */
    public const DESTROYED = 'Знищено';
    /*** @var string */
    public const NOT_DETECTED = 'Не виявлено';
    /*** @var string */
    public const COMPLETED = 'Виконано';

    /*** @return string[] */
    public static function getList(): array
    {
        return [
            self::NA => self::NA,
            self::DELIVERED => self::DELIVERED,
            self::AFFECTED => self::AFFECTED,
            self::AFFECTED_AFTER_ADJUSTMENT => self::AFFECTED_AFTER_ADJUSTMENT,
            self::AFFECTED_BY_SIGNATURES => self::AFFECTED_BY_SIGNATURES,
            self::AFFECTED_BY_COORDS => self::AFFECTED_BY_COORDS,
            self::NOT_AFFECTED_NO_DETONATION => self::NOT_AFFECTED_NO_DETONATION,
            self::NOT_AFFECTED_MISSING_TARGET => self::NOT_AFFECTED_MISSING_TARGET,
            self::NOT_AFFECTED_LOSS_OF_SIDE => self::NOT_AFFECTED_LOSS_OF_SIDE,
            self::NOT_AFFECTED_NOT_HEAT => self::NOT_AFFECTED_NOT_HEAT,
            self::NOT_AFFECTED_SUPPRESSION => self::NOT_AFFECTED_SUPPRESSION,
            self::NOT_AFFECTED_ACB => self::NOT_AFFECTED_ACB,
            self::MINED => self::MINED,
            self::NOT_MINED => self::NOT_MINED,
            self::DESTROYED => self::DESTROYED,
            self::NOT_DETECTED => self::NOT_DETECTED,
            self::COMPLETED => self::COMPLETED,
        ];
    }
}
