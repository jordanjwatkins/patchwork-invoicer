<h1>Edit Project</h1>
<form id="edit-project" method="POST" action="<?php echo base_url('projects/edit/'.$this->uri->segment(3, 0)); ?>">
	<div class="form-row">
		<label>Active?</label>
		<input type="checkbox" name="active" value="1" <?php if ($project->active == 1) { echo 'checked'; } ?> />
	</div>
	<div class="form-row">
		<label>Name of Project</label>
		<input type="text" name="project_name" id="project_name" value="<?php echo $project->project_name; ?>" />
	</div>
	<div class="form-row">
		<label>Project Info</label><br />
		<textarea type="text" name="project_info" cols="70" rows="30"><?php echo $project->project_info; ?></textarea>
	</div>
	<button type="submit" name="update_project_submit" value="1">Update</button>
</form>