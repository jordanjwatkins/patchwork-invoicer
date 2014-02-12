<h1>Add Project</h1>
<hr />
<div><?php if (!empty($error)) { echo $error; } ?></div>
<form id="new-project" method="POST" action="<?php echo base_url('projects/add'); ?>">
	<div class="form-row">
		<label>Client</label>
		<select name="client_id" id="client_id">
			<option value=""> </option>
			<?php foreach ($clients as $client) { ?>
				<option value="<?php echo $client->client_id; ?>"><?php echo $client->company_name; ?></option>
			<?php } ?>
		</select>
	</div>
	<div class="form-row">
		<label>Name of Project</label>
		<input type="text" name="project_name" id="project_name" value="" />
	</div>
	<div class="form-row">
		<label>Project Info</label><br />
		<textarea type="text" name="project_info" id="project_info" cols="25" rows="25">Info Here</textarea>
	</div>
	<button type="submit" name="create_project_submit" value="1">Add</button>
</form>