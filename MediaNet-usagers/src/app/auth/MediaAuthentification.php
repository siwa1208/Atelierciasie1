<?php
namespace app\auth;

class MediaAuthentification extends \mf\auth\Authentification {
    
    const ACCESS_LEVEL_USER = 1;

    public function __construct(){
        parent::__construct();
    }

    public function createUser($nom, $prenom, $adresse_mail, $telephone, $pass, $level=self::ACCESS_LEVEL_USER) {
        $db_membre = \app\model\Membre::where('adresse_mail','=',$adresse_mail)->first();
        if (isset($db_membre)){
            new \mf\auth\exception\AuthentificationException();
        }else{
            $membre = new \app\model\Membre();
            $membre->nom = $nom;
            $membre->prenom = $prenom;
            $membre->adresse_mail = $adresse_mail;
            $membre->telephone = $telephone;
            $membre->password = parent::hashPassword($pass);
            $membre->level = $level;
            $membre->save();
        }
    }

    public function loginUser($adresse_mail, $password){
        $db_membre = \app\model\Membre::where('adresse_mail','=',$adresse_mail)->first();
        if (isset($db_membre)){
            $this->login($db_membre->adresse_mail, $db_membre->password, $password, $db_membre->level);
        }else{
            \mf\router\Router::executeRoute('viewLogin');
            new \mf\auth\exception\AuthentificationException();
        }
    }

    public function logout(){
        parent::logout();
    }

}
