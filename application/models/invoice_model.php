<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invoice_model extends MY_Model
{
	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('America/Los_Angeles');
		$this->load->model('Project_model');
		$this->load->model('Client_model');
		$this->load->model('Chunk_model');
    }

	function next_invoice_number($client_id)
	{
		// get all of client's previous invoices
		$result = $this->order_by('invoice_number')->get_many_by('client_id', $client_id);

		// if no previous invoices, start at one, otherwise add one to last invoice's number
		if (!empty($result)) {
			$invoice_number = zerofill(end($result)->invoice_number + 1, 3);
		} else {
			$invoice_number = '001';
		}
		return $invoice_number;
	}

	// assembles a new invoice
	function get_new($client_id)
	{
		// get client and all child projects
		$invoice['client'] = $this->Client_model->get($client_id);
		$invoice['projects'] = $this->Project_model->order_by('project_name')->get_many_by('client_id', $client_id);

		foreach ($invoice['projects'] as $key => $project) {
			// get project's uninvoiced chunks
			$this->db->where('invoiced', 0)->order_by('chunk_date', 'desc');
			$project->chunks = $this->Chunk_model->get_many_by('project_id', $project->project_id);

			if (empty($project->chunks)) {
				unset($invoice['projects'][$key]);  // remove project if it doesn't have any uninvoiced chunks
			} else {
				// total hours for each hourly rate
				foreach ($project->chunks as $chunk) {
					if (empty($project->hourly_hours[$chunk->chunk_hourly])) {
						$project->hourly_hours[$chunk->chunk_hourly] = $chunk->chunk_hours;
					} else {
						$project->hourly_hours[$chunk->chunk_hourly] += $chunk->chunk_hours;
					}
					$project->flat_amount += $chunk->flat_amount;
				}
			}
		}
		return $invoice;
	}

	// rebuild an already created invoice
	function get_full($invoice_id)
	{
		// get client and all child projects
		$invoice = $this->Invoice_model->get($invoice_id);
		$invoice->client = $this->Client_model->get($invoice->client_id);
		$invoice->projects = $this->Project_model->get_unique_by_invoice_id($invoice_id);

		if(!empty($invoice->projects)){
			foreach($invoice->projects as $project){
				// get chunks by invoice and project ids
				$this->db->where('invoice_id', $invoice_id)->order_by('chunk_date', 'desc');
				$project->chunks = $this->Chunk_model->get_many_by('project_id', $project->project_id);

				// total hours for each hourly rate
				foreach($project->chunks as $chunk){
					if (empty($project->hourly_hours[$chunk->chunk_hourly])) {
						$project->hourly_hours[$chunk->chunk_hourly] = $chunk->chunk_hours;
					} else {
						$project->hourly_hours[$chunk->chunk_hourly] += $chunk->chunk_hours;
					}
					$project->flat_amount += $chunk->flat_amount;
				}
			}
		}
		return $invoice;
	}

	function paid_by_client($client_id)
	{
		$this->db->where('paid', 'paid');
		return $this->get_all();
	}

	function unpaid_by_client($client_id)
	{
		$this->db->select('invoice_id')
		->where('paid', '')
		->where('client_id', $client_id);

		return $this->get_all();
	}

	function set_paid($invoice_id)
	{
		$this->db->where('invoice_id', $invoice_id)
			->set('paid', 'paid')
			->update('invoices');
	}

	function set_unpaid($invoice_id)
	{
		$this->db->where('invoice_id', $invoice_id)
			->set('paid', '')
			->update('invoices');
	}
}