<?php

namespace App\ValuesObject;

class Target
{
    /*** @var string */
    public const PERSONNEL = 'ОС';
    /*** @var string */
    public const SHELTER = 'Укриття';
    /*** @var string */
    public const SHELTER_WITH_PERSONNEL = 'Укриття з ОС';
    /*** @var string */
    public const CROSSING = 'Переправа';
    /*** @var string */
    public const FIRE_FIGHTING = 'Пожежогасіння';
    /*** @var string */
    public const MINING = 'Мінування';
    /*** @var string */
    public const DELIVERY = 'Доставка';
    /*** @var string */
    public const UAV = 'БПЛА';
    /*** @var string */
    public const MACHINERY = 'Техніка';
    /*** @var string */
    public const CROSSING_BARGE = 'Перегін борта';

    /*** @return string[] */
    public static function getList(): array
    {
        return [
            self::PERSONNEL              => self::PERSONNEL,
            self::SHELTER                => self::SHELTER,
            self::SHELTER_WITH_PERSONNEL => self::SHELTER_WITH_PERSONNEL,
            self::CROSSING               => self::CROSSING,
            self::FIRE_FIGHTING          => self::FIRE_FIGHTING,
            self::MINING                 => self::MINING,
            self::DELIVERY               => self::DELIVERY,
            self::UAV                    => self::UAV,
            self::MACHINERY              => self::MACHINERY,
            self::CROSSING_BARGE         => self::CROSSING_BARGE,
        ];
    }
}
