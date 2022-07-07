<?php

use Edeno\PhpCleanContactList\Core\Infra\Http\App;


require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
App::getInstance()->getSlimApp()->run();
