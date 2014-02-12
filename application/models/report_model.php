<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report_model extends MY_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Project_model');
		$this->load->model('Client_model');
		$this->load->model('Chunk_model');
		$this->load->model('Invoice_model');
    }

	public function report($client_id, $project_id = null)
	{
		if (empty($project_id)) {
			$report->projects = $this->Project_model->projects_by_client($client_id);
		} else {
			$this->db->select('project_id, project_name')
				->order_by('project_name', 'ASC');
			$report->projects[] = $this->Project_model->get($project_id);
		}
		$report->grand_totals->hours = 0;
		$report->grand_totals->amount = 0;
		$report->unpaid_totals->hours = 0;
		$report->unpaid_totals->amount = 0;
		$report->paid_totals->hours = 0;
		$report->paid_totals->amount = 0;
		$years = array();
		foreach ($report->projects as $project) {
			$this->db->select_sum('(chunk_hourly*chunk_hours)', 'project_total')
				->select_sum('chunk_hours', 'project_hours')
				->where('invoiced', 1)
				->where('project_id', $project->project_id);
			$totals = $this->Chunk_model->get_all();
			$project->total->hours = $totals[0]->project_hours;
			$project->total->amount = $totals[0]->project_total;
			$report->grand_totals->hours += $totals[0]->project_hours;
			$report->grand_totals->amount += $totals[0]->project_total;
			$this->db->select('chunk_date')
				->where('invoiced', 1)
				->where('project_id', $project->project_id);
				$dates = $this->Chunk_model->get_all();
			$years[] = $dates;
		}

		$unpaid_invoices = $this->Invoice_model->unpaid_by_client($client_id);
		foreach ($unpaid_invoices as $invoice) {
			$this->db->select('chunk_hourly, chunk_hours');
			$chunks = $this->Chunk_model->get_many_by('invoice_id',$invoice->invoice_id);
			foreach ($chunks as $chunk) {
				$report->unpaid_totals->hours += $chunk->chunk_hours;
				$report->unpaid_totals->amount += ($chunk->chunk_hourly * $chunk->chunk_hours);
			}
		}
		return $report;
	}
}