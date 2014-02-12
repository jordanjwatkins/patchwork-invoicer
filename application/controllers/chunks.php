<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chunks extends MY_Controller
{
	public $body_class = 'chunks';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Chunk_model');
		$this->load->model('Project_model');
		$this->load->model('Client_model');
	}

	public function add()
	{
		$project_id = $this->uri->segment(3, 0);
		$data['project'] = $this->Project_model->get_with_client($project_id);
		if ($this->input->post('create_chunk_submit')) {
			$newRecord['chunk_date'] = strtotime($this->input->post('chunk_date'));
			$newRecord['chunk_info'] = $this->input->post('chunk_info');
			$newRecord['chunk_hourly'] = $data['project']->client_hourly;
			$newRecord['project_id'] = $project_id;
			if ($this->input->post('flat_amount') || $this->input->post('flat_amount') === '0') {
				$newRecord['flat_amount'] = $this->input->post('flat_amount');
				$newRecord['chunk_hours'] = NULL;
			} else {
				$newRecord['chunk_hours'] = $this->input->post('chunk_hours');
				$newRecord['flat_amount'] = NULL;
			}
			$this->Chunk_model->insert($newRecord);
			redirect('projects/view/'.$project_id, 'location');
		} else {
			$data['title'] = 'Add Chunk | Invoicer';
			$data['contentView'] = 'chunks/add_chunk';
			$data['body_class'] = $this->body_class.' add_chunk';
			$this->load->view('template', $data);
		}
	}

	public function edit()
	{
		if ($this->input->post('update_chunk_submit')) {
			$body_class = 'chunk_update_success';
			$chunk_id = $this->uri->segment(3, 0);
			$project_id = $this->uri->segment(4, 0);
			$updatedRecord['chunk_date'] = strtotime($this->input->post('chunk_date'));
			$updatedRecord['chunk_info'] = $this->input->post('chunk_info');
			if ($this->input->post('flat_amount') || $this->input->post('flat_amount') === '0') {
				$updatedRecord['flat_amount'] = $this->input->post('flat_amount');
				$updatedRecord['chunk_hours'] = NULL;
			} else {
				$updatedRecord['chunk_hours'] = $this->input->post('chunk_hours');
				$updatedRecord['flat_amount'] = NULL;
			}
			$this->Chunk_model->update($chunk_id, $updatedRecord);
			redirect('projects/view/'.$project_id, 'location');
		} else {
			$body_class = 'edit_chunk';
			$data['title'] = 'Edit chunk | Invoicer';
			$data['contentView'] = 'chunks/edit_chunk';
			$data['body_class'] = $this->body_class.' '.'edit_chunk';
			$chunk_id = $this->uri->segment(3, 0);
			$data['chunk'] = $this->Chunk_model->get($chunk_id);
			$this->load->view('template', $data);
		}
	}
}