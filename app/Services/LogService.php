<?php

namespace App\Services;

use App\Models\Log;
use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class LogService
{
    /**
     * @param Model $model
     * @return void
     */
    public static function created(Model $model): void
    {
        self::save(
            model: $model,
            action: 'created',
            old: null,
            new: $model->getAttributes(),
        );
    }

    /**
     * @param Model $model
     * @return void
     */
    public static function updated(Model $model): void
    {
        self::save(
            model: $model,
            action: 'updated',
            old: $model->getOriginal(),
            new: $model->getChanges(),
        );
    }

    /**
     * @param Model $model
     * @return void
     */
    public static function deleted(Model $model): void
    {
        self::save(
            model: $model,
            action: 'deleted',
            old: $model->getOriginal(),
            new: null,
        );
    }

    /**
     * @param Model $model
     * @param string $action
     * @param array|null $old
     * @param array|null $new
     * @return void
     */
    protected static function save(
        Model  $model,
        string $action,
        ?array $old,
        ?array $new,
    ): void
    {

        Log::create([
            'user_id' => auth()->id(),
            'model' => class_basename($model),
            'model_id' => $model->getKey(),
            'action' => $action,
            'old_values' => $old,
            'new_values' => $new,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
