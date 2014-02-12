<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invoices extends MY_Controller
{
	public $body_class = 'invoices';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Invoice_model');
		$this->load->model('Project_model');
		$this->load->model('Client_model');
		$this->load->model('Chunk_model');
	}

	public function index()
	{
		$body_class = 'invoices';
		$data['pending'] = $this->Client_model->get_unique_with_uninvoiced_chunks();
		$data['invoices'] = $this->Invoice_model->order_by('invoice_date','DESC')->get_all();
		foreach ($data['invoices'] as $invoice) {
			$invoice->client = $this->Client_model->get($invoice->client_id);
		}
		$data['title'] = 'Invoices | Invoicer';
		$data['contentView'] = 'invoices/invoices';
		$data['body_class'] = $this->body_class . ' ' . $body_class;
		$this->load->view('template', $data);
	}

	public function add()
	{
		$body_class = 'add_invoice';
		$client_id = $this->uri->segment(3, 0);
		$data['invoice'] = $this->Invoice_model->get_new($client_id);
		$data['invoice_number'] = $this->Invoice_model->next_invoice_number($client_id);
		if ($this->input->post('create_invoice_submit')) {
			$invoice_number = $this->Invoice_model->next_invoice_number($client_id);
			$newRecord['invoice_number'] =  $invoice_number;
			$newRecord['client_id'] = $client_id;
			$newRecord['invoice_date'] = time();
			if ($invoice_id = $this->Invoice_model->insert($newRecord)) {
				$this->Chunk_model->invoice_chunks($client_id, $invoice_id);
			} else {
				die("Insert Fail!");
			}
			redirect('invoices/', 'location');
		} else {
			$data['title'] = 'Add Invoice | Invoicer';
			$data['contentView'] = 'invoices/add_invoice';
			$data['body_class'] = $this->body_class . ' ' . $body_class;
			$this->load->view('template', $data);
		}
	}

	public function view()
	{
		$body_class = 'view_invoice';
		$invoice_id = $this->uri->segment(3, 0);
		$data['invoice'] = $this->Invoice_model->get_full($invoice_id);
		$data['invoice_number'] = $this->Invoice_model->next_invoice_number($data['invoice']->client->client_id);
		if ($this->input->post('create_invoice_submit')) {
			$invoice_number = $this->Invoice_model->next_invoice_number($data['client']->client_id);
			$newRecord['invoice_number'] =  $invoice_number;
			$newRecord['client_id'] = $data['client']->client_id;
			$newRecord['invoice_date'] = time();
			if ($invoice_id = $this->Invoice_model->insert($newRecord)) {
				$this->Chunk_model->invoice_chunks($client_id, $invoice_id);
			} else{
				die("Insert Fail!");
			}
			redirect('invoices/', 'location');
		} else {
			$data['title'] = 'View Invoice | Invoicer';
			$data['contentView'] = 'invoices/view_invoice';
			$data['body_class'] = $this->body_class . ' ' . $body_class;
			$this->load->view('template', $data);
		}
	}

	public function edit()
	{
		if ($this->input->post('update_invoice_submit')) {
			$body_class = 'invoice_update_success';
			$invoice_id = $this->uri->segment(3, 0);
			$project_id = $this->uri->segment(4, 0);
			$updatedRecord['invoice_info'] = $this->input->post('invoice_info');
			$this->Invoice_model->update_record($updatedRecord, $invoice_id);
			redirect('projects/view/'.$project_id, 'location');
		} else {
			$body_class = 'edit_invoice';
			$data['title'] = 'Edit invoice | Invoicer';
			$data['contentView'] = 'invoices/edit_invoice';
			$data['body_class'] = $this->body_class . ' ' . $data['contentView'];
			$invoice_id = $this->uri->segment(3, 0);
			$data['invoice'] = $this->Invoice_model->get_record_by_id($invoice_id);
			$this->load->view('template', $data);
		}
	}

	public function pay()
	{
		$invoice_id = $this->uri->segment(3, 0);
		$this->Invoice_model->set_paid($invoice_id);
		redirect('invoices');
	}

	public function unpay()
	{
		$invoice_id = $this->uri->segment(3, 0);
		$this->Invoice_model->set_unpaid($invoice_id);
		redirect('invoices');
	}

	function deinvoice()
	{
		$invoice_id = $this->uri->segment(3);
		if (!empty($invoice_id)) {
			$this->Chunk_model->deinvoice_chunks($invoice_id);
		}
		redirect('invoices/', 'location');
	}
}