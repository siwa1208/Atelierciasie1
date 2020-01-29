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

    public function renderHeader(){
        return "<header><h1><a href='".$this->router::urlFor('home')."'>MediaNet-Staff</a></h1></header>";
    }

    protected function renderFooter() {
        return "<footer>
                    <span>Nous contacter</span><span>medianancy@ciasie.fr</span><span>0312345678</span><span>1ter Boulevard Charlemagne</span>
                </footer>";
    }

    public function renderBorrow() {
        return "<section class='borrow-container'>
                        <form class='borrow-form' action='".$this->router::urlFor('checkBorrow')."' method='post'>
                           <h1>Ajouter un emprunt</h1>
                                <label class='forms-text'>Numéro d'adhérent</label>
                                <input class='forms-input' type='text' name='id_membre'>
                                <label class='forms-text'>Référence du document</label>
                                <input class='forms-input' type='text' name='id_document'>
                                <button class='forms-button' type='submit'>Envoyer</button>
                        </form>
                </section>";
    }

    public function renderCheckBorrow() {
        $html = '';

        if ($this->data['success']) {
            $html .= "<div>".$this->data['user_login']." vient d'emprunter ".$this->data['titre_doc']." !</div>";
        } else {
            $html .= "<div>".$this->data['titre_doc']." est déjà emprunté</div>";
        }

        $html .= "<div><a href='".$this->router::urlFor('viewBorrow')."'>Ajouter un nouvelle emprunt</a></div>";

        return $html;
    }

    protected function renderBody($selector) {
        $html = '';
        $html .= $this->renderHeader();
        switch($selector) {
            case 'viewBorrow':
                $html .= $this->renderBorrow();
                break;
            case 'checkBorrow':
                $html .= $this->renderCheckBorrow();
                break;
        }
        $html .= $this->renderFooter();

        return $html;
    }
}