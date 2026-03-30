<?php
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
