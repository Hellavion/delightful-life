<?php

use App\Models\Setting;

if (!function_exists('setting')) {
    /**
     * Получить значение настройки по ключу
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function setting(string $key, $default = null)
    {
        return Setting::get($key, $default);
    }
}