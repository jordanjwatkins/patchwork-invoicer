<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Client_model extends MY_Model
{
	function __construct()
	{
		parent::__construct();
    }

	function get_with_projects_and_chunks($id)
	{
		$this->db->select('clients.*, projects.*, chunks.*');
		$this->db->where('clients.client_id = ' . $id);
		$this->db->join('projects', 'projects.client_id = clients.client_id','inner');
		$this->db->join('chunks', 'chunks.project_id = projects.project_id','inner');
		$query = $this->db->get('clients');
		return $query->result();
	}

	function get_unique_with_uninvoiced_chunks()
	{
		$this->db->select('clients.client_id, clients.company_name, chunks.invoiced, clients.client_number');
		$this->db->where('chunks.invoiced = 0');
		$this->db->join('projects', 'projects.client_id = clients.client_id');
		$this->db->join('chunks', 'chunks.project_id = projects.project_id');
		$query = $this->db->get('clients');
		$records = $query->result();
		$clients = array();
		foreach ($records as $row) {
			$client = get_object_vars($row);
			$client['invoice_number'] = $client['client_number'].$this->Invoice_model->next_invoice_number($client['client_id']);
			$clients[] = $client;
		}
		return array_unique($clients, SORT_REGULAR);
	}

	function company_names()
	{
		$this->db->select('client_id, company_name');
		return $this->get_all();
	}
}