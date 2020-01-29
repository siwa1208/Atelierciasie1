<?php
namespace app\control;

class MediaControllerJonathan extends \mf\control\AbstractController {

    public function __construct(){
        parent::__construct();
    }

    public function viewBorrow() {
        $view = new \app\view\MediaViewJonathan();
        $view->render('viewBorrow');
    }

    public function checkBorrow(){
        $currentDate = new \DateTime();
        $currentDateFormatted = $currentDate->format('Y-m-d');
        $date_transmise = new \DateTime($currentDateFormatted);
        $date_retour_prevue = $date_transmise->modify('+2 weeks');
        $vue = null;

        try {
            $this->updateBorrow($_POST['id_membre'], $_POST['id_document'], $currentDateFormatted, $date_retour_prevue);
            $borrow_data = [
                'user_login' => \app\model\Membre::select()->where('id', '=', $_POST['id_membre'])->first()->adresse_mail,
                'titre_doc' => \app\model\Document::select()->where('id', '=', $_POST['id_document'])->first()->titre,
                'success' => true
            ];
            $vue = new \app\view\MediaViewJonathan($borrow_data);
        } catch (\Exception $e) {
            $borrow_data = [
                'titre_doc' => \app\model\Document::select()->where('id', '=', $_POST['id_document'])->first()->titre,
                'success' => false
            ];
            $vue = new \app\view\MediaViewJonathan($borrow_data);
        }

        $vue->render('checkBorrow');
    }

    private function updateBorrow($id_membre, $id_doc, $date_borrow, $date_retour_prevue) {
        $doc = \app\model\Document::select()->where('id', '=', $id_doc)->first();

        if ($doc->etat === 'disponible') {
            $doc->id_membre = $id_membre;
            $doc->etat = 'indisponible';
            $doc->save();

            $emprunt = new \app\model\Emprunt();
            $emprunt->id_document = $id_doc;
            $emprunt->id_membre = $id_membre;
            $emprunt->date_emprunt = $date_borrow;
            $emprunt->date_retour_prevu = $date_retour_prevue;
            $emprunt->save();
        } else {
            throw new \Exception();
        }
    }
}