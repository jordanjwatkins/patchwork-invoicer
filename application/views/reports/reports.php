<h1>Reports</h1>
<hr />
<?php foreach ($clients as $client) { ?>
	<h3><a href="<?php echo site_url('reports/view/'.$client->client_id); ?>"><?php echo $client->company_name; ?></a></h3>
<?php } ?>
<hr />