<html>

<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>SC</title>

	<!-- <link rel="shortcut icon" href="<?= base_url() . 'assets/newAdmin/' ?>images/favicon.gif"> -->
	<style>
		/* fallback */
		@font-face {
			font-family: 'Material Icons';
			font-style: normal;
			font-weight: 400;
			src: url(flUhRq6tzZclQEJ-Vdg-IuiaDsNc.woff2) format('woff2');
		}

		.material-icons {
			font-family: 'Material Icons';
			font-weight: normal;
			font-style: normal;
			font-size: 24px;
			line-height: 1;
			letter-spacing: normal;
			text-transform: none;
			display: inline-block;
			white-space: nowrap;
			word-wrap: normal;
			direction: ltr;
			-moz-font-feature-settings: 'liga';
			-moz-osx-font-smoothing: grayscale;
		}

		/*@font-face {*/
		/*font-family: SourceSansPro;*/
		/*src: url(SourceSansPro-Regular.ttf);*/
		/*}*/

		.clearfix:after {
			content: "";
			display: table;
			clear: both;
		}

		a {
			color: #0087C3;
			text-decoration: none;
		}

		body {
			position: relative;
			width: 21cm;
			height: 29.7cm;
			margin: 0 auto;
			color: #555555;
			background: #FFFFFF;
			font-family: Arial, sans-serif;
			font-size: 14px;
			font-family: SourceSansPro;
		}

		header {
			padding: 10px 0;
			margin-bottom: 20px;
			border-bottom: 1px solid #AAAAAA;
		}

		#logo {
			float: left;
			margin-top: 8px;
		}

		#logo img {
			height: 70px;
		}

		#company {
			float: right;
			text-align: right;
		}


		#details {
			margin-bottom: 50px;
		}

		#client {
			padding-left: 6px;
			border-left: 6px solid #0087C3;
			float: left;
		}

		#client .to {
			color: #777777;
		}

		h2.name {
			font-size: 1.4em;
			font-weight: normal;
			margin: 0;
		}

		#invoice {
			float: right;
			text-align: right;
		}

		#invoice h1 {
			color: #0087C3;
			font-size: 2.4em;
			line-height: 1em;
			font-weight: normal;
			margin: 0 0 10px 0;
		}

		#invoice .date {
			font-size: 1.1em;
			color: #777777;
		}

		table {
			width: 100%;
			border-collapse: collapse;
			border-spacing: 0;
			margin-bottom: 20px;
		}

		table th,
		table td {
			padding: 20px;
			background: #EEEEEE;
			text-align: center;
			border-bottom: 1px solid #FFFFFF;
		}

		table th {
			white-space: nowrap;
			font-weight: normal;
		}

		table td {
			text-align: right;
		}

		table td h3 {
			color: #57B223;
			font-size: 1.2em;
			font-weight: normal;
			margin: 0 0 0.2em 0;
		}

		table .no {
			color: #FFFFFF;
			font-size: 1.6em;
			background: #57B223;
		}

		table .desc {
			text-align: left;
		}

		table .unit {
			background: #DDDDDD;
		}

		table .qty {}

		table .total {
			background: #57B223;
			color: #FFFFFF;
		}

		table td.unit,
		table td.qty,
		table td.total {
			font-size: 1.2em;
		}

		table tbody tr:last-child td {
			border: none;
		}

		table tfoot td {
			padding: 10px 20px;
			background: #FFFFFF;
			border-bottom: none;
			font-size: 1.2em;
			white-space: nowrap;
			border-top: 1px solid #AAAAAA;
		}

		table tfoot tr:first-child td {
			border-top: none;
		}

		table tfoot tr:last-child td {
			color: #57B223;
			font-size: 1.4em;
			border-top: 1px solid #57B223;

		}

		table tfoot tr td:first-child {
			border: none;
		}

		#thanks {
			font-size: 2em;
			margin-bottom: 50px;
		}

		#notices {
			padding-left: 6px;
			border-left: 6px solid #0087C3;
		}

		#notices .notice {
			font-size: 1.2em;
		}

		footer {
			color: #777777;
			width: 100%;
			height: 30px;
			position: absolute;
			bottom: 0;
			/*border-top: 1px solid #AAAAAA;*/
			padding: 8px 0;
			text-align: center;
		}
	</style>
</head>

<body>
	<div>
		<div id="logo" style="float: left; width: 28%;">
			<img src="<?= base_url('assets/images/scilogo.png'); ?>" height="100" width="60">
		</div>
		<div id="company" style="float: right; width: 54%;">
			<h2 class="name">Supreme Court of India</h2>
			<div><img src="<?= base_url() ?>/public/assets/images/mobile.png" height="14" width="14" /> 011-23388922-24,23388942</div>
			<div><img src="<?= base_url() ?>/public/assets/images/msg.png" height="14" width="14" /> <a href="mailto:supremecourt@nic.in">supremecourt@nic.in</a></div>
			<div><img src="<?= base_url() ?>/public/assets/images/pin.png" height="14" width="14" /> Tilak Marg, New Delhi-110001</div>
		</div>
	</div>
	<hr>
	<main>
		<div id="details" class="clearfix">
			<div id="client" style="float: left; width: 40%;">
				<div class="to">TO:</div>
				<h2 class="name">
					<?php echo (isset($ShippingFirstName) ? $ShippingFirstName : '') . ' ' . (isset($ShippingLastName) ? $ShippingLastName : '') ?></h2>
				<div><img src="<?= base_url() ?>/public/assets/images/mobile.png" height="14" width="14" /> <?php echo isset($ShippingMobileNumber) ? $ShippingMobileNumber : ''; ?></div>
				<div class="email"><img src="<?= base_url() ?>/public/assets/images/msg.png" height="14" width="14" /> <a href="mailto:'.$ShopperEmailAddress.'"><?php echo isset($ShopperEmailAddress) ? $ShopperEmailAddress : ''; ?></a></div>
				<div class="address"><img src="<?= base_url() ?>/public/assets/images/pin.png" height="14" width="14" />
					<?php echo (isset($ShippingAddress1) ? $ShippingAddress1 : '') . ' ' . (isset($ShippingAddress2) ? $ShippingAddress2 : '') . ' ' . (isset($ShippingCity) ? $ShippingCity : '') . ' ' . (isset($ShippingStateRegion) ? $ShippingStateRegion : '') . ' ' . (isset($ShippingState) ? $ShippingState : '') . ' ' . (isset($ShippingPostalCode) ? $ShippingPostalCode : '') . ' ' . (isset($ShippingCountryCode) ? $ShippingCountryCode : '') ?></div>
			</div>
			<div id="invoice" style="float: right; width: 40%;">
				<h1>Receipt</h1>
				<div class="date">CRN :<?php echo isset($orderCode) ? $orderCode : '' ?></div>
				<div class="date">Application No. :<?php echo (!empty($application_no) ? $application_no : ''); ?></div>
				<div class="date">Date of Receipt: <?php echo (!empty($orderDate) ? date('d-m-Y', strtotime($orderDate)) : '') ?></div>
				<div class="date">Payment Status:<?php echo (!empty($orderStatus) ? $orderStatus : '') ?></div>
			</div>
		</div>
		<table border="0" cellspacing="0" cellpadding="0">
			<thead>
				<tr>
					<th class="no">#</th>
					<th class="desc">DESCRIPTION</th>
					<th class="total">TOTAL</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="no">1</td>
					<td class="desc">
						<h3>For Copy of Diary No.<?php echo (!empty($diary_no) ? $diary_no : '') ?></h3><?php echo (!empty($required_document) ? $required_document : "") ?>
					</td>
					<td class="total">Rs.<?php echo (!empty($OrderBatchTotalAmounts) ? $OrderBatchTotalAmounts : '') ?></td>
				</tr>
			</tbody>
		</table>
		<div id="thanks">Thank you!</div>
		<div id="notices">
			<div>NOTICE:</div>
			<div class="notice">Fee once paid is not refundable or adjustable under any circumstances in future.</div>
		</div>
	</main>
	<footer>Receipt was created on a computer and is valid without the signature and seal.</footer>
</body>

</html>