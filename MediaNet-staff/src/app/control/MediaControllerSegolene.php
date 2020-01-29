<?php
namespace app\control;

class MediaControllerSegolene extends \mf\control\AbstractController {
	public function viewHome(){
        $vue = new \app\view\MediaViewSegolene();
        $vue->render('home');
	}
}