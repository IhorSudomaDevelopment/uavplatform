<?php

namespace App\Providers;

use App\ModelControllers\AmmunitionController;
use Illuminate\Support\ServiceProvider;

/**
 * Class ControllerServiceProvider
 * @package App\Providers
 */
class ControllerServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap services.
	 * @return void
	 */
	public function boot(): void
	{
		$this->app->singleton(AmmunitionController::class);
		$this->app->alias(AmmunitionController::class, 'AmmunitionController');
//		$this->app->singleton(FlightController::class);
//		$this->app->alias(FlightController::class, 'FlightController');
	}
}
