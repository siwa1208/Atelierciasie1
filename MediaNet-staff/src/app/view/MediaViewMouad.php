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


    public function renderHeader(){
        return "<header><h1><a href='".$this->router::urlFor('home')."'>MediaNet-Staff</a></h1></header>";
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
        <form action="'.\mf\router\Router::urlFor("searchDocumentshResults",["document"=>$_GET["document"]]).'" method="get">
            <label for="document"> rechercher un document </label><br>
            <textarea name="document"></textarea><br>
        <button type="submit" value="Submit"> rechercher </button> 
        </form>
        </div>
';
    }


    private function renderviewsearchUsers(){
        error_reporting(0);
        return'
        <div class="renderviewSearch">
        <form action="'.\mf\router\Router::urlFor("searchUsersResults",["user"=>$_GET["user"]]).'" method="get">
            <label for="user"> rechercher un usager </label><br>
            <textarea name="membre"></textarea><br>
        <button type="submit" value="Submit"> rechercher </button> 
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


    private function rendersearchUsersResults()
    {
        if (empty($this->data)) {
            return "aucun usager ne correspond a votre recherche";
        } else {
            $table = "
            <div class='rendersearchResults'>
            <table><tr><th>nom</th><th>prenom</th><th>adresse_mail</th></tr>";
            foreach ($this->data as $membre){
                $table .= "<tr>";
                $table .="<td> <a href='".\mf\router\Router::urlFor("viewProfile",["id"=>$membre->id])."'>".$membre->nom."</a></td>";
                $table .="<td>".$membre->prenom."</td>";
                $table .="<td>".$membre->adresse_mail."</td>";
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
            case "searchUsers":
                $body = $this->renderviewsearchUsers();
                break;
            case "searchUsersResults":
                $body = $this->rendersearchUsersResults();
                break;
            case "searchResults":
                $body = $this->rendersearchResults();
                break;
        }
        return <<<HTML
<div class="container_mouad">
$header
       <section>
          $body
       </section>
$footer
</div>
HTML;
    }
}