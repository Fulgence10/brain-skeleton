<?php

use Brain\Http\Request;
use Brain\Application\Brain;
use Brain\Event\EventManager;

define('BASE_DIR',__DIR__ . DIRECTORY_SEPARATOR);

/**
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 */
require  BASE_DIR ."vendor/autoload.php";

/**
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 */
$app = new Brain(BASE_DIR . "config");

$eventManager = EventManager::getInstance();

/**
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 */
require BASE_DIR . "routes/api.php";
require BASE_DIR . "routes/http.php";
require BASE_DIR . "routes/event.php";

/**
* 
* 
* 
* 
* 
* 
* 
* 
* 
* 
*/

$app->start(Request::fromGlobals());
