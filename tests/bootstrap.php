<?php


require_once dirname(__DIR__) . '/vendor/autoload.php';


/**
 * @param int $errno
 * @param string $errstr
 * @param string $errfile
 * @param int $errline
 */
function error_handler($errno, $errstr, $errfile, $errline)
{
    echo PHP_EOL;
    echo 'ERROR: ' . $errno . ' - ' . $errstr . PHP_EOL;
    echo 'FILE: ' . $errfile . ':' . $errline . PHP_EOL;
    echo PHP_EOL;
    // die();
}

set_error_handler('error_handler');
