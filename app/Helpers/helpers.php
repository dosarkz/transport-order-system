<?php

if ( ! function_exists('active_link'))
{
    function active_link($path)
    {
        if (request()->path() == $path)
        {
            return 'active';
        }
        return false;
    }
}


if ( ! function_exists('active_uri'))
{
    function active_uri($path)
    {
        if (request()->getRequestUri() == $path or '/'.request()->getRequestUri() == $path)
        {
            return 'active';
        }
        return false;
    }
}

if (!function_exists('active_lang'))
{
    function active_lang($lang)
    {
        if (app()->getLocale() == $lang)
        {
            return 'active';
        }
        return false;
    }
}

if ( ! function_exists('active_link_with_class'))
{
    function active_link_with_class($path, $class)
    {
        if (request()->path() == $path or '/'.request()->path() == $path)
        {
            return $class;
        }
        return false;
    }
}

if ( ! function_exists('active_link_sub'))
{
    function active_link_sub($path)
    {
        if ('/'.request()->segment(1).'/'.request()->segment(2) == $path)
        {
            return 'active';
        }
        return false;
    }
}

if ( ! function_exists('active_link_uri_with_class'))
{
    function active_link_uri_with_class($path, $class)
    {
        if (request()->getRequestUri() == $path)
        {
            return $class;
        }
        return false;
    }
}

if (!  function_exists('tab_link_active'))
{
    function tab_link_active($step)
    {
        if (request()->get('step') == $step)
        {
            return 'tab-active';
        }
        return false;
    }
}

if ( ! function_exists('purify_phone_number'))
{
    function purify_phone_number($dirtyPhone)
    {
        $dirtyPhone = preg_replace('/[^0-9]/', '', $dirtyPhone);
        switch (strlen($dirtyPhone)) {
            case 11:
                return sprintf('7%s', substr($dirtyPhone, -10));
            case 10:
                return sprintf('7%s', $dirtyPhone);
            default:
                if(strlen($dirtyPhone) > 11){
                    return substr($dirtyPhone, -10);
                }
                return $dirtyPhone;
        }
    }
}

if (!  function_exists('append_city'))
{
    function append_city()
    {
        if (request()->has('city_id'))
        {
            return '&city_id='.request()->input('city_id');
        }
        return false;
    }
}

if (! function_exists('secure_url_env')) {
    /**
     * Generate a HTTPS url for the application.
     *
     * @param  string  $path
     * @param  mixed   $parameters
     * @return string
     */
    function secure_url_env($path, $parameters = [])
    {

        if(app()->environment() == 'local')
        {
            return url($path, $parameters, false);
        }
        return url($path, $parameters, true);
    }
}
