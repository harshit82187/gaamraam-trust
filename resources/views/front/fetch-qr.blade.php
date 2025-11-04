<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Student Details</title>
        <style>
            table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
            }
            th,
            td {
            padding: 8px;
            border: 1px solid gray;
            text-align: left;
            }
            th {
            background-color: rgb(180, 180, 180);
            }
            h1 {
            text-align: center;
            font-size: 35px;
            color: rgb(180, 180, 180);
            }
            table tr th {
            font-size: 11px;
            text-align: center;
            color: black;
            }
            table tr td {
            font-size: 12px;
            text-align: center;
            }
            .invoice-mobile {
            background-color: rgb(24, 23, 23);
            color: #fff;
            }
            /*  */
            .card {
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 20px;
            box-shadow: 0 -2px 5px rgba(245, 243, 243, 0.5), 0 2px 5px rgba(245, 243, 243, 0.5);
            }
            .card-body {
            padding: 10px;
            }
            /* .invoive-mobile img{
            margin: 20px 0;
            text-align: right;
            margin-left: 50%;
            } */
            .main-img{
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
            }
        </style>
    </head>
    <body class="invoice-mobile">
        <section class="invoive-mobile">
            <div class="container">
                <h1>Gaamraam Student Details</h1>
                <div class="main-img">
                    <img src="{{ asset($student->image) }}" height="auto" width="180px"  alt="{{ asset($student->image) }}" >
                </div>

                <div class="card">
                    <div class="card-body">
                        <table>
                            <tr>
                                <th>Name </th>
                                <td> {{ $student->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td> {{ $student->email ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Mobile</th>
                                <td>{{ $student->mobile ?? 'N/A' }}</td>
                            </tr>

                            <tr>
                                <th>Student ID</th>
                                <td>{{ $student->student_id ?? 'N/A' }}</td>
                            </tr>

                            <tr>
                                <th>Blood group</th>
                                <td>{{ $student->blood_group ?? 'N/A' }}</td>
                            </tr>
                            
                        </table>
                    </div>
                </div>
            </div>
            
        </section>
    </body>
</html>