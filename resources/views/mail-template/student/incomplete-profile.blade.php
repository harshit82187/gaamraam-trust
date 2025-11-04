<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Students Details</title>
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
			.email-footer a{
			text-decoration: none;			
			}
			a{
			text-decoration: none;			
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
                <img src="https://gaamraam.ngo/public/front/images/Gaam_Raam_logo.png" alt="logo" style="max-width: 150px;">
                <h2>Students Details</h2>
            </div>
			<div class="email-body">
                <p>Dear {{ $student->name ?? 'N/A' }},</p>
                <p>We noticed that your profile is incomplete. Please review the following missing information:</p>
                @if(!empty($missingFields))
                    <h4>Missing Profile Fields:</h4>
                    <ul>
                        @foreach($missingFields as $field)
                            <li>{{ $field ?? 'N/A' }}</li>
                        @endforeach
                    </ul>
                @endif
                @if(!empty($missingDocuments))
                    <h4>Missing Documents:</h4>
                    <ul>
                        @foreach($missingDocuments as $doc)
                            <li>{{ $doc ?? 'N/A' }}</li>
                        @endforeach
                    </ul>
                @endif
                <p>Please complete your profile and upload the required documents at the earliest.</p>
                <p>Regards,<br>
                Support Team<br>
                Email: <a href="mailto:{{ $adminEmail ?? 'N/A' }}">{{ $adminEmail ?? 'N/A' }}</a>
                </p>	
			</div>
			<div class="email-footer">
				<p>{{ date('Y') }} © All Rights Reserved. <i class="fa fa-heart heart text-danger"></i> By
                    <a href="{{ url('/') }}" target="_blank" style="color:#ff7029 !important;" >Gaam Raam Trust</a> And Powered By <a href="{{ url('https://www.pearlorganisation.com/') }}" target="_blank" style="color:#ff7029 !important;">Pearl Organisation</a></p>
			</div>
		</div>
	</body>
</html>