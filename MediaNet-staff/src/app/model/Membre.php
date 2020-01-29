<?php
namespace app\model;

class Membre extends \Illuminate\Database\Eloquent\Model {
    protected $table = 'membre';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function currentBorrows() {
        return $this->hasMany('\app\model\Document', 'id_membre');
    }

    public function allBorrows() {
        return $this->hasMany('\app\model\Emprunt', 'id_membre');
    }
}