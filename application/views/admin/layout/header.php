<!DOCTYPE html>
<html lang="en">
	<head>
	  	<!-- <meta charset="utf-8"> -->
	  	<meta content="text/html" charset="utf-8" http-equiv="Content-Type" />
	  	<meta name="viewport" content="width=device-width, initial-scale=1">
	  	<meta http-equiv="x-ua-compatible" content="ie=edge">
		<title><?php echo $pageTitle; ?></title>
			<?php load_css(
				array(
					'public/admin_assets/plugins/font-awesome/css/font-awesome.min.css?',
					'public/admin_assets/plugins/datatables/dataTables.bootstrap4.css?',
					'public/admin_assets/dist/css/adminlte.min.css?'
				)
			);?>
			<!-- new -->
			<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css"> -->
			<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
			<!-- Google Font: Source Sans Pro -->
			<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
	</head>
	<body class="hold-transition sidebar-mini">