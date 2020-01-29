<?php
use \mf\utils\ClassLoader as Loader;
use \app\model as model;
use \mf\router\Router as Router;
use \app\auth\MediaAuthentification as MediaAuthentification;

require_once 'src/mf/utils/ClassLoader.php';
require_once 'vendor/autoload.php';

session_start();

$loader = new Loader("src");
$loader->register();

$config = parse_ini_file('conf/config.ini');
$db = new Illuminate\Database\Capsule\Manager();

$db->addConnection($config);
$db->setAsGlobal();
$db->bootEloquent();

$router = new Router();

$router->addRoute('home', '/home/', '\app\control\MediaControllerSegolene', 'viewHome', MediaAuthentification::ACCESS_LEVEL_NONE);
$router->addRoute('viewLogin', '/viewLogin/', '\app\control\MediaControllerJonathan', 'viewLogin', MediaAuthentification::ACCESS_LEVEL_NONE);
$router->addRoute('checkLogin', '/checkLogin/', '\app\control\MediaControllerJonathan', 'checkLogin', MediaAuthentification::ACCESS_LEVEL_NONE);
$router->addRoute('logout', '/logout/', '\app\control\MediaControllerJonathan', 'logout', MediaAuthentification::ACCESS_LEVEL_USER);
$router->addRoute('viewSignup', '/viewSignup/', '\app\control\MediaControllerAdair', 'viewSignup', MediaAuthentification::ACCESS_LEVEL_NONE);
$router->addRoute('checkSignup', '/checkSignup/', '\app\control\MediaControllerAdair', 'checkSignup', MediaAuthentification::ACCESS_LEVEL_NONE);
$router->addRoute('searchResults', '/searchResults/', '\app\control\MediaControllerMouad', 'searchResults', MediaAuthentification::ACCESS_LEVEL_NONE);
$router->addRoute('viewSearch', '/viewSearch/', '\app\control\MediaControllerMouad', 'viewSearch', MediaAuthentification::ACCESS_LEVEL_NONE);
$router->addRoute('viewProfile', '/viewProfile/', '\app\control\MediaControllerClement', 'viewProfile', MediaAuthentification::ACCESS_LEVEL_USER);
$router->addRoute('viewDoc', '/viewDoc/', '\app\control\MediaControllerClement', 'viewDoc', MediaAuthentification::ACCESS_LEVEL_NONE);
$router->addRoute('viewCalendar', '/viewCalendar/', '\app\control\MediaControllerSegolene', 'viewCalendar', MediaAuthentification::ACCESS_LEVEL_USER);
$router->addRoute('checkBorrow', '/checkBorrow/', '\app\control\MediaControllerSegolene', 'checkBorrow', MediaAuthentification::ACCESS_LEVEL_USER);
$router->setDefaultRoute('/home/');
$router->run();