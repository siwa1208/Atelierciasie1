<?php
namespace app\control;

use app\view\MediaViewAdair;

class MediaControllerAdair extends \mf\control\AbstractController {

    public function viewSignup(){
        $view = new MediaViewAdair();
        $view->render('signup');
    }

    public function checkSignup(){
        if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['telephone']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password_verify'])){
            if ($_POST['password'] == $_POST['password_verify']){
                $auth = new \app\auth\MediaAuthentification();
                $auth->createUser($_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['telephone'], $_POST['password']);
                \mf\router\Router::executeRoute('home');
            }else{
                /* Exception mot de passes non identiques */
                \mf\router\Router::executeRoute('signup');
            }
        } else {
            /* Exception champ manquant */
            \mf\router\Router::executeRoute('signup');
        }
    }
}