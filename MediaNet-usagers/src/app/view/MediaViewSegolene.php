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
        $auth = new \app\auth\MediaAuthentification();

        $html = "<h1><a href='".$this->router::urlFor('home')."'>MediaNet-User</a></h1>";

        if ($auth->logged_in) {
            $html .= "<a href='".$this->router::urlFor('viewProfile')."'>Afficher profil</a><a href='".$this->router::urlFor('logout')."'>Se déconnecter</a>";
        } else {
            $html .= "<a href='".$this->router::urlFor('viewLogin')."'>Se connecter</a><a href='".$this->router::urlFor('viewSignup')."'>S'inscrire</a>";
        }
        return $html;
    }

    protected function renderFooter() {
        return "<span>Nous contacter</span><span>medianancy@ciasie.fr</span><span>0312345678</span><span>1ter Boulevard Charlemagne</span>";
    }

    public function renderHome(){
    	$app_root = (new \mf\utils\HttpRequest())->root;
    	$router = new \mf\router\Router();
		$link_search = $this->router::urlFor('viewSearch','');
    	$img = "<img src =".$app_root."/css/img/medianet.jpg>";
    	$titre = "Histoire de la Médiathèque";
    	$text ="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque dapibus pellentesque ligula, nec pretium urna venenatis vel. Sed accumsan, lorem ac commodo viverra, metus risus pulvinar erat, id ultricies enim quam eu erat. Duis viverra orci et risus luctus, ut sodales ligula posuere. Mauris ex elit, ultricies eget odio vel, aliquam posuere elit. Praesent sodales nec nisi non aliquet. Mauris venenatis ultrices eros, id lobortis dolor condimentum et. Duis aliquet gravida vulputate. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque dapibus pellentesque ligula, nec pretium urna venenatis vel. Sed accumsan, lorem ac commodo viverra, metus risus pulvinar erat, id ultricies enim quam eu erat. Duis viverra orci et risus luctus, ut sodales ligula posuere. Mauris ex elit, ultricies eget odio vel, aliquam posuere elit. Praesent sodales nec nisi non aliquet. Mauris venenatis ultrices eros, id lobortis dolor condimentum et. Duis aliquet gravida vulputate.";
    	$textButton = " Pour commencer à consulter les ressources pensez à faire une recherche afin d'y voir la disponibilité du document.";
    	$button = '<a href="'.$link_search.'">Rechercher</a>';
    	$html = <<<EOT
<div class = "container_home">
    <div>
        {$img}
    </div>
    <div>
        <h1>{$titre}</h1>
        <p>{$text}</p>
    </div>
    <div>
    	<p>{$textButton}</p>
    	<button type='button'>{$button}</button>
    </div>
</div>
EOT;
        return $html;}

  	public function renderCalendar(){
        $doc = \app\model\Document::select()->where('id', '=', $_GET['id'])->first();

    	$title = "<h3> Emprunt d'un document </h3>";
    	$calendar = "<form action='".$this->router->urlFor('checkBorrow')."' method='post'>
                        <input type='date' id='date' name='date-borrow'>
                        <button type='submit' class='button' value='Valider'>Confirmer</button>
                     </form>";
    	$text = "Quand comptez-vous venir chercher votre document ?";
    	$html = <<<EOT
<div class = "container_calendar">
	<div class = "picture">
		{$title}
		<img src="{$doc->img}">
	</div>
	<div class="liste">
		<ul>
			<li><label for="titre">{$doc->titre}</label></li>
            <br>
			<li><label for="type">{$doc->type}</label></li>
            <br>
			<li><label for="genre">{$doc->genre}</label></li>
	</div>
	<div class="calendrier">
		<label for="date">{$text}</label>
		<br>
		{$calendar}
		<br>
	</div>
</div>
EOT;

	return $html;	
  	}

  	public function renderConfirmBorrow(){
    	$text = "Merci ".$this->data['user_login']." d'avoir emprunté ".$this->data['titre_doc']." !";
    	$html = <<<EOT
<div class="container_borrow">
    <div>
    	<p>{$text}</p>
    </div>
</div>
EOT;
        return $html;}

    protected function renderBody($selector){
    	$header = $this->renderHeader();
        $footer = $this->renderFooter();
        switch ($selector) {
            case "viewCalendar":
                $section = $this->renderCalendar();
                break;
            case "confirmBorrow":
                $section = $this->renderConfirmBorrow();
                break;
            default :
            	$section = $this->renderHome();
        }    

        $html = <<<EOT
<header>
    ${header}
</header>
<section>
    ${section}
</section>
<footer>
    ${footer}
</footer>
EOT;
        return $html;}
}