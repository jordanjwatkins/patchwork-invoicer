<h1>Add Client</h1>
<hr />
<div><?php if(!empty($error)){echo $error;} ?></div>
<form id="new-client" method="POST" action="<?php echo base_url('clients/add'); ?>">
	<div class="form-row">
		<label>Name of Company</label>
		<input type="text" name="company_name" id="company_name" value="" />
	</div>
	<div class="form-row">
		<label>Contact First Name</label>
		<input type="text" name="contact_first_name" id="contact_first_name" value="" />
	</div>
	<div class="form-row">
		<label>Contact Last Name</label>
		<input type="text" name="contact_last_name" id="contact_last_name" value="" />
	</div>
	<div class="form-row">
		<label>Client Hourly</label>
		<input type="text" name="client_hourly" id="client_hourly" value="" />
	</div>
	<div class="form-row">
		<label>Client Number</label>
		<input type="text" name="client_number" id="client_number" value="" />
	</div>
	<button type="submit" name="create_client_submit" value="1">Add</button>
</form>