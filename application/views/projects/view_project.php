<h1><?php echo $project->project_name; ?></h1>
<hr />
<p><strong>Client:</strong> <?php echo $project->company_name; ?></p>
<p>
	<strong id="project_info_label">Project Info &nbsp; <span>></span></strong>
	<a class="edit" href="<?php echo base_url('/projects/edit/'.$project->project_id); ?>">Edit</a>
	<div id="project_info"><?php echo nl2br(htmlentities($project->project_info)); ?></div>
</p>
<div class='clearb'></div>
<hr />
<p><h2><a href="<?php echo base_url('chunks/add/'.$project->project_id); ?>">Add Chunk</a></h2></p>
<hr />
<?php if (isset($chunks)) { ?>
	<?php foreach ($chunks as $chunk) { ?>
		<p>
			<?php
				echo date("D. F d, Y", $chunk->chunk_date)."&nbsp; ||  &nbsp;";
				if (is_numeric($chunk->flat_amount)) {
					if ($chunk->flat_amount >= 0) {
						echo '$'.$chunk->flat_amount;
					} else {
						echo '-$'.number_format(abs($chunk->flat_amount), 2);
					}
				} else {
					$chunk->chunk_hours = ($chunk->chunk_hours) ? $chunk->chunk_hours : '0.00';
					echo $chunk->chunk_hours." hours";
				}
			?>
			<span class="chunk-info"><?php echo nl2br($chunk->chunk_info); ?></span>
			<?php if ($chunk->invoiced !== '1') { ?>
				<a href="<?php echo base_url('chunks/edit/'.$chunk->chunk_id); ?>">Edit Chunk</a>
			<?php } ?>
		</p>
		<hr />
	<?php } ?>
<?php } ?>