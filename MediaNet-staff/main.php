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

$router->addRoute('home', '/home/', '\app\control\MediaControllerSegolene','viewHome', MediaAuthentification::ACCESS_LEVEL_NONE);
$router->addRoute('searchDocuments', '/searchDocuments/','\app\control\MediaControllerMouad', 'searchDocuments', MediaAuthentification::ACCESS_LEVEL_NONE);
$router->addRoute('searchDocumentshResults', '/searchDocumentshResults/', '\app\control\MediaControllerMouad', 'searchDocumentshResults', MediaAuthentification::ACCESS_LEVEL_NONE);
$router->addRoute('searchUsers', '/searchUsers/', '\app\control\MediaControllerMouad', 'searchUsers', MediaAuthentification::ACCESS_LEVEL_NONE);
$router->addRoute('searchUsersResults', '/searchUsersResults/', '\app\control\MediaControllerMouad', 'searchUsersResults', MediaAuthentification::ACCESS_LEVEL_NONE);
$router->addRoute('viewProfile', '/viewProfile/', '\app\control\MediaControllerClement', 'viewProfile', MediaAuthentification::ACCESS_LEVEL_NONE);
$router->addRoute('viewDoc', '/viewDoc/', '\app\control\MediaControllerClement', 'viewDoc', MediaAuthentification::ACCESS_LEVEL_NONE);
$router->addRoute('viewBorrow', '/viewBorrow/', '\app\control\MediaControllerJonathan', 'viewBorrow', MediaAuthentification::ACCESS_LEVEL_NONE);
$router->addRoute('checkBorrow', '/checkBorrow/', '\app\control\MediaControllerJonathan', 'checkBorrow', MediaAuthentification::ACCESS_LEVEL_NONE);
$router->addRoute('viewReturn', '/viewReturn/', '\app\control\MediaControllerAdair', 'viewReturn', MediaAuthentification::ACCESS_LEVEL_NONE);
$router->addRoute('checkReturn', '/checkReturn/', '\app\control\MediaControllerAdair', 'checkReturn', MediaAuthentification::ACCESS_LEVEL_NONE);
$router->setDefaultRoute('/home/');
$router->run();