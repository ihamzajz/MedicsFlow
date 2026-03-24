<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
	header('Location: login.php'); // Redirect to the login page
	exit;
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Cash Purchase</title>
	<link rel="shortcut icon" type="image/jpg" href="assets/images/fevicon.png" />
	<?php
	include 'cdncss.php'
	?>
	<style>
		.bg-menu {
			background-color: #393E46 !important;
		}

		.btn-menu {
			font-size: 12.5px;
			background-color: #FFB22C !important;
			padding: 5px 10px;
			font-weight: 600;
			border: none !important;
		}

		body {
			font-family: 'Poppins', sans-serif;
		}

		.btn {
			border-radius: 0px;
			font-size: 11px !important;
		}

		.btn-home {
			background-color: #62CDFF;
			border: 1px solid #62CDFF;
			color: black;
			padding: 5px 10px;
			font-weight: 600;
			border: none !important;
			font-size: 12px;
		}

		.btn-back {
			background-color: #56DFCF;
			color: black;
			padding: 5px 10px;
			font-weight: 600;
			border: 1px solid #56DFCF;
			font-size: 12px;
		}


		.btn-home:hover {
			background-color: #62CDFF;
			border: 1px solid #62CDFF;
			color: black;
			padding: 5px 10px;
			font-weight: 600;
			border: none !important;
			font-size: 12px;
		}

		.btn-back:hover {
			background-color: #56DFCF;
			color: black;
			padding: 5px 10px;
			font-weight: 600;
			border: 1px solid #56DFCF;
			font-size: 12px;
		}



		.btn-submit {
			font-size: 15px !important;
			color: white;
			background-color: #0D9276;
			padding: 5px 35px;
			border-radius: 2px;
			border: 2px solid #0D9276;
			letter-spacing: 1px;
			font-weight: 500;
			transition: all 0.3s ease;
			/* Smooth transition effect */
		}

		.btn-submit:hover {
			color: #0D9276;
			background-color: white;
			border: 2px solid #0D9276;
		}



		.cbox {
			height: 13px !important;
			width: 13px !important;
		}

		table th {
			font-size: 12px !important;
			border: none !important;
			background-color: #1B7BBC !important;
			color: white !important;
			padding: 6px 5px !important;
		}

		table td {
			font-size: 12px;
			color: black;
			padding: 0px !important;
			/* Adjust padding as needed */
			/* border: 1px solid #ddd; */
		}

		input {
			width: 100% !important;
			font-size: 12px;
			border-radius: 0px;
			border: 1px solid grey;
			transition: border-color 0.3s ease;
			padding: 2.5px 5px;
			letter-spacing: 0.4px;
			height: 25px !important;
			/* color:#2c2c2c!important; */
		}

		input:focus {
			outline: none;
			border: 1px solid black;
			background-color: #FFF4B5;
		}

		.labelp {
			padding: 0px !important;
			margin: 0px !important;
			font-size: 12.5px !important;
			font-weight: 600 !important;
			padding-bottom: 5px !important;
			;
		}

		/* Approve Button  */
		.btn-approve {
			white-space: nowrap !important;
			font-size: 12px !important;
			font-weight: 500 !important;
			background-color: #D1E7DD;
			color: white !important;
			border-radius: 15px !important;
			transition: all 0.3s ease !important;
			padding: 4px 15px !important;
			color: black !important;
			border: 1px solid #198754 !important;
		}

		.btn-approve:hover {
			filter: brightness(85%);
		}

		/* Reject Button */
		.btn-reject {
			white-space: nowrap !important;
			font-size: 12px !important;
			font-weight: 500 !important;
			background-color: #F8D7DA;
			color: white !important;
			border-radius: 15px !important;
			transition: all 0.3s ease !important;
			padding: 4px 15px !important;
			color: black !important;
			border: 1px solid #DC3545 !important;
		}

		.btn-reject:hover {
			filter: brightness(85%);
		}

		.btn-addcomment {
			font-size: 12px !important;
			font-weight: 500 !important;
			background-color: #687FE5;
			color: white !important;
			border-radius: 15px !important;
			transition: all 0.3s ease !important;
			padding: 4px 15px !important;
			border: 1px solid black !important;
		}

		.btn-addcomment:hover {
			filter: brightness(85%) !important;
		}

		.btn-uploadevidence {
			font-size: 12px !important;
			font-weight: 500 !important;
			background-color: white;
			color: black !important;
			border-radius: 15px !important;
			transition: all 0.3s ease !important;
			padding: 4px 15px !important;
			border: 1px solid black !important;
		}

		.btn-uploadevidence:hover {
			filter: brightness(85%) !important;
		}

		.btn-viewevidence {
			font-size: 12px !important;
			font-weight: 500 !important;
			background-color: #7F7C82;
			color: white !important;
			border-radius: 15px !important;
			transition: all 0.3s ease !important;
			padding: 4px 15px !important;
			border: 1px solid black !important;
		}

		.btn-viewevidence:hover {
			filter: brightness(85%) !important;
		}
	</style>
	<style>
		input[type="file"] {
			border-radius: 6px;
			border: 1px solid black;
			padding: 6px 10px;
		}
	</style>








	<style>
		.button-evidenceN {
			display: inline-block;
			outline: none;
			cursor: pointer;
			border-radius: 3px;
			font-size: 14px;
			font-weight: 500;
			line-height: 16px;
			padding: 5px 8px;
			height: 32px;
			min-width: 60px;
			min-height: 32px;
			border: none;
			color: #fff;
			background-color: #4f545c;
			transition: background-color .17s ease, color .17s ease;

		}

		.button-uploadevidenceN {
			display: inline-block;
			outline: none;
			cursor: pointer;
			border-radius: 3px;
			font-size: 14px;
			font-weight: 500;
			line-height: 16px;
			padding: 5px 8px;
			height: 32px;
			min-width: 60px;
			min-height: 32px;
			border: 1px solid black;
			color: black;
			background-color: white;
			transition: background-color .17s ease, color .17s ease;

		}

		.button-rejectN {
			display: inline-block;
			outline: 0;
			text-align: center;
			cursor: pointer;
			padding: 5px 8px;
			color: #fff;
			vertical-align: top;
			border-radius: 3px;
			border: 1px solid transparent;
			transition: all .3s ease;
			background: #cc4d29;
			border-color: #cc4d29;
			font-weight: 500;
			line-height: 16px;
			font-size: 12.5px;
		}

		.button-rejectN:hover {
			background: #e4461b;
			border-color: #e4461b;
		}

		.button-approveN {
			display: inline-block;
			outline: 0;
			text-align: center;
			cursor: pointer;
			padding: 5px 8px;
			color: #fff;
			vertical-align: top;
			border-radius: 3px;
			border: 1px solid transparent;
			transition: all .3s ease;
			background: #15883e;
			border-color: #15883e;
			font-weight: 500;
			line-height: 16px;
			font-size: 12.5px;
		}

		.button-approveN:hover {
			background: #1db954;
			border-color: #1db954;
		}

		.button-openN {
			display: inline-block;
			outline: 0;
			cursor: pointer;
			border: 1px solid #007a5a;
			color: #007a5a;
			border-color: #007a5a;
			font-weight: 700;
			background: #fff;
			padding: 8px;
			font-size: 15px;
			border-radius: 4px;
			height: 36px;
			transition: all 80ms linear;
		}

		.button-openN:hover {
			box-shadow: 0 1px 3px 0 rgb(0 0 0 / 8%);
			background: rgba(248, 248, 248, 1);
		}

		.button-closeN {
			display: inline-block;
			outline: 0;
			cursor: pointer;
			border: 1px solid #BF092F;
			color: #BF092F;
			border-color: #BF092F;
			font-weight: 700;
			background: #fff;
			padding: 8px;
			font-size: 15px;
			border-radius: 4px;
			height: 36px;
			transition: all 80ms linear;
		}

		.button-closeN:hover {
			box-shadow: 0 1px 3px 0 rgb(0 0 0 / 8%);
			background: rgba(248, 248, 248, 1);
		}

		.button-commentN {
			display: inline-block;
			outline: 0;
			text-align: center;
			cursor: pointer;
			padding: 5px 8px;
			color: black;
			vertical-align: top;
			border-radius: 3px;
			border: 1px solid black;
			transition: all .3s ease;
			background: #FFF455;
			border-color: black;
			font-weight: 500;
			line-height: 16px;
			font-size: 12.5px;
		}

		.button-commentN:hover {
			box-shadow: 0 1px 3px 0 rgb(0 0 0 / 8%);
		}

		.button-pdfN {
			display: inline-block;
			outline: 0;
			text-align: center;
			cursor: pointer;
			padding: 5px 8px;
			color: white;
			vertical-align: top;
			border-radius: 3px;
			border: 1px solid black;
			transition: all .3s ease;
			background: #0046FF;
			border-color: black;
			font-weight: 500;
			line-height: 16px;
			font-size: 12.5px;
		}

		.button-pdfN:hover {
			box-shadow: 0 1px 3px 0 rgb(0 0 0 / 8%);
		}
	</style>








	<?php
	include 'sidebarcss.php'
	?>
</head>

<body>
	<?php
	include 'dbconfig.php';
	?>
	<div class="wrapper d-flex align-items-stretch">
		<?php
		include 'sidebar1.php';
		?>
		<!-- Page Content  -->
		<div id="content">
			<!-- navbar -->
			<nav class="navbar navbar-expand-lg bg-menu">
				<div class="container-fluid">
					<button type="button" id="sidebarCollapse" class="btn-menu"> <i
							class="fas fa-align-left"></i> <span>Menu</span> </button>
				</div>
			</nav>
			<?php
			include 'dbconfig.php';


			$id = $_GET['id'];
			$select = "SELECT * FROM cash_purchase WHERE
                                     id = '$id' ";

			$select_q = mysqli_query($conn, $select);
			$data = mysqli_num_rows($select_q);
			?>
			<?php
			if ($data) {
				while ($row = mysqli_fetch_array($select_q)) {
			?>
					<div class="container-fluid">
						<div style="background-color:White!important;padding:20px!important;border:1px solid black" class="p-5 m-5">
							<form class="form pb-3" method="POST" enctype="multipart/form-data">

								<div class="d-flex align-items-center justify-content-between mb-3" style="min-height: 40px;">
									<!-- Left: Heading -->
									<h5 class="mb-0" style="font-size:18px!important;font-weight:700">
										Cash / Purchase Requisition Form
									</h5>
									<!-- Right: Buttons -->
									<div>
										<a class="btn btn-dark btn-sm me-2"
											href="cash_purchase_home.php"
											style="font-size:12px!important">
											<i class="fa fa-home"></i> Home
										</a>
										<a class="btn btn-secondary btn-sm"
											href="cash_purchase_finance_list.php"
											style="font-size:12px!important">
											<i class="fa fa-list"></i> Back
										</a>
									</div>
								</div>

								<div class="row mb-3 mt-5">
									<div class="col-md-3">
										<div>
											<p class="labelp">Requestor Name</p>
											<input type="text" name="name" value="<?php echo $row['name']; ?>" class="w-100"
												readonly>
										</div>
									</div>
									<div class="col-md-3">
										<div>
											<p class="labelp">Department</p>
											<input type="text" name="department" value="<?php echo $row['department']; ?>"
												class="w-100" readonly>
										</div>
									</div>
									<div class="col-md-3">
										<div>
											<p class="labelp">Role</p>
											<input type="text" name="role" value="<?php echo $row['role']; ?>" class="w-100"
												readonly>
										</div>
									</div>
									<div class="col-md-3">
										<div>
											<p class="labelp">Date</p>
											<input type="text" name="date" value="<?php echo $row['date']; ?>" class="w-100"
												readonly>
										</div>
									</div>
								</div>

								<div class="table-responsive">
									<table class="table">
										<thead>
											<tr>
												<th style="width:20px!important">S.R</th>
												<th>Description</th>
												<th>Purpose</th>
												<th style="width:70px!important">Qty</th>
												<th style="width:120px!important">Price</th>
												<th style="width:120px!important">Amount</th>
											</tr>
										</thead>
										<tbody>
											<?php if (!empty($row['description_1'])): ?>
												<tr>
													<td>
														<input type="text" name="sr_1" value="<?php echo $row['sr_1']; ?>"
															class="w-100" readonly>
													</td>
													<td>
														<input type="text" name="description_1"
															value="<?php echo $row['description_1']; ?>" class="w-100" readonly>
													</td>
													<td>
														<input type="text" name="purpose_1" value="<?php echo $row['purpose_1']; ?>"
															class="w-100" readonly>
													</td>
													<td>
														<input type="text" name="qty_1" value="<?php echo $row['qty_1']; ?>"
															class="w-100" readonly>
													</td>
													<td>
														<input type="text" name="price_1" value="<?php echo $row['price_1']; ?>"
															class="w-100" readonly>
													</td>
													<td>
														<input type="text" name="amount_1" value="<?php echo $row['amount_1']; ?>"
															class="w-100" readonly>
													</td>
												</tr>
											<?php endif; ?>
											<?php if (!empty($row['description_2'])): ?>
												<tr>
													<td>
														<input type="text" name="sr_2" value="<?php echo $row['sr_2']; ?>"
															class="w-100" readonly>
													</td>
													<td>
														<input type="text" name="description_2"
															value="<?php echo $row['description_2']; ?>" class="w-100" readonly>
													</td>
													<td>
														<input type="text" name="purpose_2" value="<?php echo $row['purpose_2']; ?>"
															class="w-100" readonly>
													</td>
													<td>
														<input type="text" name="qty_2" value="<?php echo $row['qty_2']; ?>"
															class="w-100" readonly>
													</td>
													<td>
														<input type="text" name="price_2" value="<?php echo $row['price_2']; ?>"
															class="w-100" readonly>
													</td>
													<td>
														<input type="text" name="amount_2" value="<?php echo $row['amount_2']; ?>"
															class="w-100" readonly>
													</td>
												</tr>
											<?php endif; ?>
											<?php if (!empty($row['description_3'])): ?>
												<tr>
													<td>
														<input type="text" name="sr_3" value="<?php echo $row['sr_3']; ?>"
															class="w-100" readonly>
													</td>
													<td>
														<input type="text" name="description_3"
															value="<?php echo $row['description_3']; ?>" class="w-100" readonly>
													</td>
													<td>
														<input type="text" name="purpose_3" value="<?php echo $row['purpose_3']; ?>"
															class="w-100" readonly>
													</td>
													<td>
														<input type="text" name="qty_3" value="<?php echo $row['qty_3']; ?>"
															class="w-100" readonly>
													</td>
													<td>
														<input type="text" name="price_3" value="<?php echo $row['price_3']; ?>"
															class="w-100" readonly>
													</td>
													<td>
														<input type="text" name="amount_3" value="<?php echo $row['amount_3']; ?>"
															class="w-100" readonly>
													</td>
												</tr>
											<?php endif; ?>
											<?php if (!empty($row['description_4'])): ?>
												<tr>
													<td>
														<input type="text" name="sr_4" value="<?php echo $row['sr_4']; ?>"
															class="w-100" readonly>
													</td>
													<td>
														<input type="text" name="description_4"
															value="<?php echo $row['description_4']; ?>" class="w-100" readonly>
													</td>
													<td>
														<input type="text" name="purpose_4" value="<?php echo $row['purpose_4']; ?>"
															class="w-100" readonly>
													</td>
													<td>
														<input type="text" name="qty_4" value="<?php echo $row['qty_4']; ?>"
															class="w-100" readonly>
													</td>
													<td>
														<input type="text" name="price_4" value="<?php echo $row['price_4']; ?>"
															class="w-100" readonly>
													</td>
													<td>
														<input type="text" name="amount_4" value="<?php echo $row['amount_4']; ?>"
															class="w-100" readonly>
													</td>
												</tr>
											<?php endif; ?>
											<?php if (!empty($row['description_5'])): ?>
												<tr>
													<td>
														<input type="text" name="sr_5" value="<?php echo $row['sr_5']; ?>"
															class="w-100" readonly>
													</td>
													<td>
														<input type="text" name="description_5"
															value="<?php echo $row['description_5']; ?>" class="w-100" readonly>
													</td>
													<td>
														<input type="text" name="purpose_5" value="<?php echo $row['purpose_5']; ?>"
															class="w-100" readonly>
													</td>
													<td>
														<input type="text" name="qty_5" value="<?php echo $row['qty_5']; ?>"
															class="w-100" readonly>
													</td>
													<td>
														<input type="text" name="price_5" value="<?php echo $row['price_5']; ?>"
															class="w-100" readonly>
													</td>
													<td>
														<input type="text" name="amount_5" value="<?php echo $row['amount_5']; ?>"
															class="w-100" readonly>
													</td>
												</tr>
											<?php endif; ?>
											<?php if (!empty($row['description_6'])): ?>
												<tr>
													<td>
														<input type="text" name="sr_6" value="<?php echo $row['sr_6']; ?>"
															class="w-100" readonly>
													</td>
													<td>
														<input type="text" name="description_6"
															value="<?php echo $row['description_6']; ?>" class="w-100" readonly>
													</td>
													<td>
														<input type="text" name="purpose_6" value="<?php echo $row['purpose_6']; ?>"
															class="w-100" readonly>
													</td>
													<td>
														<input type="text" name="qty_6" value="<?php echo $row['qty_6']; ?>"
															class="w-100" readonly>
													</td>
													<td>
														<input type="text" name="price_6" value="<?php echo $row['price_6']; ?>"
															class="w-100" readonly>
													</td>
													<td>
														<input type="text" name="amount_6" value="<?php echo $row['amount_6']; ?>"
															class="w-100" readonly>
													</td>
												</tr>
											<?php endif; ?>
											<?php if (!empty($row['description_7'])): ?>
												<tr>
													<td>
														<input type="text" name="sr_7" value="<?php echo $row['sr_7']; ?>"
															class="w-100" readonly>
													</td>
													<td>
														<input type="text" name="description_7"
															value="<?php echo $row['description_7']; ?>" class="w-100" readonly>
													</td>
													<td>
														<input type="text" name="purpose_7" value="<?php echo $row['purpose_7']; ?>"
															class="w-100" readonly>
													</td>
													<td>
														<input type="text" name="qty_7" value="<?php echo $row['qty_7']; ?>"
															class="w-100" readonly>
													</td>
													<td>
														<input type="text" name="price_7" value="<?php echo $row['price_7']; ?>"
															class="w-100" readonly>
													</td>
													<td>
														<input type="text" name="amount_7" value="<?php echo $row['amount_7']; ?>"
															class="w-100" readonly>
													</td>
												</tr>
											<?php endif; ?>
											<?php if (!empty($row['description_8'])): ?>
												<tr>
													<td>
														<input type="text" name="sr_8" value="<?php echo $row['sr_8']; ?>"
															class="w-100" readonly>
													</td>
													<td>
														<input type="text" name="description_8"
															value="<?php echo $row['description_8']; ?>" class="w-100" readonly>
													</td>
													<td>
														<input type="text" name="purpose_8" value="<?php echo $row['purpose_8']; ?>"
															class="w-100" readonly>
													</td>
													<td>
														<input type="text" name="qty_8" value="<?php echo $row['qty_8']; ?>"
															class="w-100" readonly>
													</td>
													<td>
														<input type="text" name="price_8" value="<?php echo $row['price_8']; ?>"
															class="w-100" readonly>
													</td>
													<td>
														<input type="text" name="amount_8" value="<?php echo $row['amount_8']; ?>"
															class="w-100" readonly>
													</td>
												</tr>
											<?php endif; ?>
											<?php if (!empty($row['description_9'])): ?>
												<tr>
													<td>
														<input type="text" name="sr_9" value="<?php echo $row['sr_9']; ?>"
															class="w-100" readonly>
													</td>
													<td>
														<input type="text" name="description_9"
															value="<?php echo $row['description_9']; ?>" class="w-100" readonly>
													</td>
													<td>
														<input type="text" name="purpose_9" value="<?php echo $row['purpose_9']; ?>"
															class="w-100" readonly>
													</td>
													<td>
														<input type="text" name="qty_9" value="<?php echo $row['qty_9']; ?>"
															class="w-100" readonly>
													</td>
													<td>
														<input type="text" name="price_9" value="<?php echo $row['price_9']; ?>"
															class="w-100" readonly>
													</td>
													<td>
														<input type="text" name="amount_9" value="<?php echo $row['amount_9']; ?>"
															class="w-100" readonly>
													</td>
												</tr>
											<?php endif; ?>
											<?php if (!empty($row['description_10'])): ?>
												<tr>
													<td>
														<input type="text" name="sr_10" value="<?php echo $row['sr_10']; ?>"
															class="w-100" readonly>
													</td>
													<td>
														<input type="text" name="description_10"
															value="<?php echo $row['description_10']; ?>" class="w-100" readonly>
													</td>
													<td>
														<input type="text" name="purpose_10"
															value="<?php echo $row['purpose_10']; ?>" class="w-100" readonly>
													</td>
													<td>
														<input type="text" name="qty_10" value="<?php echo $row['qty_10']; ?>"
															class="w-100" readonly>
													</td>
													<td>
														<input type="text" name="price_10" value="<?php echo $row['price_10']; ?>"
															class="w-100" readonly>
													</td>
													<td>
														<input type="text" name="amount_10" value="<?php echo $row['amount_10']; ?>"
															class="w-100" readonly>
													</td>
												</tr>
											<?php endif; ?>
											<tr>
												<td colspan="5" class="px-2"
													style="text-align: right !important;font-weight:500;font-size:14px">Total
													Amount</td>
												<td>
													<input type="text" name="total_amount"
														value="<?php echo $row['total_amount']; ?>" class="w-100" readonly
														style="color:red;font-weight:400;font-size:14px">
												</td>
											</tr>
											<!-- breakdown start  -->
											<?php
											$evidenceNumbers = json_decode($row['evidence_numbers'] ?? '[]', true);
											if (is_array($evidenceNumbers) && !empty($evidenceNumbers)) {
												$sumEvidence = array_sum(array_map('floatval', $evidenceNumbers));
												$totalAmount = (float) $row['total_amount'];
												$difference = abs($totalAmount - $sumEvidence);
												$statusText = $sumEvidence > $totalAmount ? 'Credit' : ($sumEvidence < $totalAmount ? 'Debit' : 'Balanced');

												// Format function
												function formatNoTrailingZeros($num)
												{
													$num = floatval($num);
													return (intval($num) == $num) ? intval($num) : number_format($num, 2);
												}
											?>
												<tr>
													<td colspan="6" class="px-5 py-2"
														style="text-align:right;font-weight:600;font-size:16px;background-color:#F3F1F5">
														<i class="fa-solid fa-receipt"></i> Evidence Breakdown
													</td>

												</tr>

												<tr>
													<td colspan="4">

													</td>
													<td colspan="2"
														style="text-align:left;font-weight:350;font-size:12px;letter-spacing:.2px!important"
														class="lead">
														<?php foreach ($evidenceNumbers as $i => $num): ?>
															<span style="display:block;"><span style="font-weight:500;">Evidence <?= $i + 1 ?></span> =
																<?= formatNoTrailingZeros($num) ?></span>
														<?php endforeach; ?>
														<hr style="margin:4px 0;">
														<span style="font-weight:500;">Total Evidence Amount:</span>
														<?= formatNoTrailingZeros($sumEvidence) ?><br>
														<span style="font-weight:500;">Amount Requested by user:</span>
														<?= formatNoTrailingZeros($totalAmount) ?><br>
														<span style="font-weight:500;">Difference:</span> <?= formatNoTrailingZeros($difference) ?>
														(<?= $statusText ?>)
													</td>
												</tr>


												<tr style="border:0px solid white!important">
													<td colspan="6" style="text-align:center;font-size:12px!important;">
														<?php if ($row['paid'] === 'yes'): ?>
															Final Balance 0 <span class="text-success fw-bold">(Paid)</span>
														<?php elseif ($row['receive'] === 'yes'): ?>
															Final Balance 0 <span class="text-primary fw-bold">(Received)</span>
														<?php else: ?>
															<?php if ($statusText === 'Debit'): ?>
																<a href="cash_purchase_paid.php?id=<?= $row['id']; ?>" style="text-align:center;font-size:12px!important;"
																	class="btn btn-primary">Paid</a>
															<?php elseif ($statusText === 'Credit'): ?>
																<a href="cash_purchase_receive.php?id=<?= $row['id']; ?>" style="text-align:center;font-size:12px!important;"
																	class="btn btn-secondary">Received</a>
															<?php else: ?>
																Balanced
															<?php endif; ?>
														<?php endif; ?>
													</td>
												</tr>
											<?php } ?>

											<tr style="border:0px solid white!important">
												<td colspan="6">
													<form method="POST">
														<label for="admin_comments"
															style="font-weight:600;display:block;margin-bottom:5px;">Admin
															Comments</label>
														<input class="p-2" name="admin_comments" id="admin_comments"
															style="width:100%;background-color:#DBDFEA"
															value="<?php echo $row['admin_comments']; ?>" readonly>
													</form>
												</td>
											</tr>
											<tr style="border:0px solid white!important">
												<td colspan="6">
													<form method="POST">
														<label for="finance_comments" class="pt-2"
															style="font-weight:600;display:block;margin-bottom:5px;">Finance
															Comments</label>
														<input class="p-2" name="finance_comments"
															id="admin_comfinance_commentsments" style="width:100%"
															value="<?php echo $row['finance_comments']; ?>">
														<button type="submit" name="finance_sub" class="button-commentN mt-2">
															Add Comments
														</button>
													</form>
												</td>
											</tr>
										</tbody>
									</table>
									<!-- evidence upload start  -->
									<div class="bg-white p-3 mt-3" style="border:0.5px solid black!important">
										<form method="POST" enctype="multipart/form-data">
											<div class="row text-center align-items-center">
												<div style="text-align:center;" class="mb-3">
													<h6 style="
                                            font-size:16px;
                                            font-weight:600;
                                            color:#222;
                                            border-bottom:2px solid #0d6efd;
                                            display:inline-block;
                                            padding-bottom:4px;
                                            margin:0;
        ">
														Evidence Section
													</h6>

												</div>
												<div class="text-start pb-2">
													<small style="font-size:12.5px;"><b>Images:</b> only JPEG and PNG format are allowed</small><br>
													<small style="font-size:12.5px;"><b>PDF:</b> File size limit is 5MB</small>
												</div>
												<!-- <?php if ($row['status'] === 'Open'): ?>
													<div class="col-md-4" style="border-right: 2px solid #000;">
														<input type="file" name="evidence_files[]" multiple accept="image/*,application/pdf"
															class="form-control mx-auto"
															style="max-width:240px;font-size:12px!important;height:32px!important"
															required>
													</div>
													<div class="col-md-4" style="border-right: 2px solid #000;">
														<button type="submit" name="upload_evidence" class="button-uploadevidenceN">
															<i class="fa-solid fa-upload"></i> Upload Evidence </button><br>
													</div>
												<?php endif; ?> -->
												<?php if (!empty($row['evidence'])): ?>
													<!-- Box 3: View Evidence Button -->
													<div class="col-md-4">
														<button type="button" class="button-evidenceN"
															data-bs-toggle="modal" data-bs-target="#evidenceModal"
															style="font-size:12.5px; padding:4px 10px;">
															<i class="fa-solid fa-image me-1"></i> View Evidence
														</button>
													</div>
												<?php endif; ?>
											</div>
										</form>
									</div>
									<!-- evidence upload end -->



















									<!-- Report Sectionn Start -->

									<div class="bg-white p-3 mt-3" style="border:0.5px solid black!important">
										<!-- Header -->
										<div class="text-center mb-3">
											<h6 style="
                                            font-size:16px;
                                            font-weight:600;
                                            color:#222;
                                            border-bottom:2px solid #0d6efd;
                                            display:inline-block;
                                            padding-bottom:4px;
                                            margin:0;
        ">
												Approval Section
											</h6>
										</div>
										<!-- Evidence -->
										<!-- <div class="d-flex align-items-center mb-3" style="gap:10px;">
											<p class="mb-0 fw-semibold text-dark" style="font-size:13px;">

											</p>
											<button type="button" class="button-evidenceN"
												data-bs-toggle="modal" data-bs-target="#evidenceModal"
												style="font-size:12.5px; padding:4px 10px;">
												<i class="fa-solid fa-image me-1"></i> View Evidence
											</button>
										</div> -->
										<!-- Approval -->
										<?php if ($row['finance_status'] === 'Pending'): ?>
											<div class="d-flex align-items-center mb-3" style="gap:10px;">
												<p class="mb-0 fw-semibold text-dark" style="font-size:13px;">

												</p>
												<a href="cash_purchase_finance_approve.php?id=<?= $row['id']; ?>"
													class="button-approveN d-flex align-items-center">
													<i class="fa-solid fa-check me-1"></i> Approve
												</a>
												<a href="cash_purchase_finance_reject.php?id=<?= $row['id']; ?>"
													class="button-rejectN d-flex align-items-center">
													<i class="fa-solid fa-xmark me-1"></i> Reject
												</a>
											</div>
										<?php endif; ?>
										<!-- Status Section -->
										<div class="mb-3" style="line-height:1.6;">
											<?php if ($row['finance_status'] !== 'Pending'): ?>
												<p class="mb-1" style="font-size:13px; color:black;">
													<strong>Finance Status:</strong>
													<span style="font-weight:600; color:<?= $row['finance_status'] === 'Approved' ? 'green' : ($row['finance_status'] === 'Rejected' ? 'red' : '#333'); ?>">
														<?= $row['finance_status']; ?>
													</span>
												</p>
											<?php endif; ?>

											<p class="mb-1" style="font-size:13px; color:black;">
												<strong>Admin Status:</strong>
												<span style="font-weight:600; color:<?= $row['admin_status'] === 'Approved' ? 'green' : ($row['admin_status'] === 'Rejected' ? 'red' : '#333'); ?>">
													<?= $row['admin_status']; ?>
												</span>
											</p>
										</div>


										<!-- Final Status (Open / Closed) -->
										<?php if ($row['status'] === 'Open'): ?>
											<div class="d-flex align-items-center flex-wrap bg-light border rounded px-3 py-2 mb-2"
												style="gap: 20px; border-left:4px solid green;">
												<p class="mb-0 text-dark" style="font-size:13px;">
													<strong>Final Status:</strong>
													<span style="color:green; font-weight:600;">Open</span>
												</p>
												<p class="mb-0 text-secondary" style="font-size:13px;font-weight:500;">
													Request is active
												</p>
												<a href="cash_purchase_finance_close.php?id=<?= $row['id']; ?>"
													class="button-closeN btn-sm d-flex align-items-center"
													style="font-size:12px; padding:4px 10px;">
													<i class="fa-solid fa-xmark me-1"></i> Close Request
												</a>
											</div>
										<?php endif; ?>
										<?php if ($row['status'] === 'Closed'): ?>
											<div class="d-flex align-items-center flex-wrap bg-light border rounded px-3 py-2"
												style="gap: 20px; border-left:4px solid red;">
												<p class="mb-0 text-dark" style="font-size:13px;">
													<strong>Final Status:</strong>
													<span style="color:red; font-weight:600;">Closed</span>
												</p>
												<p class="mb-0 text-secondary" style="font-size:13px;font-weight:500;">
													<?= $row['status_by']; ?>
												</p>
												<a href="cash_purchase_finance_close_reverse.php?id=<?= $row['id']; ?>"
													class="button-openN d-flex align-items-center"
													style="font-size:12px; padding:4px 10px;">
													<i class="fa-solid fa-plus me-1"></i> Open Request
												</a>
											</div>
										<?php endif; ?>
									</div>
									<!-- Report Section End -->


									<!-- evidence Viewer Modal start  -->
									<?php if (!empty($row['evidence'])): ?>
										<?php
										$images = json_decode($row['evidence'], true);
										$numbers = json_decode($row['evidence_numbers'] ?? '[]', true);
										?>
										<div class="modal fade" id="evidenceModal" tabindex="-1" aria-hidden="true">
											<div class="modal-dialog modal-xl modal-dialog-centered">
												<div class="modal-content bg-dark bg-opacity-75">
													<div class="modal-header border-0">
														<h5 class="text-white d-flex align-items-center gap-2">
															Evidence Viewer
															<span id="currentEvidenceIndex"
																style="background:#FEB21A;color:black;padding:2px 10px;border-radius:12px;font-weight:600;">
																#1
															</span>
															<span class="badge"
																style="background-color:#A16D28!important;color:white!important;border-radius:15px!important;">
																Total: <?= count($images); ?>
															</span>
														</h5>
														<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
													</div>
													<div class="modal-body text-center">
														<form method="POST">
															<input type="hidden" name="id" value="<?= $row['id']; ?>">
															<!-- Swiper Main -->
															<div class="swiper mySwiper2 mb-3">
																<div class="swiper-wrapper">
																	<?php foreach ($images as $index => $image): ?>
																		<?php $fileExtension = strtolower(pathinfo($image, PATHINFO_EXTENSION)); ?>
																		<div class="swiper-slide position-relative">
																			<!-- Number Input -->
																			<!-- <div class="mb-2">
																				<label for="number_<?= $index ?>" class="text-white">Enter Amount:</label><br>
																				<small style="color:#DCDCDC; font-size:11.5px;">Enter the amount for this evidence (Required)</small>
																				<input type="number" name="evidence_numbers[<?= $index ?>]"
																					id="number_<?= $index ?>"
																					class="form-control text-center mx-auto w-25 py-3 my-3"
																					value="<?= $numbers[$index] ?? '' ?>">
																			</div> -->
																			<!-- Image or PDF Display (same height for both) -->
																			<?php if ($fileExtension === 'pdf'): ?>
																				<embed src="<?= $image ?>" type="application/pdf" width="100%" height="400px">
																			<?php else: ?>
																				<img src="<?= $image ?>" class="img-fluid evidence-img"
																					style="height:400px;width:auto;object-fit:contain;cursor:pointer;"
																					onclick="openFullscreen(this.src)">
																			<?php endif; ?>
																			<!-- Action Buttons -->
																			<div class="my-4 d-flex justify-content-center align-items-center gap-3 flex-wrap">
																				<?php if ($fileExtension === 'pdf'): ?>
																					<a href="<?= $image ?>" target="_blank"
																						class="button-pdfN">
																						<i class="fa-solid fa-file-pdf"></i> Open PDF
																					</a>
																				<?php endif; ?>
																				<!-- <button type="submit" name="save_evidence_numbers"
																		class="button-commentN"
																		>
																		<i class="fa-solid fa-floppy-disk"></i> Save Amount
																	</button>
																	<button type="button" class="button-rejectN"
															
																		onclick="deleteEvidence('<?= $row['id']; ?>', '<?= $image; ?>')">
																		<i class="fa-regular fa-trash-can"></i> Delete Evidence
																	</button> -->
																			</div>
																		</div>
																	<?php endforeach; ?>
																</div>
																<!-- Main navigation arrows -->
																<div class="swiper-button-next"></div>
																<div class="swiper-button-prev"></div>
															</div>
														</form>
														<!-- Swiper Thumbnails -->
														<div class="swiper mySwiper mt-3 position-relative">
															<div class="swiper-wrapper">
																<?php foreach ($images as $image): ?>
																	<?php $ext = strtolower(pathinfo($image, PATHINFO_EXTENSION)); ?>
																	<div class="swiper-slide" style="margin-right:5px;">
																		<?php if ($ext === 'pdf'): ?>
																			<div class="border text-white p-2 rounded d-flex align-items-center justify-content-center"
																				style="background-color:#DC143C!important;height:100px;width:100px;">
																				PDF
																			</div>
																		<?php else: ?>
																			<img src="<?= $image; ?>" class="img-thumbnail"
																				style="height:100px;width:100px;object-fit:cover;">
																		<?php endif; ?>
																	</div>
																<?php endforeach; ?>
															</div>
															<!-- Thumbnail navigation buttons -->
															<div class="swiper-button-next thumb-next" style="color:white;"></div>
															<div class="swiper-button-prev thumb-prev" style="color:white;"></div>
														</div>
													</div>
												</div>
											</div>
										</div>
									<?php endif; ?>
									<!-- evidence Viewer Modal end  -->

									<!-- save evidence number start -->
									<?php
									if (isset($_POST['save_evidence_numbers'])) {
										$id = $_POST['id'];
										$numbers = $_POST['evidence_numbers'] ?? [];

										// Ensure order consistency
										ksort($numbers);

										// Normalize to fill empty spots with null if needed
										$result = mysqli_query($conn, "SELECT evidence FROM cash_purchase WHERE id = '$id'");
										$row_data = mysqli_fetch_assoc($result);
										$images = json_decode($row_data['evidence'], true);

										$finalNumbers = [];
										foreach ($images as $index => $img) {
											$finalNumbers[] = isset($numbers[$index]) ? $numbers[$index] : null;
										}

										$encoded = json_encode($finalNumbers);
										mysqli_query($conn, "UPDATE cash_purchase SET evidence_numbers = '$encoded' WHERE id = '$id'");
										echo "<script>alert('Evidence numbers saved successfully!'); window.location.href = window.location.href;</script>";
									}
									?>
									<!-- save evidence number end -->

									<!-- delete evidence start -->
									<?php
									if (isset($_POST['delete_evidence'])) {
										$id = $_POST['id'];
										$deleteImage = $_POST['delete_image'];

										$result = mysqli_query($conn, "SELECT evidence, evidence_numbers FROM cash_purchase WHERE id = '$id'");
										$row_del = mysqli_fetch_assoc($result);

										$images = json_decode($row_del['evidence'], true);
										$numbers = json_decode($row_del['evidence_numbers'], true);

										// Fallback if null
										if (!is_array($images)) {
											$images = [];
										}
										if (!is_array($numbers)) {
											$numbers = [];
										}

										if (($key = array_search($deleteImage, $images)) !== false) {
											if (file_exists($deleteImage)) {
												unlink($deleteImage);
											}
											unset($images[$key]);
											unset($numbers[$key]);
										}

										// Re-index arrays
										$updatedImages = json_encode(array_values($images));
										$updatedNumbers = json_encode(array_values($numbers));

										mysqli_query($conn, "UPDATE cash_purchase SET evidence = '$updatedImages', evidence_numbers = '$updatedNumbers' WHERE id = '$id'");

										echo "<script>alert('Evidence deleted successfully!'); window.location.href = window.location.href;</script>";
									}
									?>
									<!-- delete evidence end -->

									<!-- upload evidence start -->
									<?php
									if (isset($_POST['upload_evidence'])) {
										$id = $_GET['id'];
										$targetDir = "uploads/evidence/";
										$uploadedFiles = [];
										$maxFileSize = 5 * 1024 * 1024; // 5 MB limit

										// Fetch current evidence array
										$result = mysqli_query($conn, "SELECT evidence FROM cash_purchase WHERE id = '$id'");
										$row_evi = mysqli_fetch_assoc($result);
										$existingFiles = json_decode($row_evi['evidence'], true) ?? [];

										foreach ($_FILES['evidence_files']['tmp_name'] as $key => $tmpName) {
											$fileName = basename($_FILES['evidence_files']['name'][$key]);
											$fileSize = $_FILES['evidence_files']['size'][$key];
											$fileType = mime_content_type($tmpName);

											// Validate file size
											if ($fileSize > $maxFileSize) {
												echo "<script>alert('Error: File $fileName exceeds 5MB limit!');</script>";
												continue;
											}

											// Validate file type (image or PDF only)
											if (!in_array($fileType, ['image/jpeg', 'image/png', 'image/gif', 'application/pdf'])) {
												echo "<script>alert('Error: Invalid file type for $fileName! Only images or PDFs allowed.');</script>";
												continue;
											}

											// Generate unique name
											$filename = time() . '_' . $fileName;
											$targetPath = $targetDir . $filename;

											if (move_uploaded_file($tmpName, $targetPath)) {
												$uploadedFiles[] = $targetPath;
											}
										}

										if (!empty($uploadedFiles)) {
											$finalFiles = array_merge($existingFiles, $uploadedFiles);
											$evidenceJson = json_encode($finalFiles);
											mysqli_query($conn, "UPDATE cash_purchase SET evidence = '$evidenceJson' WHERE id = '$id'");
											echo "<script>alert('Evidence uploaded successfully!'); window.location.href = window.location.href;</script>";
										} else {
											echo "<script>alert('No valid files uploaded!');</script>";
										}
									}
									?>
									<!-- upload evidence end -->

									<?php
									include 'dbconfig.php';

									// Check if form is submitted
									if (isset($_POST['finance_sub'])) {
										// Retrieve form data
										$id = $_GET['id'];  // Assuming 'id' is passed via GET method
										$name = $_SESSION['fullname'];

										// If admin_comments is set in POST, use it, otherwise keep existing
										$finance_comments = isset($_POST['finance_comments']) && $_POST['finance_comments'] !== $row['finance_comments']
											? $_POST['finance_comments']
											: $row['finance_comments'];

										// Update query (only updates cash_purchase table)
										$update_query = "UPDATE cash_purchase 
										SET finance_comments = '$finance_comments'
										WHERE id = '$id'";

										$result = mysqli_query($conn, $update_query);

										if ($result) {
											echo "<script>
							alert('Finance comments updated successfully.');
							window.location.href = window.location.href;
							</script>";
										} else {
											echo "<script>
							alert('Update Failed.');
							window.location.href = window.location.href;
							</script>";
										}
									}
									?>
								</div>
						<?php
					}
				} else {
					echo "No record found!";
				}
						?>
						</div>
						<!--content-->
					</div>
					<?php
					include 'cdnjs.php'
					?>
			<script>
$(document).ready(function() {

    // Ensure sidebar is CLOSED by default
    $('#sidebar').removeClass('active');

    // Handle sidebar collapse toggle
    $('#sidebarCollapse').on('click', function() {
        $('#sidebar').toggleClass('active');
    });

    // Update the icon when collapsing/expanding
    $('[data-bs-toggle="collapse"]').on('click', function() {
        var target = $(this).find('.toggle-icon');

        if ($(this).attr('aria-expanded') === 'true') {
            target.removeClass('fa-plus').addClass('fa-minus');
        } else {
            target.removeClass('fa-minus').addClass('fa-plus');
        }
    });

});
</script>
					<script src="
			https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.28.0/tableExport.min.js
			"></script>
					<script type="text/javascript" src="libs/FileSaver/FileSaver.min.js"></script>
					<script type="text/javascript" src="../libs/jsPDF/polyfills.umd.js"></script>
					<script type="text/javascript" src="tableExport.min.js"></script>
					<!-- TABLE EXPORT -->
					<!-- ALL -->
					<script type="text/javascript">
						$(document).ready(function() {
							$('#excel').click(function() {
								$('#myTable').tableExport({
									type: 'excel',
									ignoreColumn: []
								});
							});
						});
					</script>
					<!-- ALL -->
					<script>
						$(document).ready(function() {
							(function($) {
								$('#filter').keyup(function() {
									var rex = new RegExp($(this).val(), 'i');
									$('.searchable tr').hide();
									$('.searchable tr').filter(function() {
										return rex.test($(this).text());
									}).show();
								})
							}(jQuery));
						});
					</script>
					<script src="assets/js/main.js"></script>
					<!-- 2-->
					<script>
						function promptReason2(itemId) {
							var reason = prompt("Enter reason for rejection:");
							if (reason != null && reason.trim() !== "") {
								window.location.href = "ot_fpna_reject_2.php?id=" + itemId + "&reason=" + encodeURIComponent(reason);
							}
						}
					</script>
					<script>
						function submitRejectionReason(itemId, reason) {
							var xhr = new XMLHttpRequest();
							xhr.onreadystatechange = function() {
								if (xhr.readyState == 4 && xhr.status == 200) {
									location.reload();
								}
							};
							xhr.open("POST", "update_rejection_reason.php", true);
							xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
							xhr.send("id=" + itemId + "&reason=" + encodeURIComponent(reason));
						}
					</script>
					<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

					<script>
						// Thumbnail Swiper
						var thumbSwiper = new Swiper(".mySwiper", {
							spaceBetween: 10,
							slidesPerView: 5,
							watchSlidesProgress: true,
							navigation: {
								nextEl: ".thumb-next",
								prevEl: ".thumb-prev",
							},
						});

						// Main Swiper
						var mainSwiper = new Swiper(".mySwiper2", {
							spaceBetween: 10,
							loop: true,
							navigation: {
								nextEl: ".swiper-button-next",
								prevEl: ".swiper-button-prev",
							},
							thumbs: {
								swiper: thumbSwiper,
							},
							on: {
								slideChange: function() {
									const current = (this.realIndex ?? 0) + 1;
									document.getElementById("currentEvidenceIndex").innerText = "#" + current;
								}
							}
						});

						// Fullscreen function
						function openFullscreen(src) {
							let win = window.open("", "_blank");
							win.document.write(`<img src="${src}" style="width:100%;height:100%;object-fit:contain">
        <button onclick="window.close()" style="position:fixed;top:10px;right:10px;z-index:999;padding:10px;background:red;color:white;border:none;border-radius:8px;">Close</button>`);
						}

						// Delete evidence function
						function deleteEvidence(id, imagePath) {
							if (!confirm('Delete this evidence?')) return;

							const form = document.createElement('form');
							form.method = 'POST';
							form.style.display = 'none';

							const idInput = document.createElement('input');
							idInput.name = 'id';
							idInput.value = id;
							form.appendChild(idInput);

							const imgInput = document.createElement('input');
							imgInput.name = 'delete_image';
							imgInput.value = imagePath;
							form.appendChild(imgInput);

							const actionInput = document.createElement('input');
							actionInput.name = 'delete_evidence';
							actionInput.value = '1';
							form.appendChild(actionInput);

							document.body.appendChild(form);
							form.submit();
						}
					</script>
</body>

</html>