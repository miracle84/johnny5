<?php

spl_autoload_register(function ($class) {
    if (defined('PROJECT_DIR')) {
        $class = str_replace('\\', '/', $class);
        if (file_exists(PROJECT_DIR . '/src/' . $class . '.php')) {
            include_once PROJECT_DIR . '/src/' . $class . '.php';
        }
    }
});
