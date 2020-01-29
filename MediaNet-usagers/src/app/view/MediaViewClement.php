<?php
namespace app\view;

class MediaViewClement extends \mf\view\AbstractView {

    private $router;
    private $app_root;

    public function __construct($data = ''){
        parent::__construct($data);
        $this->router = new \mf\router\Router();
        $this->app_root = (new \mf\utils\HttpRequest())->root;
    }

    protected function renderHeader() {
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

    public function renderProfile() {
        $html = "<div class='viewProfile-container'><div class='profile-container'>
                    <div><img src='".$this->data->img."'></div>
                    <ul>
                        <li>Nom : ".$this->data->nom."</li>
                        <li>Prénom : ".$this->data->prenom."</li>
                        <li>Adresse mail : ".$this->data->adresse_mail."</li>
                        <li>Téléphone : ".$this->data->telephone."</li>
                    </ul>
                </div>";

        $html .= "<div class='barrowed-docs-container'>
                  <div id='barrowed-docs-title'>Documents empruntés :</div>";

        foreach ($this->data->currentBorrows()->getResults() as $doc) {
            $html .= "<div>
                          <span><a href='".$this->router::urlFor('viewDoc', ['id' => $doc->id])."'>".$doc->titre."</a></span>
                      </div>";
        }

        $html .= "</div></div>";

        return $html;
    }

    public function renderDoc() {
        $doc = \app\model\Document::select()->where('id', '=', $_GET['id'])->first();

        $auth = new \app\auth\MediaAuthentification();

        $html = "<div class='viewDoc-container'>
                    <div><img src='".$doc->img."'></div>
                    <ul>
                        <li>
                            <div class='document-label'>Titre</div>
                            <div class='document-content'>".$doc->titre."</div>
                        </li>
                        <li>
                            <div class='document-label'>Genre</div>
                            <div class='document-content'>".$doc->genre."</div>
                        </li>
                        <li>
                            <div class='document-label'>Description</div>
                            <div class='document-content'>".$doc->description."</div>
                        </li>
                    </ul>
                
                    <div class='document-state-container'>
                        <span class='document-label'>État : </span><span class='document-content'>".$doc->etat."</span>";

        if ($auth->user_login) {
            if ($doc->etat === "disponible") {
                $html .= "<a href='".$this->router::urlFor('viewCalendar', ["id"=>$doc->id])."' class='barrow-btn'>Emprunter</a>";
            } else {
                $html .= "<a href='".$this->router::urlFor('viewSearch')."' class='barrow-btn'>Chercher</a>";
            }
        } else {
            if ($doc->etat === "disponible") {
                $html .= "<a href='".$this->router::urlFor('viewLogin')."' class='barrow-btn'>Emprunter</a>";
            } else {
                $html .= "<a href='".$this->router::urlFor('viewSearch')."' class='barrow-btn'>Chercher</a>";
            }
        }

        $html .= "</div></div>";

        return $html;
    }

    protected function renderFooter() {
        return "<footer>
                    <span>Nous contacter</span><span>medianancy@ciasie.fr</span><span>0312345678</span><span>1ter Boulevard Charlemagne</span>
                </footer>";
    }

    protected function renderBody($selector) {
        $html = "";
        $html .= $this->renderHeader();

        $html .= "<section>";
        switch ($selector) {
            case 'viewProfile':
                $html .= $this->renderProfile();
                break;
            case 'viewDoc':
                $html .= $this->renderDoc();
                break;
            default:
                $html .= $this->renderHome();
        }
        $html .= "</section>";

        $html .= $this->renderFooter();

        return $html;
    }
}