<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Gaam Raam - Member</title>
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
			.email-footer a{
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
                <h2>Password Reset Email</h2>
            </div>
			<div class="email-body">
				<p>Hello <strong>{{ $data['name'] ?? '' }}</strong>,</p>
				<p>We have received a request to reset your password. If you did not initiate this request, please ignore this email.</p>
				<p>To reset your password, click the button below:</p>
				@if($data['type'] == 1)
				<div>
					<a href="{{ route('student-resetPassword', ['email' => $data['email'], 'token' => $data['token']]) }}" 
					   style="display: inline-block; background-color: #ff7029; color: #ffffff; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
					   Reset Your Password
					</a>    
				</div>
				<p>If the button above does not work, you can also copy and paste the following link into your browser:</p>
				<p>
					<a href="{{ route('student-resetPassword', ['email' => $data['email'], 'token' => $data['token']]) }}" style="color:#ff7029;">
						{{ route('student-resetPassword', ['email' => $data['email'], 'token' => $data['token']]) }}
					</a>
				</p>
				@elseif($data['type'] == 2)
					<div>
						<a href="{{ route('resetPassword', ['email' => $data['email'], 'token' => $data['token']]) }}" 
						style="display: inline-block; background-color: #ff7029; color: #ffffff; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
						Reset Your Password
						</a>    
					</div>
					<p>If the button above does not work, you can also copy and paste the following link into your browser:</p>
					<p>
						<a href="{{ route('resetPassword', ['email' => $data['email'], 'token' => $data['token']]) }}" style="color:#ff7029;">
							{{ route('resetPassword', ['email' => $data['email'], 'token' => $data['token']]) }}
						</a>
					</p>
				@elseif($data['type'] == 3)
					<div>
						<a href="{{ route('institute-resetPassword', ['email' => $data['email'], 'token' => $data['token']]) }}" 
						style="display: inline-block; background-color: #ff7029; color: #ffffff; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
						Reset Your Password
						</a>    
					</div>
					<p>If the button above does not work, you can also copy and paste the following link into your browser:</p>
					<p>
						<a href="{{ route('institute-resetPassword', ['email' => $data['email'], 'token' => $data['token']]) }}" style="color:#ff7029;">
							{{ route('institute-resetPassword', ['email' => $data['email'], 'token' => $data['token']]) }}
						</a>
					</p>
				@elseif($data['type'] == 4)
					<div>
						<a href="{{ route('admin.resetPassword', ['email' => $data['email'], 'token' => $data['token']]) }}" 
						style="display: inline-block; background-color: #ff7029; color: #ffffff; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
						Reset Your Password
						</a>    
					</div>
					<p>If the button above does not work, you can also copy and paste the following link into your browser:</p>
					<p>
						<a href="{{ route('admin.resetPassword', ['email' => $data['email'], 'token' => $data['token']]) }}" style="color:#ff7029;">
							{{ route('admin.resetPassword', ['email' => $data['email'], 'token' => $data['token']]) }}
						</a>
					</p>

					@else 
						<p>Nothing!!</p>

				@endif
				<p>For security reasons, this link will expire after a certain period.</p>
				<p>Thank you!</p>       
			</div>
			<div class="email-footer">
				<p>{{ date('Y') }} © All Rights Reserved. <i class="fa fa-heart heart text-danger"></i> By
                    <a href="{{ url('/') }}" target="_blank" style="color:#ff7029 !important;" >Gaam Raam Trust </a> And Powered By <a href="{{ url('https://www.pearlorganisation.com/') }}" target="_blank" style="color:#ff7029 !important;">Pearl Organisation</a></p>
			</div>
		</div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-VoPF5bLNmH3EaA8yexOaMIXV5GQpLw5jEEJqDlu0UDFIPhHIyggD5fXcjEjWKKej" crossorigin="anonymous"></script>

	</body>
</html>