<h1>Clients</h1>
<hr />
<?php if (isset($records)) { ?>
	<p><a href="<?php echo base_url('clients/add'); ?>">Add Client</a></p>
	<hr />
<?php } ?>
<?php if (isset($records)) { ?>
	<?php foreach ($records as $row) { ?>
		<h2><?php echo $row->company_name; ?></h2>
		<p><strong>Contact:</strong> <?php echo $row->contact_first_name." ".$row->contact_last_name; ?></p>
		<p><strong>Client Number:</strong> <?php echo $row->client_number; ?></p>
		<p><strong>Hourly:</strong> <?php echo $row->client_hourly; ?></p>
		<div class='clearb'></div>
		<p><a href="<?php echo base_url('/clients/edit/'.$row->client_id); ?>">Edit</a></p>
		<hr />
	<?php } ?>
<?php } else { ?>
	<h2>No clients yet.</h2>
	<p><a href="<?php echo base_url('clients/add'); ?>">Add Client</a></p>
<?php } ?>