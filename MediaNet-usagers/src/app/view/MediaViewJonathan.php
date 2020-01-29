<?php
namespace app\view;

class MediaViewJonathan extends \mf\view\AbstractView {

    private $router;
    private $app_root;

    public function __construct($data = ''){
        parent::__construct($data);
        $this->router = new \mf\router\Router();
        $this->app_root = (new \mf\utils\HttpRequest())->root;
    }

    public function renderHeader() {
        $auth = new \app\auth\MediaAuthentification();

        $html = "<header><h1><a href='".$this->router::urlFor('home')."'>MediaNet-User</a></h1>";

        if ($auth->logged_in) {
            $html .= "<a href='".$this->router::urlFor('viewProfile')."'>Afficher profil</a><a href='".$this->router::urlFor('logout')."'>Se déconnecter</a>";
        } else {
            $html .= "<a href='".$this->router::urlFor('viewLogin')."'>Se connecter</a><a href='".$this->router::urlFor('viewSignup')."'>S'inscrire</a>";
        }

        $html .= "</header>";

        return $html;
    }

    protected function renderLogin() {
        return '<section class="login-form">
                    <form class="forms" action="'.\mf\router\Router::urlFor('checkLogin').'" method="post">

                        <div class="conteneur_img">
                            <img src="https://institutosanfulgencio.es/wp-content/uploads/2018/04/perfil_sanfulgencio.png" alt="Avatar" class="avatar">
                        </div>   
                        
                        <h1>Login</h1>


                        <input class="forms-text" type="text" name="adresse_mail" placeholder="Adresse mail"><br>

                        <input class="forms-text" type="password" name="password" placeholder="Mot de passe"><br>
                        <button class="forms-button" name="login_button" type="submit">Se connecter</button>
                    </form>
                    <footer class="footer_login">
                        <p class="contenu_login_footer"><a class="login_link" href="'.\mf\router\Router::urlFor('viewSignup').'">Vous n\'avez pas un compte ? Inscrivez-vous !</a></p>
                    </footer>
                </section>';
    }

    protected function renderFooter() {
        return "<footer>
                    <span>Nous contacter</span><span>medianancy@ciasie.fr</span><span>0312345678</span><span>1ter Boulevard Charlemagne</span>
                </footer>";
    }

    protected function renderBody($selector) {
        $html = '';
        $html .= $this->renderHeader();
        switch($selector) {
            case 'login':
                $html .= $this->renderLogin();
                break;
        }
        $html .= $this->renderFooter();

        return $html;
    }
}