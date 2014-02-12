<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Projects extends MY_Controller
{
	public $body_class = 'projects';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Project_model');
		$this->load->model('Client_model');
		$this->load->model('Chunk_model');
	}

	public function index()
	{
		$body_class = 'projects';
		$data['active_projects'] = $this->Project_model->order_by('project_name')->list_all_active_with_company_name();
		$data['inactive_projects'] = $this->Project_model->order_by('project_name')->list_all_inactive_with_company_name();
		$data['title'] = 'Projects | Invoicer';
		$data['contentView'] = 'projects/projects';
		$data['body_class'] = $this->body_class.' '.$body_class;
		$this->load->view('template', $data);
	}

	public function view()
	{
		$body_class = 'view_project';
		$project_id = $this->uri->segment(3, 0);
		if ($query = $this->Project_model->get_with_client($project_id)) {
			$data['project'] = $query;
		}
		if ($query = $this->Chunk_model->order_by('chunk_date', 'DESC')->get_many_by('project_id', $project_id)) {
			$data['chunks'] = $query;
		}
		$data['title'] = 'View Project | Invoicer';
		$data['contentView'] = 'projects/view_project';
		$data['body_class'] = $this->body_class.' '.$body_class;
		$this->load->view('template', $data);
	}

	public function add()
	{
		$body_class = 'add_project';
		if ($query = $this->Client_model->get_all()) {
			$data['clients'] = $query;
		}
		if ($this->input->post('create_project_submit')) {
			$newRecord['project_name'] = $this->input->post('project_name');
			$newRecord['project_info'] = $this->input->post('project_info');
			$newRecord['active'] = 1;
			$newRecord['client_id'] = $this->input->post('client_id');
			$this->Project_model->insert($newRecord);
			redirect('projects');
		} else {
			$data['title'] = 'Add Project | Invoicer';
			$data['contentView'] = 'projects/add_project';
			$data['body_class'] = $this->body_class.' '.$body_class;
			$this->load->view('template', $data);
		}
	}

	public function edit()
	{
		if ($this->input->post('update_project_submit')) {
			$project_id = $this->uri->segment(3, 0);
			$updatedRecord['project_name'] = $this->input->post('project_name');
			$updatedRecord['project_info'] = $this->input->post('project_info');
			$this->input->post('active') ? $updatedRecord['active'] = 1 : $updatedRecord['active'] = 0;
			$this->Project_model->update($project_id, $updatedRecord);
			redirect('projects/view/'.$project_id, 'location');
		} else {
			$body_class = 'edit_project';
			$data['title'] = 'Edit Project | Invoicer';
			$data['contentView'] = 'projects/edit_project';
			$data['body_class'] = $this->body_class.' '.$data['contentView'];
			$project_id = $this->uri->segment(3, 0);
			$data['project'] = $this->Project_model->get($project_id);
			$this->load->view('template', $data);
		}
	}

	function activate()
	{
		$project_id = $this->uri->segment(3, 0);
		$this->Project_model->activate($project_id);
		redirect('projects', 'location');
	}

	function deactivate()
	{
		$project_id = $this->uri->segment(3, 0);
		$this->Project_model->deactivate($project_id);
		redirect('projects', 'location');
	}
}