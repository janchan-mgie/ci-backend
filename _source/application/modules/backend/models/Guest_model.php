<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guest_model extends Base_Model {
  // public $fillable = array('firstname', 'lastname');
  // public $protected = array('id', 'created_at', 'updated_at', 'delete_at', 'email');
  public $rules = array(
    'insert' => array(
      'firstname' => array(
        'field'=>'firstname',
        'label'=>'First Name',
        'rules'=>'trim|required'
      ),
      'lastname' => array(
        'field'=>'lastname',
        'label'=>'Last Name',
        'rules'=>'trim|required'
      ),
    ),
    'update' => array(
      'firstname' => array(
        'field'=>'firstname',
        'label'=>'First Name',
        'rules'=>'trim|required'
      ),
      'lastname' => array(
        'field'=>'lastname',
        'label'=>'Last Name',
        'rules'=>'trim|required'
      ),
    ),
  );
}
