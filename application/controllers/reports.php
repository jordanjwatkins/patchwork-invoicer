<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends MY_Controller
{
	public $body_class = 'reports';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Project_model');
		$this->load->model('Client_model');
		$this->load->model('Chunk_model');
		$this->load->model('Report_model');
	}

	public function index()
	{
		$data['title'] = 'Reports | Invoicer';
		$data['contentView'] = 'reports/reports';
		$data['body_class'] = $this->body_class;
		$data['clients'] = $this->Client_model->company_names();
		$this->load->view('template', $data);
	}

	public function view()
	{
		$data['title'] = 'View Report | Invoicer';
		$data['contentView'] = 'reports/view_report';
		$data['body_class'] = $this->body_class . ' view_report';
		$client_id = $this->uri->segment(3, 0);
		$data['project_id'] = $this->input->post('project');
		$data['client']->projects = $this->Project_model->projects_by_client($client_id);
		$data['report'] = $this->Report_model->report($client_id, $data['project_id']);
		$data['range_start'] = $this->_date_select('range_start', 0, $client_id);
		$data['range_end'] = $this->_date_select('range_end');
		$this->load->view('template', $data);
	}
}