<?php

namespace Johnny5;

use Johnny5\Kernel\ServiceContainer;

$serviceList = [];
$paramList = [];

require_once PROJECT_DIR . '/app/config/config.php';
require_once PROJECT_DIR . '/src/Johnny5/Kernel/Autoload.php';
require_once PROJECT_DIR . '/src/Johnny5/Kernel/ServiceContainer.php';

if (file_exists(PROJECT_DIR . '/vendor/autoload.php')) {
    include_once PROJECT_DIR . '/vendor/autoload.php';
}

ServiceContainer::init($serviceList, $paramList);
