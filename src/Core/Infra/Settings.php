<?php

use Dotenv\Dotenv;

// diretório base da aplicação
define('_DS_', DIRECTORY_SEPARATOR);
define('BASE_PATH', dirname(dirname(dirname(__FILE__))));
define('PUBLIC_PATH', dirname(BASE_PATH) . _DS_ . 'public' . _DS_);
define('LOG_PATH', dirname(BASE_PATH) . _DS_ . 'logs' . _DS_);

// Seta a URL base da aplicação
$baseUrl = null;
if (isset($_SERVER['HTTP_HOST'])) {
    $currentPath = str_replace('/public', '', $_SERVER['PHP_SELF']);
    $pathInfo = pathinfo($currentPath);
    $hostName = $_SERVER['HTTP_HOST'];
    $protocol = $_SERVER['REQUEST_SCHEME'] . '://';
    $baseUrl = $protocol . $hostName . $pathInfo['dirname'];
    $baseUrl .= $baseUrl[strlen($baseUrl) - 1] == '/' ? '' : '/';
}
define('BASE_URL', $baseUrl);

$dotenv = Dotenv::createImmutable(dirname(BASE_PATH), '.env');
$dotenv->load();
$development = false;
if (isset($_ENV['PHP_ENV'])  && ($_ENV['PHP_ENV'] == 'development' || $_ENV['PHP_ENV'] == 'testing')) {
    $development = true;
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}

define('IS_DEVELOPMENT', $development);

date_default_timezone_set('America/Sao_Paulo');

$settings['development'] = $development;
$settings['root'] = BASE_PATH;
$settings['public'] = PUBLIC_PATH;
$settings['base_url'] = BASE_URL;

$settings['error'] = [
    'display_error_details' => $development,
    'log_errors' => $development,
    'log_error_details' => $development
];

return $settings;
