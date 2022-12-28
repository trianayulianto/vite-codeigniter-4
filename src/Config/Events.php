<?php

namespace TYlnt\Vite\Config;

use CodeIgniter\Events\Events;

Events::on('pre_system', static function () {
    helper('vite');
});
