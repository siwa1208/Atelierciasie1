<?php
namespace app\control;
use app\model\Document as document;
use app\model\Membre as membre;
use app\view\MediaViewMouad as mediaViewmouad;
use mf\utils\HttpRequest;

class MediaControllerMouad extends \mf\control\AbstractController {

    public function __construct(){
        parent::__construct();
    }

    /* affiche le document recherche  */
    public function searchDocumentshResults(){
        $requeteviewSearch = document::select()
            ->where("titre", "like" ,"%".$_GET["document"]."%")
            ->orWhere("description", "like" ,"%".$_GET["document"]."%")
            ->orderbY("id");
        $uniq = $requeteviewSearch->get();
        $viewSearch = new mediaViewmouad($uniq);
        $viewSearch->render("searchResults");
    }

    public function searchDocuments(){
        $viewSearch = new mediaViewmouad();
        $viewSearch->render("viewSearch");
    }

    public function searchUsers(){
        $viewSearch = new mediaViewmouad();
        $viewSearch->render("searchUsers");
    }

    public function searchUsersResults(){
        $requeteviewSearch = membre::select()
            ->where("nom", "like" ,"%".$_GET["membre"]."%")
            ->orWhere("prenom", "like" ,"%".$_GET["membre"]."%")
            ->orderbY("id");
        $uniq = $requeteviewSearch->get();
        $viewSearch = new mediaViewmouad($uniq);
        $viewSearch->render("searchUsersResults");
    }
}