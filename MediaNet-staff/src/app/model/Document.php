<?php
namespace app\model;

class Document extends \Illuminate\Database\Eloquent\Model {
    protected $table = 'document';
    protected $primaryKey = 'id';
    public $timestamps = false;
}