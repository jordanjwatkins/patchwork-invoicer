<?php if (!empty($addSuccess)) { ?>
	<div id="content">
		<h1>Chunk Added Successfully</h1>
		<a href="<?php echo base_url('projects/view/'.$project->project_id); ?>">View Chunks</a>
	</div>
<?php } else { ?>
	<h1>Add Chunk</h1>
	<hr />
	<h2><?php echo $project->project_name; ?></h2>
	<hr />
	<div><?php if(!empty($error)){echo $error;} ?></div>
	<form id="new-chunk" method="POST" action="<?php echo base_url('chunks/add/'.$project->project_id); ?>">
		<h3></h3>
		<div class="form-row">
			<label>Chunk Date</label>
			<input type="text" name="chunk_date" id="chunk_date" value="<?php echo date("F d, Y", time()); ?>" />
		</div>
		<div class="form-row hourly">
			<label>Chunk Hours</label>
			<input type="text" name="chunk_hours" id="chunk_hours" value="0" />
			<div class="type-toggle">Flat</div>
		</div>
		<div class="form-row flat">
			<label>Chunk Amount</label>
			<input type="text" name="flat_amount" id="flat_amount" value="" disabled="disabled" />
			<div class="type-toggle">Hourly</div>
		</div>
		<div class="form-row">
			<label>Chunk Info</label><br />
			<textarea type="text" name="chunk_info" id="chunk_info" cols="25" rows="25">Info Here</textarea>
		</div>
		<button type="submit" name="create_chunk_submit" value="1">Add</button>
	</form>
<?php } ?>