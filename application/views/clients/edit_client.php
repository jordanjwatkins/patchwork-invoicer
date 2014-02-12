<?php if (!empty($updateSuccess)) { ?>
	<h1>Client Updated Successfully</h1>
	<a href="<?php echo base_url('clients'); ?>">View Clients</a>
<?php } else { ?>
	<?php $client = $records; ?>
	<h1>Edit Client</h1>
	<form id="edit-client" method="POST" action="<?php echo base_url('clients/edit').'/'.$this->uri->segment(3, 0); ?>">
		<div class="form-row">
			<label>Name of Company</label>
			<input type="text" name="company_name" id="company_name" value="<?php echo $client->company_name; ?>" />
		</div>
		<div class="form-row">
			<label>Contact First Name</label>
			<input type="text" name="contact_first_name" id="contact_first_name" value="<?php echo $client->contact_first_name; ?>" />
		</div>
		<div class="form-row">
			<label>Contact Last Name</label>
			<input type="text" name="contact_last_name" id="contact_last_name" value="<?php echo $client->contact_last_name; ?>" />
		</div>
		<div class="form-row">
			<label>Client Hourly</label>
			<input type="text" name="client_hourly" id="client_hourly" value="<?php echo $client->client_hourly; ?>" />
		</div>
		<div class="form-row">
			<label>Client Number</label>
			<input type="text" name="client_number" id="client_number" value="<?php echo $client->client_number; ?>" />
		</div>
		<button type="submit" name="update_client_submit" value="1">Update</button>
	</form>
<?php } ?>