<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>New Support Ticket</title>
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
          A new ticket is received (<strong>{{ $ticket['subject'] }}</strong>) with Ticket ID: <strong>{{ $ticket['ticket_id'] }}</strong> on <strong>{{ \Carbon\Carbon::today()->format('d-M-Y') }}</strong>.
        </p>
        <p style="font-size: 16px; line-height: 1.5;">
          Click the button below to view ticket details:
        </p>
        <a href="{{ route('admin.login') }}" style="display: inline-block; background-color: #ff7029; color: #ffffff; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
          👉 View On Dashboard
        </a>
      @else
        <p style="font-size: 16px; line-height: 1.5;">
          Hello <strong>{{ $ticket->student['name'] ?? 'N/A' }}</strong>,
        </p>
        <p style="font-size: 16px; line-height: 1.5;">
          We wanted to inform you that your support ticket titled <strong>{{ $ticket['subject'] }}</strong> (Ticket ID: <strong>{{ $ticket['ticket_id'] }}</strong>) has been received and is currently under review by our team.
        </p>
        <p style="font-size: 16px; line-height: 1.5; font-weight: bold; color: #5bc0de;">Ticket Details:</p>

        <table style="width: 100%; border-collapse: collapse; font-size: 16px; margin-bottom: 20px;">         
          <tr>
            <td style="border: 1px solid #dddddd; padding: 8px;">Ticket ID</td>
            <td style="border: 1px solid #dddddd; padding: 8px;">{{ $ticket['ticket_id'] }}</td>
          </tr>
          <tr>
            <td style="border: 1px solid #dddddd; padding: 8px;">Subject</td>
            <td style="border: 1px solid #dddddd; padding: 8px;">{{ $ticket['subject'] }}</td>
          </tr>
          <tr>
            <td style="border: 1px solid #dddddd; padding: 8px;">Description</td>
            <td style="border: 1px solid #dddddd; padding: 8px;">{{ $ticket['description'] }}</td>
          </tr>
          <tr>
            <td style="border: 1px solid #dddddd; padding: 8px;">Status</td>
            <td style="border: 1px solid #dddddd; padding: 8px;">Open</td>
          </tr>
        </table>

        <p style="font-size: 16px; line-height: 1.5;">
          If you have any additional information or would like to update your ticket, please contact our support team at any time.
        </p>
        <p style="font-size: 16px; line-height: 1.5;">
          Thank you for reaching out to us. We will keep you updated on the progress of your ticket.
        </p>
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
