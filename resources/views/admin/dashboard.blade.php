@extends('admin.layout.app')
@push('css')
<link rel="stylesheet" href="{{ asset('admin/assets/css/card.css') }}" />
<link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}" />
@endpush
@section('content')
@if(in_array($admin->admin_role_id, [1,2,3]))
    <div class="row">
        <div class="col-md-7">
            <div class="row">
                <div class="col-12 col-sm-6  mb-3">
                    <div class="card l-bg-purple-dark hover dashboard_card">
                        <a style="font-weight:bold;color:white;text-decoration:none;" href="{{ url('admin/enrool-student') }}">
                            <div class="card-statistic-3">
                                <div class="card-icon card-icon-large"><i class="fa fa-globe"></i></div>
                                <div class="card-content">
                                    <h4 class="card-title">Enrool Student</h4>
                                    <div class="d-flex justify-content-between">
                                        <span><b>{{ $student ?? '0' }} </b><b></b></span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-12 col-sm-6  mb-3">
                    <div class="card l-bg-green-dark hover dashboard_card">
                        <a style="font-weight:bold;color:white;text-decoration:none;"
                            href="{{ url('admin/member/indian-list') }}">
                            <div class="card-statistic-3">
                                <div class="card-icon card-icon-large"><i class="fa fa-award"></i></div>
                                <div class="card-content">
                                    <h4 class="card-title">Member</h4>
                                    <div class="d-flex justify-content-between">
                                        <span><b>{{ $member ?? '0' }} </b><b></b></span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-12 col-sm-6  mb-3">
                    <div class="card l-bg-cyan-dark hover dashboard_card">
                        <a style="font-weight:bold;color:white;text-decoration:none;"
                            href="{{ url('admin/college-list') }}">
                            <div class="card-statistic-3">
                                <div class="card-icon card-icon-large"><i class="fa fa-briefcase"></i></div>
                                <div class="card-content">
                                    <h4 class="card-title">College</h4>
                                    <div class="d-flex justify-content-between">
                                        <span><b>{{ $college ?? '0' }} </b><b></b></span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

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
                        <a style="font-weight:bold;color:white;text-decoration:none;" href="{{ url('admin/donation-report') }}">
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

                
                <div class="col-12 col-sm-6  mb-3">
                    <div class="card l-bg-green-dark hover dashboard_card">
                        <a style="font-weight:bold;color:white;text-decoration:none;"
                            href="{{ url('admin/tickets/student') }}">
                            <div class="card-statistic-3">
                                <div class="card-icon card-icon-large"><i class="fa fa-award"></i></div>
                                <div class="card-content">
                                    <h4 class="card-title">Ticket</h4>
                                    <div class="d-flex justify-content-between">
                                        <span><b>{{ $ticket ?? '0' }} </b><b></b></span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-5">
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

        </div>
    </div>

    <div class="row mt-4">
        <div class="col-sm-7">
            <div class="line-chart-container">
                <div>
                    <h2>Student, Member & NRI Member</h2>
                    <canvas id="myLineChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-sm-5">
            <div class="pie-chart-container">
                <h2>Report Chart</h2>
                <canvas id="myPieChart"></canvas>
            </div>
        </div>
    </div>

    @else 
    <div class="row">
        <div class="col-md-7">
            <div class="row">
                <div class="col-12 col-sm-6  mb-3">
                    <div class="card l-bg-purple-dark hover dashboard_card">
                        <a style="font-weight:bold;color:white;text-decoration:none;" href="{{ url('admin/enrool-student') }}">
                            <div class="card-statistic-3">
                                <div class="card-icon card-icon-large"><i class="fa fa-globe"></i></div>
                                <div class="card-content">
                                    <h4 class="card-title">Enrool Student</h4>
                                    <div class="d-flex justify-content-between">
                                        <span><b>{{ $student ?? '0' }} </b><b></b></span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-12 col-sm-6  mb-3">
                    <div class="card l-bg-green-dark hover dashboard_card">
                        <a style="font-weight:bold;color:white;text-decoration:none;"
                            href="{{ url('admin/member/indian-list') }}">
                            <div class="card-statistic-3">
                                <div class="card-icon card-icon-large"><i class="fa fa-award"></i></div>
                                <div class="card-content">
                                    <h4 class="card-title">Enrool Member</h4>
                                    <div class="d-flex justify-content-between">
                                        <span><b>{{ $member ?? '0' }} </b><b></b></span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-12 col-sm-6  mb-3">
                    <div class="card l-bg-cyan-dark hover dashboard_card">
                        <a style="font-weight:bold;color:white;text-decoration:none;"
                            href="{{ url('admin/student-bulk-import') }}">
                            <div class="card-statistic-3">
                                <div class="card-icon card-icon-large"><i class="fa fa-briefcase"></i></div>
                                <div class="card-content">
                                    <h4 class="card-title">Bulk Import</h4>
                                    <div class="d-flex justify-content-between">
                                        <span><b>{{ $excel ?? '0' }} </b><b></b></span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

             
            </div>

        </div>
        <div class="col-md-5">
            <div class="row justify-content-center">
                <div class="report-container mt-0 mb-2">
                    <h2 class="report-label">Report Table</h2>
                    <form id="filter-form" action="{{ route('admin.filter-data') }}" method="post">
                        @csrf
                        <div class="d-flex align-items-center mt-3 d-none">
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
                                <th>Top 5 Performer</th>
                                <th>Points</th>
                            </tr>
                        </thead>
                        <tbody id="report-table-body">
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <div class="container mt-4">
        <div class="row">
            <div class="col-12 line-chart-container">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="mb-4">Points Comparison</h4>
                    <form method="GET" action="{{ route('admin.dashboard') }}" class="w-50">
                        <div class="form-group row flex-column">
                            <label for="city" class="col-form-label col-sm-2">Select City:</label>
                            <div class="col-12">
                                <select class="form-control select2" name="city" id="city" onchange="this.form.submit()">
                                    @php
                                        $cities = \App\Models\City::where('state_id',13)->get();
                                    @endphp
                                    <option value="" selected disabled>--Select City--</option>
                                    @foreach($cities as $city)                       
                                        <option value="{{ $city->id }}" {{ $selectedCity == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <canvas id="pointsChart" height="100"></canvas>
            </div>
        </div>
    </div>
    
@endif




@endsection
@push('js')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            allowClear: true,
            width:'300px'
        });
    });
    const BASE_URL = "{{ asset('') }}";
</script>

@if(in_array($admin->admin_role_id, [1,2,3]))
{{-- Report Chart Script Start --}}

<script>
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
</script>

{{-- Report Chart Script End --}}

{{-- Report Graph Script Start --}}
<script>
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
</script>
{{-- Report Graph Script End --}}
@endif

{{-- Report Table Script Start --}}

<script>
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

                    // ✅ Check admin role id
                    if ([1, 2, 3].includes(response.admin_role_id)) {
                        // ---- Admin role (show full menu) ----
                        tableBody += '<tr><td>Enrool Student</td><td>' + response.data.student_count + '</td></tr>';
                        tableBody += '<tr><td>Docuement Verified</td><td>' + response.data.document_count + '</td></tr>';
                        tableBody += '<tr><td>College Listed</td><td>' + response.data.college_count + '</td></tr>';
                        tableBody += '<tr><td>Assigned Task</td><td>' + response.data.task_count + '</td></tr>';
                        tableBody += '<tr><td>Donation Received</td><td>₹ ' + response.data.donation_sum + '</td></tr>';
                    }else {
                        // Table header
                        

                        // Show image, name, and points
                        response.data.top_members.forEach(member => {
                            const imageUrl = member.image
                                ? `${BASE_URL}${member.image}`
                                : `${BASE_URL}admin/assets/img/user-1.png`;

                            tableBody += `
                                <tr>
                                    <td style="display: flex; align-items: center; gap: 10px;">
                                        <img src="${imageUrl}" class="rounded-circle" width="35" height="35" alt="Employee Image" style="cursor:pointer;" title="${member.name}">
                                        ${member.name}
                                    </td>
                                    <td>${member.points ?? 0}</td>
                                </tr>
                            `;
                        });
                    }

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
</script>


{{-- Report Table Script End --}}

<script>
    const ctx = document.getElementById('pointsChart').getContext('2d');
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(75, 192, 192, 0.8)');
    gradient.addColorStop(1, 'rgba(153, 102, 255, 0.6)');
    const pointsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($pointsChartLabels) !!},
            datasets: [{
                label: 'Total Points Comparison',
                data: {!! json_encode($pointsChartValues) !!},
                backgroundColor: gradient,
                borderRadius: 8,
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            animation: {
                duration: 1000,
                easing: 'easeOutQuart'
            },
            scales: {
                x: {
                    ticks: {
                        autoSkip: false,
                        maxRotation: 45,
                        minRotation: 0
                    },
                    grid: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        borderDash: [5, 5]
                    }
                }
            },
            plugins: {
                legend: {
                    labels: {
                        font: {
                            size: 14,
                            weight: 'bold'
                        }
                    }
                },
                tooltip: {
                    backgroundColor: '#f0f0f0',
                    titleColor: '#000',
                    bodyColor: '#000',
                    borderColor: '#ccc',
                    borderWidth: 1,
                    callbacks: {
                        label: function(context) {
                            return 'Points: ' + context.parsed.y;
                        }
                    }
                }
            }
        }
    });
</script>
@endpush