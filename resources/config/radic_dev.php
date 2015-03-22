<?php

return array(
    'ide-helper'   => true,                   # Enable/disable barryvdh/laravel-ide-helper
    'debugbar'     => true,                   # Enable/disable barryvdh/laravel-debugbar
    'tracy'        => true,                   # Enable/disable Tracy/Tracy
    'debugbarAjax' => true,
    'console'      => true,
    'provide'      => array(
        'route'   => true,                  # Enable/disable ajax debugbar fetching
        'console' => true                   # Enable/disable console commands
    ),
    'route'        => array(
        'base' => '/radic-dev'
    )
);
