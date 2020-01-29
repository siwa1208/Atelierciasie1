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
        return "<header><h1><a href='".$this->router::urlFor('home')."'>MediaNet-Staff</a></h1></header>";
    }

    protected function renderFooter() {
        return "<footer>
                    <span>Nous contacter</span><span>medianancy@ciasie.fr</span><span>0312345678</span><span>1ter Boulevard Charlemagne</span>
                </footer>";
    }

    public function renderReturn() {
        return "<div class='container_r'>
                <form action='".$this->router::urlFor('checkReturn')."' method='post' id='form_register'>
                <div>Retour emprunt</div>
                    <label>Numéro d'adhérent</label><input type='text' name='id_membre' class='input_r'>
                    <label>Référence du document</label><input type='text' name='id_document' class='input_r'>
                    <button type='submit' id='submit_r'>Envoyer</button>
                 </form>
                </div>";
    }

    public function renderCheckReturn() {
        $html = '';

        if ($this->data['success'] === true) {
            if ($this->data['late'] === true) {
                $html .= "<div>".$this->data['user_login']." a rendu ".$this->data['titre_doc']." mais l'a rendu en retard de ".$this->data['lateTime']." !</div>";
            } else {
                $html .= "<div>".$this->data['user_login']." a rendu ".$this->data['titre_doc']." dans les temps !</div>";
            }
        } else {
            $html .= "<div>Personne n'a emprunté ".$this->data['titre_doc']." !</div>";
        }

        $html .= "<div><a href='".$this->router::urlFor('viewReturn')."'>Ajouter un nouveau retour</a></div>";

        return $html;
    }

    protected function renderBody($selector) {
        $html = $this->renderHeader();
        switch ($selector){
            case "viewReturn":
                $html .= $this->renderReturn();
                break;
            case "checkReturn":
                $html .= $this->renderCheckReturn();
                break;
        }
        $html .= $this->renderFooter();
        return $html;
    }

}