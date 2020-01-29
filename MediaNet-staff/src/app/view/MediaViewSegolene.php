<?php
namespace app\view;

class MediaViewSegolene extends \mf\view\AbstractView {

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

    public function renderHome(){
        return "<div class='home-btn-container'>
                    <div>
                        <a href='".$this->router::urlFor('searchUsers')."'>
                            <img src='../../css/img/user.png'>
                            <div>Rechercher un usager</div>
                        </a>    
                    </div>
                    <div>
                        <a href='".$this->router::urlFor('searchDocuments')."'>
                            <img src='../../css/img/searchbutton.png'>
                            <div>Rechercher un document</div>
                        </a>    
                    </div>
                    <div>
                        <a href='".$this->router::urlFor('viewBorrow')."'>
                            <img src='../../css/img/borrowbutton.png'>
                            <div>Gérer un emprunt</div>
                        </a>    
                    </div>
                    <div>
                        <a href='".$this->router::urlFor('viewReturn')."'>
                            <img src='../../css/img/returnbutton.png'>
                            <div>Gérer un rendu</div>
                        </a>    
                    </div>
                </div>";
    }

    protected function renderBody($selector){
    	$header = $this->renderHeader();
        $footer = $this->renderFooter();
        switch ($selector) {
            case 'home':
                $section = $this->renderHome();
                break;
            default :
            	$section = $this->renderHome();
        }    

        $html = <<<EOT
                ${header}
            <section>
                ${section}
            </section>
                ${footer}
EOT;
        return $html;}
}