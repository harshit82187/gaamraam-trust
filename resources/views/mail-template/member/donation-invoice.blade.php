<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Donation Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQjW1CwCf0vMLX5pD9eGeU2Ud1Lnt2R9u5kIepUCB4WdPmUbTbyP6YI75" crossorigin="anonymous">
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;">
    <div class="email-container" style="max-width: 600px; margin: 20px auto; background-color: #ffffff; padding: 20px; border: 1px solid #dddddd; border-radius: 5px;">
        <div class="email-header" style="text-align: center; background-color: #ff7029; color: #ffffff; padding: 10px 0; border-radius: 5px 5px 0 0; margin-bottom: 20px;">
            <img src="{{ asset('front/images/Gaam_Raam_logo.png') }}" alt="Company Logo" style="max-width: 150px;">
            <h2 style="margin: 0; font-size: 24px;">Gaam Raam Trust Donation Invoice</h2>
        </div>

        <div class="email-body" style="padding: 20px;">
            @if($isAdmin)
                <p style="font-size: 16px; line-height: 1.6;">Hello <strong>Admin</strong>,</p>
                <p style="font-size: 16px; line-height: 1.6;">A new donation has been received. Please find the details attached below.</p>
            @else
                @if($count == 0)
                    <p style="font-size: 16px; line-height: 1.6;">Hello <strong>{{ $payment_table->member->name ?? 'Donor' }}</strong>,</p>
                @else
                    <p style="font-size: 16px; line-height: 1.6;">Hello <strong>{{ $payment_table->user_name ?? 'Donor' }}</strong>,</p>
                @endif
                <p style="font-size: 16px; line-height: 1.6;">We sincerely appreciate your donation to <strong>Gaam Raam Trust</strong>.</p>
                <p style="font-size: 16px; line-height: 1.6;">Please find your invoice attached below.</p>
                <p style="font-size: 16px; line-height: 1.6;">Thank you for your generous contribution!</p>
            @endif
        </div>

        <div class="email-footer" style="text-align: center; margin-top: 20px; font-size: 14px; color: #888888;">
            <p>
                {{ date('Y') }} © All Rights Reserved. <i class="fa fa-heart heart text-danger"></i>
                By <a href="{{ url('/') }}" target="_blank" style="color:#ff7029 !important;">Gaam Raam Trust</a>
                And Powered By <a href="https://www.pearlorganisation.com/" target="_blank" style="color:#ff7029 !important;">Pearl Organisation</a>
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-VoPF5bLNmH3EaA8yexOaMIXV5GQpLw5jEEJqDlu0UDFIPhHIyggD5fXcjEjWKKej" crossorigin="anonymous"></script>
</body>
</html>
