<?php

namespace App\ValuesObject;

class AmmunitionStatus
{
    public const DEFAULT = '-';
    public const DETONATION = 'Детонація';
    public const WITHOUT_DETONATION = 'Без детонації';
    public const INSTALLED = 'Встановлено';
    public const NOT_INSTALLED = 'Не встановлено';
    public const DELIVERED = 'Доставлено';
    public const RETURNED = 'Повернуто';
    public const EMERGENCY_JETTISON = 'Аварійний скид';
    public const SELF_JETTISON = 'Самосхід';
    public const LOST = 'Втрачено';

    /*** @return string[] */
    public static function getList(): array
    {
        return [
            self::DEFAULT => self::DEFAULT,
            self::DETONATION => self::DETONATION,
            self::WITHOUT_DETONATION => self::WITHOUT_DETONATION,
            self::INSTALLED => self::INSTALLED,
            self::NOT_INSTALLED => self::NOT_INSTALLED,
            self::DELIVERED => self::DELIVERED,
            self::RETURNED => self::RETURNED,
            self::EMERGENCY_JETTISON => self::EMERGENCY_JETTISON,
            self::SELF_JETTISON => self::SELF_JETTISON,
            self::LOST => self::LOST,
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
            case Target::BELOV_GROUND_SHELTER:
            case Target::ABOVE_GROUND_STRUCTURE:
            case Target::ZPM:
            case Target::ARTILLERY:
            case Target::AMMUNITION_WARE:
            case Target::CROSSING:
            case Target::UAV:
            case Target::MACHINERY:
            case Target::SAU:
            case Target::UAV_HUNT:
            case Target::MINE:
            case Target::FIRE_FIGHTING:
                $list = [
                    self::DETONATION => self::DETONATION,
                    self::WITHOUT_DETONATION => self::WITHOUT_DETONATION,
                    self::RETURNED => self::RETURNED,
                    self::EMERGENCY_JETTISON => self::EMERGENCY_JETTISON,
                    self::SELF_JETTISON => self::SELF_JETTISON,
                    self::LOST => self::LOST,
                ];
                break;
            case Target::MINING:
                $list = [
                    self::INSTALLED => self::INSTALLED,
                    self::RETURNED => self::RETURNED,
                    self::EMERGENCY_JETTISON => self::EMERGENCY_JETTISON,
                    self::SELF_JETTISON => self::SELF_JETTISON,
                    self::LOST => self::LOST,
                ];
                break;
            case Target::DELIVERY:
                $list = [
                    self::DELIVERED => self::DELIVERED,
                    self::EMERGENCY_JETTISON => self::EMERGENCY_JETTISON,
                    self::SELF_JETTISON => self::SELF_JETTISON,
                    self::LOST => self::LOST,
                ];
                break;
            case Target::CROSSING_BARGE:
            case Target::LOGISTIC_MISSION:
            case Target::EVACUATION_MISSION:
            case Target::SEARCH_MISSION:
            case Target::AREA_CLEANING:
                $list = [
                    self::DEFAULT => self::DEFAULT,
                    self::EMERGENCY_JETTISON => self::EMERGENCY_JETTISON,
                    self::SELF_JETTISON => self::SELF_JETTISON,
                    self::LOST => self::LOST,
                ];
                break;
            case Target::CAMERA_INSTALL:
                $list = [
                    self::INSTALLED => self::INSTALLED,
                    self::NOT_INSTALLED => self::NOT_INSTALLED,
                    self::LOST => self::LOST,
                ];
                break;
            case Target::AMBUSH:
                $list = [
                    self::DETONATION => self::DETONATION,
                    self::WITHOUT_DETONATION => self::WITHOUT_DETONATION,
                    self::RETURNED => self::RETURNED,
                    self::EMERGENCY_JETTISON => self::EMERGENCY_JETTISON,
                    self::LOST => self::LOST,
                ];
                break;
        }
        return $list;
    }
}
