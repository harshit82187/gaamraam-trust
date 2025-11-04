<!DOCTYPE html>
<html>
<head>
    <title>Test Result</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
        }
        .header p {
            margin: 5px 0;
        }
        .footer {
            position: fixed;
            bottom: 20px;
            width: 100%;
            text-align: center;
            font-size: 12px;
            color: #888;
        }
        .result-table {
            width: 100%;
            border-collapse: collapse;
        }
        .result-table th, .result-table td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .result-table th {
            background-color: #f2f2f2;
        }
        .correct {
            background-color: #d4edda;
        }
        .incorrect {
            background-color: #f8d7da;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Header Section -->
    <div class="header">
        <h2>Test Result</h2>
        <p><strong>Student Name:</strong> {{ $student->name }}</p>
        <p><strong>Test Series:</strong> {{ $testSeries->name }}</p>
        <p><strong>Date:</strong> {{ now()->format('F d, Y') }}</p>
    </div>

    <!-- Result Table Section -->
    <table class="result-table">
        <thead>
            <tr>
                <th>Question</th>
                <th>Correct Answer</th>
                <th>Your Choice</th>
                <th>Marks</th>
            </tr>
        </thead>
        <tbody>
            @foreach($resultData as $data)
            <tr class="{{ $data['is_correct'] ? 'correct' : 'incorrect' }}">
                <td>{{ $data['question_name'] }}</td>
                <td>{{ $data['correct_answer'] }}</td>
                <td>{{ $data['student_choice'] }}</td>
                <td>{{ $data['marks'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Footer Section -->
<div class="footer">
    <p>GaamRaam NGO - All rights reserved</p>
</div>

</body>
</html>
