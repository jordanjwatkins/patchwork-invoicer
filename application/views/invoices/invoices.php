<h1>Invoices</h1>
<?php if (!empty($pending)) { ?>
	<hr />
	<h2>Pending Creation</h2>
	<hr />
	<?php foreach ($pending as $row) { ?>
		<h3 class="invoice">
			<a href="<?php echo base_url('invoices/add/'.$row['client_id']); ?>">
				<?php
					echo $row['invoice_number'].' - ';
					echo $row['company_name'];
				?>
			</a>
		</h3>
	<?php } ?>
<?php } ?>
<hr />
<h2>Archive</h2>
<?php foreach ($invoices as $row) { ?>
	<h3 class="invoice">
		<?php
			echo "<a href='".base_url('invoices/view/'.$row->invoice_id)."'>";
			echo $row->client->client_number.$row->invoice_number . ' | ';
			echo $row->client->contact_first_name . " " . $row->client->contact_last_name . " - " . $row->client->company_name.'</a>';
			if (empty($row->paid)) {
				echo "<a class='payment-status' href='".base_url('invoices/pay/'.$row->invoice_id)."'>Mark as Paid</a>";
			} else {
				echo "<span class='payment-status'>Paid</span>";
			}
		?>
	</h3>
<?php } ?>
<hr />