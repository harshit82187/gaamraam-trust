<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Punch Out Recorded</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQjW1CwCf0vMLX5pD9eGeU2Ud1Lnt2R9u5kIepUCB4WdPmUbTbyP6YI75" crossorigin="anonymous">
		<style>
			/* General styling for email */
			body {
			font-family: Arial, sans-serif;
			background-color: #f4f4f4;
			margin: 0;
			padding: 0;
			}
			.email-container {
			max-width: 600px;
			margin: 20px auto;
			background-color: #ffffff;
			padding: 20px;
			border: 1px solid #dddddd;
			border-radius: 5px;
			}
			.email-header {
			text-align: center;
			background-color: #ff7029;
			color: #ffffff;
			padding: 10px 0;
			border-radius: 5px 5px 0 0;
			}
			.email-header h2 {
			margin: 0;
			font-size: 24px;
			}
			.email-body {
			padding: 20px;
			}
			.email-body p {
			font-size: 16px;
			line-height: 1.6;
			}
			.email-footer {
			text-align: center;
			margin-top: 20px;
			font-size: 14px;
			color: #888888;
			}
			.email-footer a {
				text-decoration: none !important;
			}
			/* Styling for tables */
			table {
			width: 100%;
			border-collapse: collapse;
			margin-bottom: 20px;
			}
			th,
			td {
			border: 1px solid #dddddd;
			text-align: left;
			padding: 8px;
			}
			th {
			background-color: #ff7029;
			color: white;
			}
			
		</style>
	</head>
	<body>
		<div class="email-container">
			<div class="email-header" style="margin-bottom: 20px;">
				<img src="{{ asset('front/images/Gaam_Raam_logo.png') }}" alt="Company Logo" style="max-width: 150px;">
				<h2> Step 2: Upload Your Documents for Verification</h2>
			</div>
			<div class="email-body">
				<p>Dear <strong>{{ $student->name ?? 'Student' }}</strong>,</p>
                <p>We hope you had a productive day!</p>
                <p>Your attendance has been successfully recorded with the following details:</p>
                <ul>
                    <li><strong>Punch In:</strong> {{ \Carbon\Carbon::parse($attendance->punch_in)->format('d M Y, h:i A') }}</li>
                    <li><strong>Punch Out:</strong> {{ \Carbon\Carbon::parse($punchOutTime)->format('d M Y, h:i A') }}</li>
                    @if($note != null)
                    <p>{{ $note ?? 'N/A' }}</p>
                    @endif
                </ul>
                <p>If you notice any discrepancies, please contact the administration.</p>
                <p>Thank you for your dedication!</p>
			</div>
			<div class="email-footer">
				<p>{{ date('Y') }} © All Rights Reserved. <i class="fa fa-heart heart text-danger"></i> By
					<a href="{{ url('/') }}" target="_blank" style="color:#ff7029 !important;">Gaam Raam Trust</a> And Powered By 
					<a href="https://www.pearlorganisation.com/" target="_blank" style="color:#ff7029 !important;">Pearl Organisation</a>
				</p>
			</div>
		</div>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-VoPF5bLNmH3EaA8yexOaMIXV5GQpLw5jEEJqDlu0UDFIPhHIyggD5fXcjEjWKKej" crossorigin="anonymous"></script>
	</body>
	
</html>