<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Document Verification</title>
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
				<h2>✅ Step 2: Your Documents are Verified! Next Step: Aptitude Test</h2>
			</div>
			<div class="email-body">
                <p>Dear <strong>{{ $studentName ?? 'Aspirant' }}</strong>,</p>
                <p>Your document verification is complete, and you are now eligible for the Aptitude Test & Institution Selection.</p>
				<h3>Next Steps:</h3>
				<ul>
					<li>✔ <strong>Take the Aptitude Test:</strong> The test will assess your problem-solving and analytical abilities.</li>
					<li>✔ <strong>Get Ranked:</strong> Your performance will determine your ranking.</li>
					<li>✔ <strong>Select Your Institution:</strong> Top-ranked students will get the first choice from our partnered institutions.</li>
				</ul>
				<p><strong>📅 Test Date:</strong> [Insert Date]</p>
				<p><strong>📍 Test Link:</strong> <a href="[Insert Link]" target="_blank" style="color:#ff7029 !important;">Click Here to Take the Test</a></p>
				<p>⏳ <strong>Complete this step on time to secure your seat!</strong></p>
				<p>If you have any questions, feel free to contact us.</p>
				<p>Best regards,<br><strong>GaamRaam NGO Team</strong></p>
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