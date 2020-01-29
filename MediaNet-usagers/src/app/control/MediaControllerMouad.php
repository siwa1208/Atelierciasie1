<?php
namespace app\control;
use app\model\Document as document;
use app\view\MediaViewMouad as mediaViewmouad;
use mf\utils\HttpRequest;

class MediaControllerMouad extends \mf\control\AbstractController {

    public function __construct(){
        parent::__construct();
    }

    /* affiche le document recherche  */
    public function searchResults(){
        $requeteviewSearch = document::select()
            ->where("titre", "like" ,"%".$_GET["document"]."%")
            ->orWhere("description", "like" ,"%".$_GET["document"]."%")
            ->orderbY("id");
        $uniq = $requeteviewSearch->get();
        $viewSearch = new mediaViewmouad($uniq);
        $viewSearch->render("searchResults");
    }

    /* affiche le formulaire de recherche de document */
    public function viewSearch(){
        $viewSearch = new mediaViewmouad();
        $viewSearch->render("viewSearch");
    }
}