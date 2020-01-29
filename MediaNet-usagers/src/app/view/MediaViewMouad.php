<?php
namespace app\view;

use app\model\Document;

class MediaViewMouad extends \mf\view\AbstractView {

    private $router;
    private $app_root;

    public function __construct($data = ''){
        parent::__construct($data);
        $this->router = new \mf\router\Router();
        $this->app_root = (new \mf\utils\HttpRequest())->root;
    }


    private function renderHeader(){
        $auth = new \app\auth\MediaAuthentification();

        $html = "<h1><a href='".$this->router::urlFor('home')."'>MediaNet-User</a></h1>";

        if ($auth->logged_in) {
            $html .= "<a href='".$this->router::urlFor('viewProfile')."'>Afficher profil</a><a href='".$this->router::urlFor('logout')."'>Se déconnecter</a>";
        } else {
            $html .= "<a href='".$this->router::urlFor('viewLogin')."'>Se connecter</a><a href='".$this->router::urlFor('viewSignup')."'>S'inscrire</a></div>";
        }
        return $html;
    }

    protected function renderFooter() {
        return "<footer>
                    <span>Nous contacter</span><span>medianancy@ciasie.fr</span><span>0312345678</span><span>1ter Boulevard Charlemagne</span>
                </footer>";
    }

    private function renderviewSearch(){
        error_reporting(0);
        return'
        <div class="renderviewSearch">
        <form action="'.\mf\router\Router::urlFor("searchResults",["document"=>$_GET["document"]]).'" method="get">
            <label for="document"> rechercher un document </label><br>
            <textarea class="textarea_mouad" name="document"></textarea><br>
        <button type="submit" value="submit" class="button_submit_mouad"> rechercher </button> 
        </form>
        </div>
';
    }

    /* affiche tous les resultats correspendants a la recherche executer dans le formulaire */
    private function rendersearchResults()
    {
        if (empty($this->data)) {
            return "aucun document ne correspond a votre recherche";
        } else {
            $table = "
            <div class='rendersearchResults'>
            <table><tr><th>titre</th><th>description</th><th>type</th><th>etat</th></tr>";
            foreach ($this->data as $document){
                $table .= "<tr>";
                $table .="<td> <a href='".\mf\router\Router::urlFor("viewDoc",["id"=>$document->id])."'>".$document->titre."</a></td>";
                $table .="<td>".$document->description."</td>";
                $table .="<td>".$document->type."</td>";
                $table .="<td>".$document->etat."</td>";
                $table .="</tr>";
            }
            $table .= "</table></div>";
            return "$table";
        }
    }


    protected function renderBody($selector) {
        $header = $this->renderHeader();
        $footer = $this->renderFooter();
        switch ($selector) {
            case "viewSearch":
                $body = $this->renderviewSearch();
                break;
            case "searchResults":
                $body = $this->rendersearchResults();
                break;
        }
        return <<<HTML
<div class="container_mouad">
<div class="head_mouad">
<header>
$header
</header>
</div>
<div class="body_mouad">
       <section>
          $body
       </section>
       </div>
       <div class="footer_mouad">
<footer>
$footer
</footer>
</div>
</div>
HTML;
    }
}