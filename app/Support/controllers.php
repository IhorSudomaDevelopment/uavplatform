<?php

use App\ModelControllers\AmmunitionController;

if ( ! function_exists('ammunitionController')) {
    /*** @return AmmunitionController */
    function ammunitionController(): AmmunitionController
    {
        return app('AmmunitionController');
    }
}
//if ( ! function_exists('flightController')) {
//    /*** @return FlightController */
//    function flightController(): FlightController
//    {
//        return app('FlightController');
//    }
//}
