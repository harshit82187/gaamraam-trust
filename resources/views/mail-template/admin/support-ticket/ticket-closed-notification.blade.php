<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Support Ticket Closed Notification</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;">
  <div style="max-width: 600px; margin: 20px auto; background-color: #ffffff; padding: 20px; border: 1px solid #dddddd; border-radius: 10px;">
    
    <!-- Email Header -->
    <div style="text-align: center; padding: 20px; background:#ff7029; border-radius: 10px 10px 0 0; box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.5); color: white; margin-bottom: 20px;">
      <img src="{{ asset('front/images/Gaam_Raam_logo.png') }}" alt="Gaam Raam Logo" style="max-width: 150px;">
    </div>

    <!-- Email Body -->
    <div style="padding: 20px; background: #FFFFFF; box-shadow: 0px 4px 6px rgba(0,0,0,0.1); color: #333;">
      @if($isAdmin)
        <p style="font-size: 16px; line-height: 1.5;">
            Support ticket <strong>#{{ $ticket->ticket_id }}</strong> has been marked as <strong>Closed</strong>.
        </p>       
      @else
        <p style="font-size: 16px; line-height: 1.5;">
          Hello <strong>{{ $recipientName ?? 'N/A' }}</strong>,
        </p>
        <p style="font-size: 16px; line-height: 1.5;">
            Your ticket <strong>#{{ $ticket->ticket_id }}</strong> has been successfully resolved and marked as <strong>Closed</strong>.
        </p>
        <p>Thank you for your patience!</p>       
      @endif

      <p style="font-size: 16px; line-height: 1.5; margin-top: 20px;">Best regards,<br> Gaam Raam Trust</p>
    </div>

    <!-- Email Footer -->
    <div style="text-align: center; padding: 15px; background:#ff7029; border-radius: 0 0 10px 10px; box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.5); color: #fff; margin-top: 20px; font-size: 12px;">
      <p style="margin: 0; font-size: 16px; line-height: 22px;">
        {{ date('Y') }} © All Rights Reserved <i class="fa fa-heart heart text-danger"></i>By 
        <a href="{{ url('/') }}" target="_blank" style="color:#409852; text-decoration: none;">Gaam Raam Trust</a> 
        And Powered By 
        <a href="https://www.pearlorganisation.com/" target="_blank" style="color:#409852; text-decoration: none;">Pearl Organisation</a>
      </p>
    </div>
  </div>
</body>
</html>
