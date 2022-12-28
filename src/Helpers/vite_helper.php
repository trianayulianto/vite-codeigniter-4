<?php

use TYlnt\Vite\Facades\Vite;

if (! function_exists('vite')) {
    /**
     * Get the HTML tags for the Vite client and every configured entrypoint.
     *
     * @param  string|string[]  $entrypoints
     * @param  string|null  $buildDirectory
     */
    function vite($entrypoints, $buildDirectory = null)
    {
        return Vite::__invoke($entrypoints, $buildDirectory);
    }
}

if (! function_exists('vite_react_refresh')) {
    /**
     * Get the HTML script tag that includes the React Refresh runtime.
     */
    function vite_react_refresh()
    {
        return Vite::reactRefresh();
    }
}
