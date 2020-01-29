<?php
namespace app\control;

class MediaControllerSegolene extends \mf\control\AbstractController {
	public function viewHome(){
        $vue = new \app\view\MediaViewSegolene();
        $vue->render('home');
	}
	public function viewCalendar(){
		$doc_id = $_GET['id'];
		
		$doc = \app\model\Document::where('id', '=', $doc_id)->first();
		$vue = new \app\view\MediaViewSegolene($doc);
        $vue->render('viewCalendar');
	}
	public function checkBorrow(){
        $auth = new \app\auth\MediaAuthentification();
        $id_membre = \app\model\Membre::select()->where('adresse_mail', '=', $auth->user_login)->first()->id;
        $borrow_data = [
            'user_login' => $auth->user_login,
            'titre_doc' => \app\model\Document::select()->where('id', '=', $_SESSION['id_doc'])->first()->titre
        ];

        $date_transmise = new \DateTime($_POST['date-borrow']);
        $date_retour_prevue = $date_transmise->modify('+2 weeks');

        $this->updateBorrow($id_membre, intval($_SESSION['id_doc']), $_POST['date-borrow'], $date_retour_prevue);

		$vue = new \app\view\MediaViewSegolene($borrow_data);
        $vue->render('confirmBorrow');
	}

	private function updateBorrow($id_membre, $id_doc, $date_borrow, $date_retour_prevue) {
	    $emprunt = new \app\model\Emprunt();
	    $emprunt->id_document = $id_doc;
	    $emprunt->id_membre = $id_membre;
	    $emprunt->date_emprunt = $date_borrow;
	    $emprunt->date_retour_prevu = $date_retour_prevue;
	    $emprunt->save();

	    $doc = \app\model\Document::select()->where('id', '=', $id_doc)->first();
	    $doc->id_membre = $id_membre;
	    $doc->etat = 'indisponible';
	    $doc->save();
    }
}