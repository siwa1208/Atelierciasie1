<?php
namespace app\control;

class MediaControllerJonathan extends \mf\control\AbstractController {

    public function __construct(){
        parent::__construct();
    }

    public function viewLogin() {
        $view = new \app\view\MediaViewJonathan();
        echo $view->render('login');
    }

    public function checkLogin(){
        $media_auth = new \app\auth\MediaAuthentification();
        $media_auth->loginUser($_POST['adresse_mail'], $_POST['password']);
    }

    public function logout() {
        $auth = new \app\auth\MediaAuthentification();
        $auth->logout();
        \mf\router\Router::executeRoute('home');
    }
}