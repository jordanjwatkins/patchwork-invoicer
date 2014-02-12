<h1>Reports</h1>
<hr />
<form id="report_form" method="POST" action="<?php echo current_url(); ?>">
	<label>Project: </label>
	<select class="client_names" name="project">
		<option value="">All Projects</option>
		<?php foreach ($client->projects as $project) { ?>
			<?php
				$selected = '';
				if (!empty($project_id)) {
					if ($project_id == $project->project_id) {
						$selected = 'selected="selected"';
					}
				}
			?>
			<option <?php echo $selected; ?> value="<?php echo $project->project_id; ?>"><?php echo $project->project_name; ?></option>
		<?php } ?>
	</select>
	<input type="submit" />
</form>
<hr />
<?php if (empty($project_id)) { ?>
	<div class="col col-1">
		<h3>Total</h3>
		<h4>Hours: <?php echo $report->grand_totals->hours; ?></h4>
		<h4>Amount: $<?php echo number_format($report->grand_totals->amount, 2); ?></h4>
	</div>
	<div class="col col-2">
		<h3>Unpaid Total</h3>
		<h4>Hours: <?php echo $report->unpaid_totals->hours; ?></h4>
		<h4>Amount: $<?php echo number_format($report->unpaid_totals->amount, 2); ?></h4>
	</div>
	<div class="col col-3">
		<h3>Paid Total</h3>
		<h4>Hours: <?php echo $report->paid_totals->hours; ?></h4>
		<h4>Amount: $<?php echo number_format($report->paid_totals->amount, 2); ?></h4>
	</div>
	<hr />
<?php } ?>
<?php foreach ($report->projects as $project) { ?>
	<h4><?php echo $project->project_name; ?></h4>
	<h5>Hours: <?php echo $project->total->hours; ?></h5>
	<h5>Amount: $<?php echo number_format($project->total->amount, 2); ?></h5>
	<hr />
<?php } ?>