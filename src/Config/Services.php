<?php

namespace TYlnt\Vite\Config;

use CodeIgniter\Config\BaseService;

class Services extends BaseService
{
    public static function vite($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('vite');
        }

        return new \TYlnt\Vite\Vite();
    }
}
