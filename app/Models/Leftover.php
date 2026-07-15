<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

/**
 *
 */
class Leftover extends Model
{
    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     * @var array<int, string>
     */
    protected $fillable = [
        'position_id',
        'title',
        'quantity',
        'unit',
    ];

    /*** @return BelongsTo */
    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    /**
     * @param array $data
     * @return void
     */
    public static function createMany(array $data): void
    {
        foreach ($data['leftover_items'] as $item) {
            if (isset($data['position_id'])) {
                $positionId = $data['position_id'];
            } else {
                $positionWithUser = Position::where('user_id', Auth::id())->first();
                if ($positionWithUser !== null) {
                    $positionId = $positionWithUser->id;
                }
            }
                self::create([
                    'position_id' => $positionId,
                    'title' => $item['leftover_title'],
                    'quantity' => $item['leftover_quantity'],
                    'unit' => $item['leftover_unit'],
                ]);
        }
    }
}
