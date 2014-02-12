<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?php echo $title; ?></title>
		<link rel="icon" href="<?php echo base_url(); ?>/favicon.ico" type="image/ico">
		<link rel="stylesheet" href="<?php echo base_url('/css/style.css'); ?>" />
		<link rel="stylesheet" href="<?php echo base_url('/css/print.css'); ?>" media="print" />
		<script src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
		<script src="<?php echo base_url('/js/invoicer.js'); ?>"></script>
	</head>
	<body class="<?php echo $body_class; ?>">
		<div id="container">
			<ul class="nav" id="main-nav">
				<li><a href="<?php echo base_url('projects'); ?>">Projects</a></li>
				<li><a href="<?php echo base_url('clients'); ?>">Clients</a></li>
				<li><a href="<?php echo base_url('invoices'); ?>">Invoices</a></li>
				<li><a href="<?php echo base_url('reports'); ?>">Reports</a></li>
			</ul>
			<div id="content">
				<?php $this->load->view($contentView); ?>
			</div>
		</div>
	</body>
</html>