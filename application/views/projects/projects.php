<h1>Projects</h1>
<p><a href="<?php echo base_url('projects/add'); ?>">Add Project</a></p>
<hr />
<h2>Active</h2>
<hr />
<?php if (isset($active_projects)) { ?>
	<?php foreach ($active_projects as $active_project) { ?>
		<p>
			<a class="project_name" href="<?php echo base_url('/projects/view/'.$active_project->project_id); ?>">
				<strong><?php echo $active_project->project_name; ?></strong>
			</a>&nbsp; - &nbsp;		
			<a href="<?php echo base_url('/projects/deactivate/'.$active_project->project_id); ?>">Deactivate</a>
		</p>
	<?php } ?>
<?php } else { ?>	
	<h2>No active projects.</h2>
	<p><a href="<?php echo base_url('projects/add'); ?>">Add Project</a></p>
<?php } ?>
<hr />
<h2>Inactive</h2>
<hr />
<?php if (isset($inactive_projects)) { ?>
	<?php foreach ($inactive_projects as $inactive_project) { ?>
		<p>
			<a class="project_name" href="<?php echo base_url('/projects/view/'.$inactive_project->project_id); ?>">
				<strong><?php echo $inactive_project->project_name; ?></strong>
			</a>&nbsp; - &nbsp;		
			<a href="<?php echo base_url('/projects/activate/'.$inactive_project->project_id); ?>">Activate</a>
		</p>
	<?php } ?>
<?php } else { ?>	
	<h2>No inactive projects.</h2>
	<p><a href="<?php echo base_url('projects/add'); ?>">Add Project</a></p>
<?php } ?>