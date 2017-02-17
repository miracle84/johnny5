<?php

$paramList = [];
$paramList['console_argument_data_list'] = $argv;
$paramList['download_folder'] = '';

$paramList['rabbitmq_host'] = 'localhost';
$paramList['rabbitmq_post'] = '5672';
$paramList['rabbitmq_user'] = 'guest';
$paramList['rabbitmq_password'] = 'guest';
$paramList['rabbitmq_vhost'] = '/';

$serviceList = [];
$serviceList['service.bot'] = [
    'name' => 'Johnny5\Services\BotService',
    'argument_list' => ['service.rabbitmq', 'validator.http_url']
];
$serviceList['service.rabbitmq'] = [
    'name' => 'Johnny5\Services\RabbitMQService',
    'argument_list' => [
        '%rabbitmq_host%',
        '%rabbitmq_post%',
        '%rabbitmq_user%',
        '%rabbitmq_password%',
        '%rabbitmq_vhost%'
    ]
];
$serviceList['validator.http_url'] = ['name' => 'Johnny5\Services\Validators\HttpUrlValidator'];
$serviceList['provider.url_from_file'] = ['name' => 'Johnny5\Services\Providers\UrlProviderFromFile'];
$serviceList['command.schedule'] = [
    'name' => 'Johnny5\Command\ScheduleCommand',
    'tag' => 'command'
];
$serviceList['command.download'] = [
    'name' => 'Johnny5\Command\DownloadCommand',
    'tag' => 'command'
];
$serviceList['command.help'] = [
    'name' => 'Johnny5\Kernel\Command\HelpCommand',
    'tag' => 'command'
];
$serviceList['service.download'] = [
    'name' => 'Johnny5\Services\DownloadService',
    'argument_list' => ['%download_folder%']
];
$serviceList['service.console_view'] = [
    'name' => 'Johnny5\Services\ConsoleViewService'
];
