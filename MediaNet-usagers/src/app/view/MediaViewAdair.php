<?php
namespace app\view;

class MediaViewAdair extends \mf\view\AbstractView {

    private $router;
    private $app_root;

    public function __construct($data = ''){
        parent::__construct($data);
        $this->router = new \mf\router\Router();
        $this->app_root = (new \mf\utils\HttpRequest())->root;
    }

    public function renderHeader(){
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

    protected function renderFooter() {
        return "<footer>
                    <span>Nous contacter</span><span>medianancy@ciasie.fr</span><span>0312345678</span><span>1ter Boulevard Charlemagne</span>
                </footer>";
    }

    protected function renderBody($selector) {
        $html = $this->renderHeader();
        $html .= "<div class='container_r'>";
        //$html .= "<img src =/css/img/medianet.jpg/><br><br>";
        switch ($selector){
            case "signup":
                $html .= '
                <form action="'.\mf\router\Router::urlFor('checkSignup').'" method="post" id="form_register">
                    <div class="row_r">
                            <label>Nom</label>
                            <input type="text" name="nom" placeholder="Nom" class="input_r">
                    </div>
                    <div class="row_r">
                            <label>Prenom</label>
                            <input type="text" name="prenom" placeholder="Prenom" class="input_r">
                    </div>
                    <div class="row_r">
                            <label>Téléphone</label>
                            <input type="tel" name="telephone" placeholder="Téléphone" class="input_r">
                    </div>
                    <div class="row_r">
                            <label>Email</label>
                            <input type="email" name="email" placeholder="Email" class="input_r">
                    </div>
                    <div class="row_r">
                            <label>Mot de passe</label>
                            <input type="password" name="password" placeholder="Mot de passe" class="input_r">
                    </div>
                    <div class="row_r">
                            <label>Confirmation de mot de passe</label>
                            <input type="password" name="password_verify" placeholder="Retape mot de passe" class="input_r">
                    </div>
                    
                    <div class="row_r_button">
                        <button name="register_button" type="submit" id="submit_r">Créer mon compte</button>              
                    </div>
                </form>';
                break;
        }
        $html .= "</div>";
        $html .= $this->renderFooter();
        return $html;
    }

}