<?php if (!empty($updateSuccess)) { ?>
	<h1>Chunk Updated Successfully</h1>
	<a href="<?php echo base_url('projects/view/'.$project->project_id); ?>">View Chunks</a>
<?php } else { ?>
	<h1>Edit Chunk</h1>
	<form id="edit-chunk" method="POST" action="<?php echo base_url('chunks/edit/'.$this->uri->segment(3, 0).'/'.$chunk->project_id); ?>">
		<div class="form-row">
			<label>Chunk Date</label>
			<input type="text" name="chunk_date" id="chunk_date" value="<?php echo date("F d, Y", $chunk->chunk_date); ?>" />
		</div>
		<div class="form-row hourly">
			<label>Chunk Hours</label>
			<input type="text" name="chunk_hours" id="chunk_hours" value="<?php echo $chunk->chunk_hours; ?>" />
			<div class="type-toggle">Flat</div>
		</div>
		<div class="form-row flat">
			<label>Chunk Amount</label>
			<input type="text" name="flat_amount" id="flat_amount" value="<?php echo $chunk->flat_amount; ?>" disabled="disabled" />
			<div class="type-toggle">Hourly</div>
		</div>
		<div class="form-row">
			<label>Chunk Info</label><br />
			<textarea name="chunk_info" id="chunk_info" cols="25" rows="25"><?php echo $chunk->chunk_info; ?></textarea>
		</div>
		<button type="submit" name="update_chunk_submit" value="1">Update</button>
	</form>
<?php } ?>