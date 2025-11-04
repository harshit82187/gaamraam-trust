<!DOCTYPE html>
<html>
<head>
    <title>Follow-Up Report for {{ $admin->name }}</title>
    <style>
        @page {
            margin: 100px 25px;
        }

        body {
            font-family: sans-serif;
            font-size: 12px;
        }

       

        footer {
            position: fixed;
            bottom: 0px;
            left: 0px;
            right: 0px;
            height: 50px;
            text-align: center;
            line-height: 35px;
            font-size: 10px;
            color: #777;
        }
        

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        h2 {
            text-align: center;
        }
        h3 {
            margin-bottom: 10px;
            text-align: center;
        }
        .header_content {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
    </style>
</head>
<body>

    <header>
        <h2>Follow-Up Report</h2>
       <div class="header_content">
         <h3> {{ $admin->name }} - {{ date("F", mktime(0, 0, 0, $month, 10)) }}</h3>
       </div>
        <!-- <p>Admin: {{ $admin->name }} | Month: {{ date("F", mktime(0, 0, 0, $month, 10)) }}</p> -->
    </header>

    <footer>
        <div class="copyright">
            2025 © All Rights Reserved. <i class="fa fa-heart heart text-danger"></i> 
            <a href="https://www.gaamraam.ngo" target="_blank">Gaam Raam Ngo</a> And Powered By <a href="https://www.pearlorganisation.com/" target="_blank">Pearl Organisation</a>
        </div>
    </footer>

    <main>
        <table>
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Following Member</th>
                    <th>Status</th>
                    <th>Follow Date</th>
                    <th>Next Follow Date & Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach($followups as $index => $followup)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        {{ $followup->sarpanch->name ?? 'N/A' }}<br>
                        {{ $followup->sarpanch->mobile_no ?? 'N/A' }}
                    </td>
                    <td>{{ $followup->status }}</td>
                    <td>{{ $followup->created_at->format('d-M-Y h:i A') }}</td>
                    <td>
                        {{ \Carbon\Carbon::parse($followup->next_date)->format('d-M-Y') }}
                        {{ \Carbon\Carbon::createFromFormat('H:i', $followup->time)->format('h:i A') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </main>

</body>
</html>
