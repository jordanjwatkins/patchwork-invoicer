<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clients extends MY_Controller
{
	public $body_class = 'clients';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Client_model');
	}

	public function index()
	{
		$body_class = 'clients';
		$data = array();
		if ($query = $this->Client_model->get_all()) {
			$data['records'] = $query;
		}
		$data['title'] = 'Clients | Invoicer';
		$data['contentView'] = 'clients/clients';
		$data['body_class'] = $this->body_class.' '.$body_class;
		$this->load->view('template', $data);
	}

	public function add_success()
	{
		$body_class = 'add_success';
		$data['title'] = 'Client Created | Invoicer';
		$data['contentView'] = 'clients/client_add_success';
		$data['body_class'] = $this->body_class.' '.$body_class;
		$this->load->view('template', $data);
	}

	public function add()
	{
		$body_class = 'add_client';
		if ($this->input->post('create_client_submit')) {
			$newRecord['company_name'] = $this->input->post('company_name');
			$newRecord['contact_first_name'] = $this->input->post('contact_first_name');
			$newRecord['contact_last_name'] = $this->input->post('contact_last_name');
			$newRecord['client_hourly'] = $this->input->post('client_hourly');
			$newRecord['client_number'] = $this->input->post('client_number');
			$this->Client_model->insert($newRecord);
			redirect('clients/add_success');
		} else {
			$data['title'] = 'Add Client | Invoicer';
			$data['contentView'] = 'clients/add_client';
			$data['body_class'] = $this->body_class.' '.$body_class;
			$this->load->view('template', $data);
		}
	}

	public function edit()
	{
		if ($this->input->post('update_client_submit')) {
			$body_class = 'client_update_success';
			$client_id = $this->uri->segment(3, 0);
			$updatedRecord['company_name'] = $this->input->post('company_name');
			$updatedRecord['contact_first_name'] = $this->input->post('contact_first_name');
			$updatedRecord['contact_last_name'] = $this->input->post('contact_last_name');
			$updatedRecord['client_hourly'] = $this->input->post('client_hourly');
			$updatedRecord['client_number'] = $this->input->post('client_number');
			$this->Client_model->update($client_id, $updatedRecord);
			$data['title'] = 'Client Updated | Invoicer';
			$data['contentView'] = 'clients/edit_client';
			$data['body_class'] = $this->body_class.' '.$body_class;
			$data['updateSuccess'] = 1;
			$this->load->view('template', $data);
		} else {
			$body_class = 'edit_client';
			$data['title'] = 'Edit Client | Invoicer';
			$data['contentView'] = 'clients/edit_client';
			$data['body_class'] = $this->body_class.' '.$data['contentView'];
			$client_id = $this->uri->segment(3, 0);
			$data['records'] = $this->Client_model->get($client_id);
			$this->load->view('template', $data);
		}
	}
}