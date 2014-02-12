<h1>Add Invoice</h1>
<hr />
<h1 id="invoice-h1">SERVICE INVOICE</h1>
<div id="invoicer-info">
	<?php
		$this->config->load('user_info');
		echo ($this->config->item('full_name')) ? '<h2>'.$this->config->item('full_name').'</h2>' : '';
		echo ($this->config->item('address_line_1')) ? '<em>'.$this->config->item('address_line_1').'</em><br />' : '';
		echo ($this->config->item('address_line_2')) ? '<em>'.$this->config->item('address_line_2').'</em><br />' : '';
		echo ($this->config->item('phone')) ? '<em>'.$this->config->item('phone').'</em><br />' : '';
		echo ($this->config->item('email')) ? '<em>'.$this->config->item('email').'</em><br />' : '';
	?>
</div>
<div id="invoice-info">
	<div><strong>Service: </strong> Web Development</div>
	<div><strong>Bill To:</strong> <?php echo $invoice['client']->contact_first_name . ' ' . $invoice['client']->contact_last_name . ' - '. $invoice['client']->company_name; ?></div>
	<div class="divider"></div>
	<div><strong>Invoice Date:</strong> <?php echo date("F d, Y", time()); ?></div>
	<div><strong>Invoice Number:</strong> <?php echo $invoice['client']->client_number . $invoice_number; ?></div>
</div>
<header>
	<div class="th-1">Project</div>
	<div class="th-2">Description</div>
	<div class="th-3">Hours</div>
	<div class="th-4">Rate</div>
	<div class="th-5">Amount</div>
</header>
<?php $invoiceTotal = 0; ?>
<?php foreach ($invoice['projects'] as $project) { ?>
	<div class="project-name"><strong><?php echo $project->project_name; ?></strong></div>
	<div class="project-amounts">
		<?php if (!empty($project->hourly_hours)) { ?>
			<?php foreach ($project->hourly_hours as $hourly => $hours) { ?>
				<?php $hours = ($hours) ? $hours : '0.00'; ?>
				<div><?php echo $hours; ?></div>
				<div><?php echo "$".$hourly; ?></div>
				<?php $lineTotal = $hours * $hourly; ?>
				<div><?php echo "$".number_format($lineTotal, 2); ?></div>
				<?php $invoiceTotal += $lineTotal; ?>
			<?php } ?>
		<?php } ?>
		<?php if (!empty($project->flat_amount)) { ?>
			<div>-</div>
			<div>-</div>
			<div>
				<?php
					if ($project->flat_amount >= 0) {
						echo "$".$project->flat_amount;
					} else {
						echo "-$".number_format(abs($project->flat_amount),2);
					}
				?>
			</div>
			<?php $invoiceTotal += $project->flat_amount; ?>
		<?php } ?>
	</div>
	<div class="project-info">
		<?php foreach ($project->chunks as $chunk) { ?>
			<div class="chunk-date">
				<?php
					echo date("D. F d, Y",$chunk->chunk_date) . " &raquo; ";
					if ($chunk->flat_amount) {
						if ($chunk->flat_amount >= 0) {
							echo "$".$chunk->flat_amount;
						} else {
							echo "-$".number_format(abs($project->flat_amount),2);
						}
					} else {
						$chunk->chunk_hours = ($chunk->chunk_hours) ? $chunk->chunk_hours : '0.00';
						echo $chunk->chunk_hours . " hours";
					}
				?>
			</div>
			<div class="chunk"><?php echo nl2br($chunk->chunk_info); ?></div>
		<?php } ?>
	</div>
	<div class="divider">&nbsp;</div>
<?php } ?>
<div id="invoice-total">Total Due<br /> <?php echo "$".number_format($invoiceTotal, 2); ?></div>
<div><?php if (!empty($error)) { echo $error; } ?></div>
<form id="new-invoice" method="POST" action="<?php echo base_url('invoices/add/'.$invoice['client']->client_id . '/' . $invoice_number); ?>">
	<button type="submit" name="create_invoice_submit" value="1">Add</button>
</form>