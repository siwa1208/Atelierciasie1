<?php
namespace app\model;

class Emprunt extends \Illuminate\Database\Eloquent\Model {
    protected $table = 'emprunt';
    protected $primaryKey = 'id_document';
    public $timestamps = true;
}