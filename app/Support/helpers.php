<?php

use App\Models\Shift;
use Illuminate\Support\Facades\DB;

if (!function_exists('isRoleAdmin')) {
    /*** @return bool */
    function isRoleAdmin(): bool
    {
        return auth()->user()->role === 'admin';
    }
}
if (!function_exists('isRoleManager')) {
    /*** @return bool */
    function isRoleManager(): bool
    {
        return auth()->user()->role === 'manager';
    }
}
if (!function_exists('isRoleNavigator')) {
    /*** @return bool */
    function isRoleNavigator(): bool
    {
        return auth()->user()->role === 'navigator';
    }
}
if (!function_exists('getDefaultPosition')) {
    /*** @return string */
    function getDefaultPosition(): string
    {
        $value = DB::table('user_settings')
            ->where('user_id', auth()->id())
            ->value('default_position');
        return $value ?? '';
    }
}
if (!function_exists('getShiftDetails')) {
    /*** @return array */
    function getShiftDetails(): array
    {
        $query = DB::table('shifts')
            ->where('navigator_id', auth()->id())
            ->whereNull('end_date');
        $positionName = DB::table('positions')
            ->where('id', $query->value('position_id'));
        return ['shift_id' => $query->value('id'), 'position_name' => $positionName];
    }
}
if (!function_exists('getOnDutyNumber')) {
    /*** @return int */
    function getOnDutyNumber(): int
    {
        $q = Shift::where('navigator_id', auth()->id())->whereNull('end_date')->first();
        if ($q === null) {
            return 1;
        } else {
            if ($q->on_duty === 1) {
                return 2;
            } else {
                return 3;
            }
        }
    }
}
if (!function_exists('getShiftAndPositionData')) {
    /*** @return array */
    function getShiftAndPositionData(): array
    {
        $preparedShifts = null;
        if (isRoleNavigator()) {
            $num = DB::table('flights')
                ->whereDate('date', now('Europe/Kyiv'))
                ->where('user_id', auth()->id())
                ->max('flight_number');
            $num = ($num ?? 0) + 1;
        } else {
            $num = 1;
            $shifts = DB::table('shifts')
                ->where('status', 'Активна')
                ->get();
            foreach ($shifts as $shift) {
                /*** @var Shift $shift */
                $preparedShifts[$shift->id . '|' .
                $shift->position_id . '|' .
                $shift->navigator_id] = DB::table('positions')->where('id', $shift->position_id)->value('title') .
                    ' (' . DB::table('users')->where('id', $shift->navigator_id)->value('assigned_navigator') . ')';
            }
        }
        return $preparedShifts;
    }
}
