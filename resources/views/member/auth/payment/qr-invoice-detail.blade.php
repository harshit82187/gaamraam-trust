<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Gaam Raam Trust Donation Receipt Details</title>
		<style>
			table {
			width: 100%;
			border-collapse: collapse;
			margin: 10px 0;
			}
			th,
			td {
			padding: 8px;
			border: 1px solid gray;
			text-align: left;
			}
			th {
			background-color: rgb(180, 180, 180);
			}
			h1 {
			text-align: center;
			font-size: 35px;
			color: rgb(180, 180, 180);
			}
			table tr th {
			font-size: 11px;
			text-align: center;
			color: black;
			}
			table tr td {
			font-size: 12px;
			text-align: center;
			}
			.invoice-mobile {
			background-color: rgb(24, 23, 23);
			color: #fff;
			}
			/*  */
			.card {
			width: 100%;
			border: 1px solid #ddd;
			border-radius: 5px;
			margin-bottom: 20px;
			box-shadow: 0 -2px 5px rgba(245, 243, 243, 0.5), 0 2px 5px rgba(245, 243, 243, 0.5);
			}
			.card-body {
			padding: 10px;
			}
			/* .invoive-mobile img{
			margin: 20px 0;
			text-align: right;
			margin-left: 50%;
			} */
			.main-img{
			display: flex;
			justify-content: center;
			align-items: center;
			margin-bottom: 20px;
			}
		</style>
	</head>
	<body class="invoice-mobile">
		<section class="invoive-mobile">
			<div class="container">
				<h1>Gaam Raam Trust Donation Receipt Details</h1>
				<div class="main-img">
					<img src="{{ asset('front/images/Gaam_Raam_logo.png') }}" height="auto" width="250px"  alt="logo" >
				</div>
				<div class="card">
					<div class="card-body">
						<table>
							<tr>
								<th><strong>Invoice No:</strong></th>
								<td>{{ $payment_table->invoice_no ?? '' }}</td>
							</tr>
							<tr>
								<th><strong>Donate Amount:</strong></th>
								<td>{{ number_format($payment_table->amount, 2) }}</td>
							</tr>
						</table>
					</div>
				</div>
				<div class="card">
					<div class="card-body">
						<table>
							<tr>
								<th>Name</th>
								<td> {{ $payment_table->user_name ?? 'N/A' }}</td>
							</tr>
							<tr>
								<th>Mobile No</th>
								<td> {{ $payment_table->user_mobile ?? 'N/A'}}</td>
							</tr>
							<tr>
								<th>Mobile No</th>
								<td> {{  $payment_table->user_email ?? 'N/A' }}</td>
							</tr>
							@if(in_array($payment_table->mode, [1, 2]))
							<tr>
								<th>Razorpay Id</th>
								<td> {{  $payment_table->r_payment_id ?? 'N/A' }}</td>
							</tr>
							@endif
						</table>
					</div>
				</div>
			</div>
		</section>
	</body>
</html>