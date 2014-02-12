<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project_model extends MY_Model
{
	function __construct()
	{
		parent::__construct();
    }

	function get_all_active()
	{
		$query = $this->db->select('*')
			->from('projects')
			->where('active', 1)
			->get();
		return $query->result();
	}

	function get_all_inactive()
	{
		$query = $this->db->select('*')
			->from('projects')
			->where('active', 0)
			->get();
		return $query->result();
	}

	function list_all_active_with_company_name()
	{
		$query = $this->db->select('projects.project_id, projects.project_name, projects.active, clients.company_name')
			->from('projects')
			->where('active', 1)
			->join('clients', 'projects.client_id = clients.client_id')
			->get();
		return $query->result();
	}

	function list_all_inactive_with_company_name()
	{
		$query = $this->db->select('projects.project_id, projects.project_name, projects.active, clients.company_name')
			->from('projects')
			->where('active', 0)
			->join('clients', 'projects.client_id = clients.client_id')
			->get();
		return $query->result();
	}

	function get_all_with_client()
	{
		$query = $this->db->select('projects.*, clients.*')
			->from('projects')
			->join('clients', 'projects.client_id = clients.client_id')
			->get();
		return $query->result();
	}

	function get_with_client($id)
	{
		$query = $this->db->select('projects.*, clients.*')
			->from('projects')
			->where('project_id', $id)
			->join('clients', 'projects.client_id = clients.client_id')
			->get();
		return $query->row();
	}

	function get_unique_by_invoice_id($invoice_id)
	{
		$projectChunks = $this->Chunk_model->get_many_by('invoice_id', $invoice_id);
		foreach ($projectChunks as $projectChunk) {
			$projectIDs[] = $projectChunk->project_id;
		}
		if (!empty($projectIDs)) {
			sort($projectIDs);
			$projectIDs = array_unique($projectIDs, SORT_NUMERIC);
			$projects = $this->order_by('project_name')->get_many($projectIDs);
			return $projects;
		}
	}

	function activate($project_id)
	{
		$query = $this->db->set('active', 1)
			->where('project_id', $project_id)
			->update('projects');
	}

	function deactivate($project_id)
	{
		$query = $this->db->set('active', 0)
			->where('project_id', $project_id)
			->update('projects');
	}

	function projects_by_client($client_id)
	{
		$this->db->select('project_id, project_name')
			->where('client_id', $client_id)
			->order_by('project_name', 'ASC');
		return $this->get_all();
	}
}