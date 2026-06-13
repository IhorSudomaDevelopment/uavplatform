<?php

namespace App\ValuesObject;

/**
 *
 */
class TargetStatus
{
    /*** @var string */
    public const NA = '-';
    /*** @var string */
    public const DELIVERED = 'Доставлено';
    /*** @var string */
    public const NOT_DELIVERED = 'Не доставлено';
    /*** @var string */
    public const AFFECTED = 'Уражено';
    /*** @var string */
    public const AFFECTED_AFTER_ADJUSTMENT = 'Уражено (за коригуванням)';
    /*** @var string */
    public const AFFECTED_BY_SIGNATURES = 'Уражено (по теплових сигнатурах)';
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
    /*** @var string */
    public const NOT_COMPLETED = 'Не виконано';
    /*** @var string */
    public const FOUND = 'Знайдено';
    /*** @var string */
    public const NOT_FOUND = 'Не знайдено';

    /*** @return string[] */
    public static function getList(): array
    {
        return [
            self::NA => self::NA,
            self::DELIVERED => self::DELIVERED,
            self::NOT_DELIVERED => self::NOT_DELIVERED,
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
            self::NOT_COMPLETED => self::NOT_COMPLETED,
            self::FOUND => self::FOUND,
            self::NOT_FOUND => self::NOT_FOUND,
        ];
    }

    /**
     * @param string $target
     * @return array|string[]
     */
    public static function getStatusListForTarget(string $target): array
    {
        if ($target === 'all') {
            return self::getList();
        }
        $list = [];
        switch ($target) {
            case Target::PERSONNEL:
            case Target::SHELTER:
            case Target::ZPM:
            case Target::AMMUNITION_WARE:
            case Target::CROSSING:
            case Target::UAV:
            case Target::MACHINERY:
                $list = [
                    self::DESTROYED => self::DESTROYED,
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
                ];
                break;
            case Target::UAV_EVACUATION:
            case Target::CROSSING_BARGE:
            case Target::FIRE_FIGHTING:
            case Target::LOGISTIC_MISSION:
                $list = [
                    self::COMPLETED => self::COMPLETED,
                    self::NOT_COMPLETED => self::NOT_COMPLETED,
                ];
                break;
            case Target::MINING:
                $list = [
                    self::MINED => self::MINED,
                    self::NOT_MINED => self::NOT_MINED,
                ];
                break;
            case Target::DELIVERY:
                $list = [
                    self::DELIVERED => self::DELIVERED,
                    self::NOT_DELIVERED => self::NOT_DELIVERED,
                ];
                break;
            case Target::UAV_HUNT:
                $list = [
                    self::DESTROYED => self::DESTROYED,
                    self::AFFECTED => self::AFFECTED,
                    self::NOT_AFFECTED_NO_DETONATION => self::NOT_AFFECTED_NO_DETONATION,
                    self::NOT_AFFECTED_LOSS_OF_SIDE => self::NOT_AFFECTED_LOSS_OF_SIDE,
                    self::NOT_AFFECTED_NOT_HEAT => self::NOT_AFFECTED_NOT_HEAT,
                    self::NOT_AFFECTED_SUPPRESSION => self::NOT_AFFECTED_SUPPRESSION,
                    self::NOT_DETECTED => self::NOT_DETECTED,
                ];
                break;
            case Target::SEARCH_MISSION:
                $list = [
                    self::FOUND => self::FOUND,
                    self::NOT_FOUND => self::NOT_FOUND,
                ];
                break;
        }
        return $list;
    }
}
