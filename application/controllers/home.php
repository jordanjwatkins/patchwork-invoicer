<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller
{
	public function index()
	{
		$this->data['title'] = 'Invoicer';
		$this->data['contentView'] = 'home';
		$this->data['body_class'] = 'home';
		$this->load->view('template', $this->data);
	}
}