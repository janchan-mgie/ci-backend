<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Temp extends CI_Controller {
	public function index()
	{
		echo '<pre>';

    $this->load->model('backend/photo_model', 'photo');
    // print_r($this->photo->get(1));
    $this->load->model('backend/guest_model', 'guest');
    // print_r($this->guest->get(1));

    $this->load->model('backend/guest_photo_model', 'guest_photo');

    print_r($this->guest_photo->with_guest()->with_photo()->get_all());
	}
}
