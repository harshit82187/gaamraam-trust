<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Earning Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .report-container {
            width: 100%;
            margin: 0 auto;
        }
        /* .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        } */
        .title {
            font-size: 22px;
            font-weight: bold;
        }
        .date {
            font-weight: bold;
            font-size: 18px;
        }
        .logo {
            font-size: 32px;
            font-weight: bold;
            color:#283272;
            text-transform: uppercase;
        }
        .duration {
            font-weight: bold;
            margin-top: 20px;
            font-size: 18px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #35914e;
            color: white;
        }
        .total-row {
            font-weight: bold;
        }
    </style>
</head>
@php
$logoPath = public_path($websiteLogo);
$logoData = base64_encode(file_get_contents($logoPath));
$logoSrc = 'data:image/png;base64,' . $logoData;
@endphp
<body>
    <div class="report-container" style="width: 90%">
        <table width="100%" style="width:100%;">
            <tr>
                <td style="text-align: left; vertical-align: middle; border: 0px !important; padding:0;">
                    <div class="title">Donation Report</div>
                    <div class="date">Date: {{ date('d/m/Y') ?? 'N/A' }}</div>
                </td>
                <td style="text-align: right; vertical-align: middle; border: 0px !important; padding:0;">
                    <img src="{{ $logoSrc }}" alt="Gaam Raam" width="100" height="100" />
                </td>
            </tr>
        </table>
        
        <div class="duration">Duration: {{ $month ?? 'N/A' }} {{ date('Y') }}</div>
        <table border="1" cellspacing="0" cellpadding="5" width="100%">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Donor Name</th>
                    <th>Total Donation </th>
                </tr>
            </thead>
            <tbody>
                @forelse($donations as $index => $donation)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $donation->user_name ?? 'N/A' }}</td>
                        <td>{{ $donation->total_donation }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" align="center">No donations found for this month.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2" align="right">Total:</th>
                    <th>{{ $total }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>