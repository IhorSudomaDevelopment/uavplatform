<?php

namespace App\ValuesObject;

class Target
{
    /*** @var string */
    public const PERSONNEL = 'ОС';
    /*** @var string */
    public const SHELTER = 'Укриття';
    /*** @var string */
    public const BELOV_GROUND_SHELTER = 'Підземне укриття';
    /*** @var string */
    public const ABOVE_GROUND_STRUCTURE = 'Наземна споруда';
    /*** @var string */
    public const ZPM = 'Ворожий ЗПМ';
    /*** @var string */
    public const ARTILLERY = 'Гаубиця';
    /*** @var string */
    public const AMMUNITION_WARE = 'Склад БК';
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
    public const UAV_HUNT = 'Хант БПЛА';
    /*** @var string */
    public const CROSSING_BARGE = 'Перегін борта';
    /*** @var string */
    public const LOGISTIC_MISSION = 'Логістична місія';
    /*** @var string */
    public const EVACUATION_MISSION = 'Евакуаційна місія';
    /*** @var string */
    public const SEARCH_MISSION = 'Пошукова місія';
    /*** @var string */
    public const AREA_CLEANING = 'Зачистка ділянки';
    /*** @var string */
    public const MINE = 'Міна';
    /*** @var string */
    public const CAMERA_INSTALL = 'Встановлення камери';

    /*** @return string[] */
    public static function getList(): array
    {
        return [
            self::PERSONNEL              => self::PERSONNEL,
            self::SHELTER                => self::SHELTER,
            self::BELOV_GROUND_SHELTER   => self::BELOV_GROUND_SHELTER,
            self::ABOVE_GROUND_STRUCTURE => self::ABOVE_GROUND_STRUCTURE,
            self::ZPM                    => self::ZPM,
            self::ARTILLERY              => self::ARTILLERY,
            self::AMMUNITION_WARE        => self::AMMUNITION_WARE,
            self::CROSSING               => self::CROSSING,
            self::FIRE_FIGHTING          => self::FIRE_FIGHTING,
            self::MINING                 => self::MINING,
            self::DELIVERY               => self::DELIVERY,
            self::UAV                    => self::UAV,
            self::MACHINERY              => self::MACHINERY,
            self::UAV_HUNT               => self::UAV_HUNT,
            self::CROSSING_BARGE         => self::CROSSING_BARGE,
            self::LOGISTIC_MISSION       => self::LOGISTIC_MISSION,
            self::EVACUATION_MISSION         => self::EVACUATION_MISSION,
            self::SEARCH_MISSION         => self::SEARCH_MISSION,
            self::AREA_CLEANING          => self::AREA_CLEANING,
            self::MINE                   => self::MINE,
            self::CAMERA_INSTALL         => self::CAMERA_INSTALL,
        ];
    }
}
