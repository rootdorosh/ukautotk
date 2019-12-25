<?php

if (! function_exists('allow')) {
    /*
     * @param string $permission
     * @return bool
     */
    function allow(string $permission): bool 
    {
        return request()->user()->checkPermission($permission);
    }
}

if (! function_exists('locales')) {
    /*
     * @return array
     */
    function locales(): array 
    {
        return config('translatable.locales');
    }
}