<?php
namespace app\control;

class MediaControllerAdair extends \mf\control\AbstractController {

    public function __construct(){
        parent::__construct();
    }

    public function viewReturn() {
        $view = new \app\view\MediaViewAdair();
        $view->render('viewReturn');
    }

    public function checkReturn() {
        $lateChecker = false;
        $date_rendu_prevue = \app\model\Emprunt::select()->where('id_document', '=', $_POST['id_document'])
                                                        ->where('id_membre', '=', $_POST['id_membre'])
                                                        ->orderBy('created_at', 'desc')
                                                        ->first()
                                                        ->date_retour_prevu;

        $date_rendu_prevue_object = new \DateTime($date_rendu_prevue);
        $vue = null;

        $diffDates = $date_rendu_prevue_object->diff(new \DateTime());
        $diffDatesFormatted = $diffDates->format('%R%a days');

        if (substr($diffDatesFormatted, 0, 1) === "+") {
            $lateChecker = true;
        } else if (substr($diffDatesFormatted, 0, 1) === "-") {
            $lateChecker = false;
        }

        try {
            $this->updateBorrow($_POST['id_document']);
            $borrow_data = [
                'user_login' => \app\model\Membre::select()->where('id', '=', $_POST['id_membre'])->first()->adresse_mail,
                'titre_doc' => \app\model\Document::select()->where('id', '=', $_POST['id_document'])->first()->titre,
                'late' => $lateChecker,
                'lateTime' => substr($diffDatesFormatted, 1),
                'success' => true
            ];
            $vue = new \app\view\MediaViewAdair($borrow_data);
        } catch (\Exception $e) {
            $borrow_data = [
                'titre_doc' => \app\model\Document::select()->where('id', '=', $_POST['id_document'])->first()->titre,
                'success' => false
            ];
            $vue = new \app\view\MediaViewAdair($borrow_data);
        }

        $vue->render('checkReturn');
    }

    private function updateBorrow($id_doc) {
        $doc = \app\model\Document::select()->where('id', '=', $id_doc)->first();

        if ($doc->etat === 'indisponible') {
            $doc->id_membre = null;
            $doc->etat = 'disponible';
            $doc->save();
        } else {
            throw new \Exception();
        }
    }
}