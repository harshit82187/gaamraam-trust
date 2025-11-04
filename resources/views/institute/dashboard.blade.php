@extends('institute.layout.app')
@push('css')
<link rel="stylesheet" href="{{ asset('admin/assets/css/card.css') }}" />
<style>
    .logo-header[data-background-color] .btn-toggle, .logo-header[data-background-color] .more {
    color: #85858b !important;
}
    .report-container {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-top: 20px;
    }

    .report-label {
        font-size: 1.2rem;
        font-weight: 600;
        color: #343a40;
    }

    .form-control {
        border-radius: 4px;
    }

    .btn-submit {
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 4px;
        padding: 8px 16px;
        cursor: pointer;
    }

    .btn-submit:hover {
        background-color: #0056b3;
    }

    .styled-table {
        margin-top: 20px;
        border-collapse: collapse;
        width: 100%;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .styled-table th,
    .styled-table td {
        padding: 12px 15px;
        border: 1px solid #dee2e6;
    }

    .styled-table thead th {
        background-color: #007bff;
        color: #ffffff;
        text-align: left;
    }

    .styled-table tbody tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    .line-chart-container {
    padding: 20px;
    border: 1px solid #d6d6d6;
    border-radius: 10px;
    box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
    height: 100%;
}
.pie-chart-container {
    padding: 20px;
    border: 1px solid #d6d6d6;
    border-radius: 10px;
    box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
}
    .styled-table tbody tr:hover {
        background-color: #e9ecef;
    }

    .spinner {
        width: 40px;
        height: 40px;
        border: 4px solid #f3f3f3;
        /* Light gray */
        border-top: 4px solid #3498db;
        /* Blue */
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: auto;
        /* Center the spinner */
    }
    .dashboard_card {
    height: 100%;
}
.dashboard_card .card-statistic-3 {
    height: 100%;
}
.dashboard_card a {
    height: 100%;
    display: inline-block;
}
.dashboard_card .card-statistic-3 .card-title {
    font-size: 18px;
    font-weight: 600;
    color: #fff;
}
.dashboard_card .card-statistic-3 span {
    font-size: 28px;
    font-weight: 600;
}
    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>
@endpush
@section('content')
 <div class="row">
    <div class="col-md-7">
        <div class="row">
            <div class="col-12 col-sm-6  mb-3">
                <div class="card l-bg-purple-dark hover dashboard_card">
                    <a style="font-weight:bold;color:white;text-decoration:none;" href="{{ route('institute.enrool-student') }}">
                        <div class="card-statistic-3">
                            <div class="card-icon card-icon-large"><i class="fa fa-globe"></i></div>
                            <div class="card-content">
                                <h4 class="card-title">Enrool Student by you</h4>
                                <div class="d-flex justify-content-between">
                                    <span><b>{{ $enrolstudents ?? '0' }} </b><b></b></span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-12 col-sm-6  mb-3">
                <div class="card l-bg-green-dark hover dashboard_card">

                        <div class="card-statistic-3">
                            <div class="card-icon card-icon-large"><i class="fa fa-award"></i></div>
                            <div class="card-content">
                                <h4 class="card-title">My disctrict Student</h4>
                                <div class="d-flex justify-content-between">
                                    <span><b>{{ $disctrictStudent ?? '0' }} </b><b></b></span>
                                </div>
                            </div>
                        </div>
                    
                </div>
            </div>

            

        
            <div class="col-12 col-sm-6  mb-3">
                <div class="card l-bg-cyan-dark hover dashboard_card">
                   
                        <div class="card-statistic-3">
                            <div class="card-icon card-icon-large"><i class="fa fa-briefcase"></i></div>
                            <div class="card-content">
                                <h4 class="card-title">All Student from Haryana</h4>
                                <div class="d-flex justify-content-between">
                                    <span><b>{{ $allStudent ?? '0' }} </b><b></b></span>
                                </div>
                            </div>
                        </div>
                  
                </div>
            </div>
            {{--
            <div class="col-12 col-sm-6  mb-3">
                <div class="card l-bg-orange-dark hover dashboard_card">
                    <a style="font-weight:bold;color:white;text-decoration:none;"
                        href="{{ url('admin/task-list') }}">
                        <div class="card-statistic-3">
                            <div class="card-icon card-icon-large"><i class="fa fa-money-bill-alt"></i></div>
                            <div class="card-content">
                                <h4 class="card-title">Assign Task</h4>
                                <div class="d-flex justify-content-between">
                                    <span><b>{{ $task ?? '0' }} </b><b></b></span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-12 col-sm-6  mb-3">
                <div class="card l-bg-purple-dark hover dashboard_card">
                    <a style="font-weight:bold;color:white;text-decoration:none;" href="{{ url('admin/users/list') }}">
                        <div class="card-statistic-3">
                            <div class="card-icon card-icon-large"><i class="fa fa-globe"></i></div>
                            <div class="card-content">
                                <h4 class="card-title">Total Donation</h4>
                                <div class="d-flex justify-content-between">
                                    <span><b>₹ {{ $donation ?? '0' }} </b><b></b></span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            --}}
        </div>

    </div>
    <div class="col-md-5">
        {{--
        <div class="row justify-content-center">
            <div class="report-container mt-0 mb-2">
                <h2 class="report-label">Report Table</h2>
                <form id="filter-form" action="{{ route('admin.filter-data') }}" method="post">
                    @csrf
                    <div class="d-flex align-items-center mt-3">
                        <select id="dateRangeSelect" name="filter_values" class="form-control mr-2">
                            <option value="today">Today</option>
                            <option value="yesterday">Yesterday</option>
                            <option value="last7days">Last 7 Days</option>
                            <option value="last30days">Last 30 Days</option>
                            <option value="thisMonth">This Month</option>
                            <option value="lastMonth">Last Month</option>
                            <option value="custom">Custom Range</option>
                        </select>
                        <input type="date" class="form-control mr-2" id="startDate" name="startDate"
                            placeholder="Start Date" style="display: none;">
                        <input type="date" class="form-control ml-2" id="endDate" name="endDate"
                            placeholder="End Date" style="display: none;">
                        <button class="btn btn-submit ml-3" type="submit">Submit</button>
                    </div>
                </form>
                <!-- Loader Element -->
                <div class="spinner"></div>
                <table class="styled-table mt-4">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Count</th>
                        </tr>
                    </thead>
                    <tbody id="report-table-body">
                    </tbody>
                </table>
            </div>
        </div>
        --}}

    </div>
</div>






@endsection
@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

   {{-- Report Table Script Start --}}
   {{-- <script>
    $(document).ready(function() {
        $('.spinner').show();
        const today = new Date().toISOString().split('T')[0];
        $('#startDate').val(today);
        $('#endDate').val(today);

        function fetchTableData(data) {
            $('.spinner').show();
            $.ajax({
                url: $('#filter-form').attr('action'),
                method: 'POST',
                data: data,
                dataType: "JSON",
                processData: false,
                contentType: false,
                success: function(response) {
                    $('.spinner').hide();
                    let tableBody = '';
                    tableBody += '<tr><td>Enrool Student</td><td>' + response.data.student_count +
                        '</td></tr>';
                    tableBody += '<tr><td>Docuement Verified</td><td>' + response.data.document_count +
                        '</td></tr>';
                    tableBody += '<tr><td>College Listed</td><td>' + response.data.college_count +
                        '</td></tr>';
                    tableBody += '<tr><td>Assigned Task</td><td>' + response.data.task_count +
                        '</td></tr>';
                    tableBody += '<tr><td>Donation Received</td><td>₹ ' + response.data.donation_sum + '</td></tr>';


                    $('#report-table-body').html(tableBody);
                },
                error: function(xhr, status, error) {
                    $('.spinner').hide();
                    console.error('Error:', error);
                }
            });
        }

        let initialData = new FormData($('#filter-form')[0]);
        fetchTableData(initialData);

        $('#dateRangeSelect').change(function() {
            if ($(this).val() === 'custom') {
                $('#startDate').show();
                $('#endDate').show();
            } else {
                $('#startDate').hide().val('');
                $('#endDate').hide().val('');
            }
        });

        $('#filter-form').on('submit', function(event) {
            event.preventDefault();
            let form = $('#filter-form')[0];
            let data = new FormData(form);
            fetchTableData(data);
        });
    });
</script> --}}
{{-- Report Table Script End --}}

    {{-- Report Chart Script Start --}}
    {{-- <script>
        const memberCount = @json($member);
        const nriMemberCount = @json($nriMember);
        const studentCount = @json($student);
        const pieData = {
            labels: ["Indian Member", "NRI Member", "Student"],
            datasets: [{
                label: "On Board",
                data: [memberCount, nriMemberCount, studentCount], 
                backgroundColor: ["#FF6384", "#36A2EB", "#FFCE56"],
                borderWidth: 1
            }]
        };

        const pieConfig = {
            type: 'pie',
            data: pieData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    tooltip: {
                        enabled: true
                    }
                }
            }
        };

        new Chart(document.getElementById('myPieChart').getContext('2d'), pieConfig);
    </script> --}}
    {{-- Report Chart Script End --}}



      {{-- Report Graph Script Start --}}
      {{-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            const monthlyStudent = @json($monthlyData['student']);
            const monthlyMember = @json($monthlyData['member']);
            const monthlyNriMember = @json($monthlyData['nriMember']);
    
            const lineData = {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [
                    {
                        label: "Student",
                        data: monthlyStudent,
                        borderColor: "#FF6384",
                        backgroundColor: "rgba(255, 99, 132, 0.2)",
                        borderWidth: 2,
                        tension: 0.4,
                    },
                    {
                        label: "Indian Member",
                        data: monthlyMember,
                        borderColor: "#36A2EB",
                        backgroundColor: "rgba(54, 162, 235, 0.2)",
                        borderWidth: 2,
                        tension: 0.4,
                    },
                    {
                        label: "NRI Member",
                        data: monthlyNriMember,
                        borderColor: "#FFCE56",
                        backgroundColor: "rgba(255, 206, 86, 0.2)",
                        borderWidth: 2,
                        tension: 0.4,
                    }
                ]
            };
    
            const lineConfig = {
                type: 'line',
                data: lineData,
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'top' },
                        tooltip: { enabled: true }
                    },
                    scales: {
                        x: { beginAtZero: true },
                        y: { beginAtZero: true }
                    }
                }
            };
    
            new Chart(document.getElementById('myLineChart').getContext('2d'), lineConfig);
        });
    </script> --}}

    {{-- Report Graph Script End --}}
@endpush