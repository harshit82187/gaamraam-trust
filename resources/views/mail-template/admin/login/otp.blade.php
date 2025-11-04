<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login OTP</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 20px auto; background-color: #ffffff; padding: 20px; border: 1px solid #dddddd; border-radius: 5px;">
        <div style="text-align: center; background-color: #ff7029; color: #ffffff; padding: 10px 0; border-radius: 5px 5px 0 0; margin-bottom: 20px;">
            <img src="{{ asset($websiteLogo) }}" alt="Gaam Raam Logo" style="max-width: 150px;">
            <h2 style="margin: 0; font-size: 24px;">Admin Login Verification OTP</h2>
        </div>
       <div style="padding: 24px; font-family: Arial, sans-serif; background-color: #f9f9f9;">
            <p style="font-size: 16px; color: #333;">Dear <strong>{{ $email }}</strong>,</p>
            <p style="font-size: 16px; color: #333; margin-top: 20px;">
                We received a request to log in to your admin account. Please use the following One-Time Password (OTP) to complete your login verification:
            </p>
            <div style="margin: 30px 0; text-align: center;">
                <span style="font-size: 28px; font-weight: bold; color: #2c3e50;">{{ $otp ?? '' }}</span>
            </div>
            <p style="font-size: 16px; color: #333;">
                This OTP is valid for a limited time. If you did not request this, please ignore this email.
            </p>
            <p style="font-size: 16px; color: #333; margin-top: 30px;">Best regards,<br><strong>Your Admin Team</strong></p>
        </div>

        <div style="text-align: center; margin-top: 20px; font-size: 14px; color: #888888;">
            <p style="margin: 0;">{{ date('Y') }} © All Rights Reserved. <i class="fa fa-heart heart text-danger"></i> By
                <a href="{{ url('/') }}" target="_blank" style="color:#ff7029 !important; text-decoration: none;">Gaam Raam Trust</a> And Powered By 
                <a href="https://www.pearlorganisation.com/" target="_blank" style="color:#ff7029 !important; text-decoration: none;">Pearl Organisation</a>
            </p>
        </div>
    </div>
</body>
</html>
