<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Student Enrollment Verification</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 20px auto; background-color: #ffffff; padding: 20px; border: 1px solid #dddddd; border-radius: 5px;">
        <div style="text-align: center; background-color: #ff7029; color: #ffffff; padding: 10px 0; border-radius: 5px 5px 0 0; margin-bottom: 20px;">
            <img src="{{ asset('front/images/Gaam_Raam_logo.png') }}" alt="Company Logo" style="max-width: 150px;">
            <h2 style="margin: 0; font-size: 24px;">Step 2: Upload Your Documents for Verification</h2>
        </div>

        <div style="padding: 20px;">
            <p style="font-size: 16px; line-height: 1.6;">Dear <strong>{{ $data['name'] ?? 'Aspirant' }}</strong>,</p>
            <p style="font-size: 16px; line-height: 1.6;">Congratulations! Your sign-up is complete, and you are now ready for Step 2: Document Upload & Verification.</p>

            <h3 style="font-size: 18px;">What You Need to Do Next:</h3>
            <ul style="font-size: 16px; line-height: 1.6;">
                <li>✔ <strong>Log In:</strong> Click on “Student Login” at the top of our website and enter your registered email ID and password.</li>
                <li>✔ <strong>Upload Documents:</strong> In your Student Dashboard, go to the “Upload Documents” section and submit the required files.</li>
                <li>✔ <strong>Verification:</strong> Our team will review your documents, and you’ll receive an email once they are verified.</li>
            </ul>

            <p style="font-size: 16px; line-height: 1.6;">⏳ <strong>Complete this step on time to avoid delays in your enrollment.</strong></p>
            <p style="font-size: 16px; line-height: 1.6;">If you have any questions, feel free to contact us.</p>
            <p style="font-size: 16px; line-height: 1.6;">🚀 <strong>Proceed now!</strong></p>
            <p style="font-size: 16px; line-height: 1.6;">👤 <strong>Login Username:</strong> {{ $data['email'] ?? '' }}</p>
            <div>
                <p style="font-size: 16px; line-height: 1.6;">Click the link below to log in to your dashboard:</p>
                <a href="{{ route('student.login') }}" style="display: inline-block; background-color: #ff7029; color: #ffffff; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Login Here</a>
            </div>
        </div>

        <div style="text-align: center; margin-top: 20px; font-size: 14px; color: #888888;">
            <p style="margin: 0;">
                {{ date('Y') }} © All Rights Reserved. 
                By <a href="{{ url('/') }}" target="_blank" style="color:#ff7029; text-decoration: none;">Gaam Raam Trust</a> 
                And Powered By 
                <a href="https://www.pearlorganisation.com/" target="_blank" style="color:#ff7029; text-decoration: none;">Pearl Organisation</a>
            </p>
        </div>
    </div>
</body>
</html>
