<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chunk_model extends MY_Model
{
	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('America/Los_Angeles');
    }

	function invoice_chunks($client_id, $invoice_id)
	{
		$clients = $this->Client_model->get($client_id);
		$projects = $this->Project_model->get_many_by('client_id', $client_id);
		foreach ($projects as $project) {
			$this->db->where('invoiced', 0);
			$chunks = $this->get_many_by('project_id', $project->project_id);
			foreach ($chunks as $chunk) {
				$updateRecord['invoiced'] = 1;
				$updateRecord['invoice_id'] = $invoice_id;
				$this->update($chunk->chunk_id, $updateRecord);
			}
		}
	}

	function years_by_client($client_id)
	{
		$this->db->select('chunk_date')->where('client_id', $client_id);
		$this->get_all();
	}

	function deinvoice_chunks($invoice_id)
	{
		// TODO: check if last added invoice, otherwise do nothing
		$this->db->where('invoice_id', $invoice_id);
		$chunks = $this->get_all();
		foreach ($chunks as $chunk) {
			$updateRecord['invoiced'] = 0;
			$updateRecord['invoice_id'] = null;
			$this->update($chunk->chunk_id, $updateRecord);
		}
		$this->db->delete('invoices', array('invoice_id'=>$invoice_id));
	}
}