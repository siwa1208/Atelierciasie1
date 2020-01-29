<?php
namespace app\control;

class MediaControllerClement extends \mf\control\AbstractController {
    public function __construct() {
        parent::__construct();
    }

    public function viewProfile() {
        $auth = new \app\auth\MediaAuthentification();

        $user = \app\model\Membre::select()->where('adresse_mail', '=', $auth->user_login)->first();
        $view = new \app\view\MediaViewClement($user);
        $view->render('viewProfile');
    }

    public function viewDoc() {
        $doc_id = $_GET['id'];
        $_SESSION['id_doc'] = $_GET['id'];

        $doc = \app\model\Document::select()->where('id', '=', $doc_id)->first();
        $view = new \app\view\MediaViewClement($doc);
        $view->render('viewDoc');
    }
}