<?php

namespace App\Traits;

use App\Services\LogService;

/**
 *
 */
trait LogsActivity
{
    /*** @return void */
    protected static function bootLogsActivity(): void
    {
        static::created(function ($model) {
            LogService::created($model);
        });

        static::updated(function ($model) {
            LogService::updated($model);
        });

        static::deleted(function ($model) {
            LogService::deleted($model);
        });
    }
}
