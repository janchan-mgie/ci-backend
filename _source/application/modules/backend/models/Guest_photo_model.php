<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guest_photo_model extends Base_Model {
  public $fillable = array('id', 'photo_id', 'guest_id', 'saved');
  public $protected = array('created_at', 'updated_at', 'delete_at');
	public $table = 'guest_photo';
  public $rules = array(
    'insert' => array(
      'guest_id' => array(
        'field'=>'guest_id',
        'label'=>'Guest',
        'rules'=>'required'
      ),
      'photo_id' => array(
        'field'=>'photo_id',
        'label'=>'Photo',
        'rules'=>'required'
      ),
    ),
    'update' => array(
      'guest_id' => array(
        'field'=>'guest_id',
        'label'=>'Guest',
        'rules'=>'required'
      ),
      'photo_id' => array(
        'field'=>'photo_id',
        'label'=>'Photo',
        'rules'=>'required'
      ),
      'saved' => array(
        'field'=>'saved',
        'label'=>'Saved',
        'rules'=>'required'
      ),
    ),
  );
  //
	public function __construct() {
		$this->has_one['guest'] = array('Guest_model','id','guest_id');
		$this->has_one['photo'] = array('Photo_model','id','photo_id');
		parent::__construct();
  }
	protected function has_delete_right($data) {
		if (!$this->ion_auth->is_admin()) {
			$this->core_model->where('guest_id', $this->ion_auth->user()->row()->id);
			$this->core_model->where('id', $data['id']);
			if ($this->core_model->count_rows() === 0) {
				return FALSE;
			}
		}
		return TRUE;
	}
}
