<?php

use Psr\Log\LogLevel;

const APP_ROOT = __DIR__;

return [
    'settings' => [
        'displayErrorDetails' => true, // Should be set to false in production
        'logger' => [
            'name' => 'SlimPoC',
            'path' => 'php://stderr',
            'level' => LogLevel::DEBUG,
        ],
    ],
    'appName' => 'Slim4Poc - making it simple'
];