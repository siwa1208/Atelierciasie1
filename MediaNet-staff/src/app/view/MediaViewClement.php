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

    public function renderHeader(){
        return "<header><h1><a href='".$this->router::urlFor('home')."'>MediaNet-Staff</a></h1></header>";
    }

    public function renderProfile() {
        $html = "<div class='profile-container'>
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

        $html .= "</div>";

        return $html;
    }

    public function renderDoc() {
        $doc = \app\model\Document::select()->where('id', '=', $_GET['id'])->first();

        $html = "<div class='document-description-container'>
                    <img src='".$doc->img."'>
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
                </div>
                
                <div class='document-state-container'>
                    <span class='document-label'>État : </span><span class='document-content'>".$doc->etat."</span>";

        $html .= "</div>";

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