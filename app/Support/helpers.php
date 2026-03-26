<?php
if ( ! function_exists('isRoleAdmin')) {
    /*** @return bool */
    function isRoleAdmin(): bool
    {
        return auth()->user()->role === 'admin';
    }
}
if ( ! function_exists('isRoleManager')) {
    /*** @return bool */
    function isRoleManager(): bool
    {
        return auth()->user()->role === 'manager';
    }
}
if ( ! function_exists('isRoleNavigator')) {
    /*** @return bool */
    function isRoleNavigator(): bool
    {
        return auth()->user()->role === 'navigator';
    }
}
if ( ! function_exists('getDefaultPosition')) {
    /*** @return string */
    function getDefaultPosition(): string
    {
        $value= DB::table('user_settings')
            ->where('user_id', auth()->id())
            ->value('default_position');
        return $value ?? '';
    }
}
