@extends('admin.layout.app')
@section('content')
@push('css')
<link rel="stylesheet" href="{{ asset('admin/assets/css/card.css') }}" />
<link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}" />
<style>
	.no-radius-form input,
.no-radius-form button,
.no-radius-form .btn {
    border-radius: 0px !important;
}
a {
    color: #1572e8;
    text-decoration: none !important;
}
.icon_with_text-item {
    cursor: pointer;
    transition: color 0.2s ease-in-out;
}

.icon_with_text-item:hover {
    color: #007bff; /* hover पर color change */
}

</style>
@endpush
<div class="card" style="padding: 0px !important;">
	<div class="card-header" style="display: flex; gap: 10px; align-items: center;">
		<img src="{{ asset('admin/assets/img/employee.png') }}" width="40px" width="40px">
		<h3 class="">View Employee Details</h3>
	</div>
</div>
<div class="card p-4 mt-2">
	<div class="row">
		<div class="col-md-6">
			<div class="employee_detail">
				<div class="employee_profile">
					@if($admin->image)
						<img src="{{ asset($admin->image) }}" class="sub-admin" alt="{{ asset($admin->image) }}">
						@else 
						<img src="https://cdn-icons-png.flaticon.com/128/2202/2202112.png" alt="https://cdn-icons-png.flaticon.com/128/2202/2202112.png">
					@endif
					<div class="employee_content">
						<h5>{{ $admin->name ?? 'N/A' }}</h5>
						<span>{{ $admin->role->name ?? 'N/A' }}</span>
						<div class="icon_with_text">
							<div class="icon_with_text-item" data-bs-toggle="tooltip" data-bs-placement="top" title="Mobile Number">
								<i class="fa-solid fa-phone"></i>
								<span>{{ $admin->mobile_no ?? 'N/A' }}</span>
							</div>

							<div class="icon_with_text-item" data-bs-toggle="tooltip" data-bs-placement="top" title="Email Address">
								<i class="fa-solid fa-envelope"></i>
								<span>{{ $admin->email ?? 'N/A' }}</span>
							</div>

							<div class="icon_with_text-item" data-bs-toggle="tooltip" data-bs-placement="top" title="Identification Number">
								<i class="fa-solid fa-id-card"></i>
								<span>{{ $admin->identify_number ?? 'N/A' }}</span>
							</div>

							<div class="icon_with_text-item" data-bs-toggle="tooltip" data-bs-placement="top" title="Total Points">
								<i class="fa-solid fa-star"></i>
								<span>{{ $admin->points ?? 'N/A' }}</span>
							</div>

							<div class="icon_with_text-item" data-bs-toggle="tooltip" data-bs-placement="top" title="Referral Code">
								<i class="fa-solid fa-user-plus"></i>
								<span>{{ $admin->referral_code ?? 'N/A' }}</span>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="employee_card">
				<div class="card">
					<i class="fa-solid fa-calendar-days"></i>
					<span><strong>JOIN:</strong>{{ \Carbon\Carbon::parse($admin->created_at)->format('d-M-Y h:i A') }}</span>
				</div>
				<div class="card flex-column">
					<div class="d-flex gap-3">
						<i class="fa-solid fa-address-card"></i>
						<span><strong></strong>Access Available</span>
					</div>
					<ul class="availibility_list">
						@isset($roles)
							@foreach($roles as $role)
								<li>{{ ucwords(str_replace('_', ' ', $role)) }}</li>
							@endforeach 
						@endisset
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>

@if($admin->admin_role_id  == 6)
<div class="card">
	<div class="card-body" id="">
		<div class="row">
			<div class="col-12">
				<label style="color:#000000;font-size:20px;font-weight: 800;">Filter Data</label>
				<form id="filter-form" method="post">
					@csrf
					<div class="mt-3 select-year-div">
						<select id="dateRangeSelect" name="filter_values" class="form-control mr-2">
							<option value="this_year">This Year</option>
							<option value="this_month">This Month</option>
							<option value="this_week">This Week</option>
							<option value="custom">Custom Range</option>
						</select>
						<input type="date" class="form-control mr-2" id="startDate" name="startDate" placeholder="Start Date" style="display: none;">
						<input type="date" class="form-control ml-2" id="endDate" name="endDate" placeholder="End Date" style="display: none;">
						<button class="btn btn-submit" id="filter-data-submit" type="submit">Submit</button>
					</div>
				</form>
			</div>
		</div>
		<hr style="border: none; height: 2px; background: linear-gradient(to right, #ff7e5f, #feb47b); margin: 20px 0; border-radius: 5px;">
		<div class="row">
			<div class="col-md-12 mb-3">
				<div class="line-chart-container">
					<div>
						<h2 style="color:#000000;font-size:20px;font-weight: 800;">Follow Up Graph</h2>
						<canvas id="myLineChart"></canvas>
					</div>
				</div>
			</div>
			<div class="col-md-12 mb-3">
				<div class="row">
					<div class="col-sm-6 col-md-4 mb-3">
						<div class="card l-bg-purple-dark hover dashboard_card">
							<a style="font-weight:bold;color:white;text-decoration:none;" href="">
								<div class="card-statistic-3">
									<div class="card-icon card-icon-large"><i class="fa fa-globe"></i></div>
									<div class="card-content">
										<h4 class="card-title">Total Sarpanch Member</h4>
										<div class="d-flex justify-content-between">
											<span id=""><b>{{ $sarpanchs ?? '0' }}</b></span>
										</div>
									</div>
								</div>
							</a>
						</div>
					</div>
					<div class="col-sm-6 col-md-4 mb-3">
						<div class="card l-bg-green-dark hover dashboard_card">
							<a style="font-weight:bold;color:white;text-decoration:none;" href="">
								<div class="card-statistic-3">
									<div class="card-icon card-icon-large"><i class="fa fa-award"></i></div>
									<div class="card-content">
										<h4 class="card-title">Total Follow Up</h4>
										<div class="d-flex justify-content-between">
											<span><b>{{ $followUps ?? '0' }} </b></span>
										</div>
									</div>
								</div>
							</a>
						</div>
					</div>
					<div class="col-sm-6 col-md-4 mb-3">
						<div class="card l-bg-orange-dark hover dashboard_card">
							<a style="font-weight:bold;color:white;text-decoration:none;" href="">
								<div class="card-statistic-3">
									<div class="card-icon card-icon-large"><i class="fa fa-money-bill-alt"></i></div>
									<div class="card-content">
										<h4 class="card-title">Working Hour</h4>
										<div class="d-flex justify-content-between">
											<span><b>{{ $working_hour ?? '0' }} </b></span>
										</div>
									</div>
								</div>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="card mt-3" id="">
	<div class="card-header">
		<div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
			<h1 style="color:#000000; font-size: 20px; font-weight: 800; margin: 0;">Total Folloup</h1>
		</div>
	</div>
	<div class="card-body">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Duration</th>
					<th>Call Back Later</th>
					<th>Not Interested</th>
					<th>Not Picked Up</th>
					<th>Other</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach($followupSummary as $index => $monthData)
					<tr>
						<td>{{ $monthData['month'] }}</td>
						<td>{{ $monthData['Call Back Later'] }}</td>
						<td>{{ $monthData['Not Interested'] }}</td>
						<td>{{ $monthData['Not Picked Up'] }}</td>
						<td>{{ $monthData['Other'] }}</td>
						<td>
							<a href="{{  route('admin.employee.follow-up-report-month-wise',['month' => $index, 'adminId' => $admin->id]) }}"><img src="{{ asset('admin/assets/img/pdf.png') }}" width="40px" width="40px"></a>
						</td> 
					</tr>
				@endforeach				
			</tbody>
		</table>
	</div>
</div>
@endif

@if($admin->admin_role_id  == 8)
	<div class="member_info">
		  @include('admin.employee.menu')
	</div>
	<div class="card">
	<div class="card-header d-block d-sm-flex justify-content-between align-items-center">
		<div class="d-flex gap-2 align-items-center">
			<h3 class="mb-0">Member's</h3>
			<span class="count-circle " style="position:unset;">{{ count($members) }}</span>
		</div>

		<div class="d-flex align-items-center  gap-3">
			<form action="{{ url()->current() }}" method="get" class="no-radius-form gap-2 d-block d-sm-flex ">
				<input type="text" class="form-control w-100" value="{{ request()->query('name', '') }}" name="name"  placeholder="Search Name">
				<button class="btn btn-primary mt-2 mt-sm-0">Search</button>
				<!-- <button type="submit" class="btn btn-dark mt-2 mt-sm-0"  name="export" value="1" >Export</button> -->
				<a class="btn btn-info mt-2 mt-sm-0" href="{{ route(Route::currentRouteName(), ['id' => encrypt($admin->id)]) }}">Reset</a>
			</form>
		</div>
	</div>
	<br>

	<div class="card-body">
			<div class="table-responsive table-card mt-3 mb-1">
				<table class="table align-middle table-nowrap table-striped">
					<thead class="table-light">
						<tr class="text-center table-striped table-responsive table-border">
							<th>Member Name	</th>
							<th>Contact info</th>
							<th class="text-nowrap">Total Donation</th>
							<th class="text-nowrap">Active Status</th>
							<th class="text-nowrap">Email Verify</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@if($members->count() > 0)
						@foreach($members as $indianMember)	
						@php $totalDonations = \App\Models\Payment::where('user_id',$indianMember->id)->sum('amount'); @endphp						
						<tr>
							<td class="d-flex align-items-center gap-10 w-max-content" style="gap:10px"> 									
								@if($indianMember->profile_image != null)
								<img src="{{ asset($indianMember->profile_image) }}" class="avatar rounded-circle " width="50" >
								@else
								<img src="{{ asset('front/images/no-image.jpg') }}" class="avatar rounded-circle " width="50" >
								@endif
								<a href="{{ route('admin.member.member-info',encrypt($indianMember->id)) }}" class="text-nowrap" style="color: black;">  {{ $indianMember->name ?? 'N/A' }} </a>
							</td>
							<td>
								<div class="mb-1">
									<strong>
									<a href="mailto:{{ $indianMember->email ?? 'N/A' }}" class="title-color hover-c1">{{ $indianMember->email ?? 'N/A' }}</a>
									</strong>
								</div>
								<a class="title-color hover-c1" href="tel:{{ $indianMember->mobile }}">{{ $indianMember->mobile ?? 'N/A' }}</a>
							</td>
							<td>
								<label class="btn text-info bg-soft-info font-weight-bold px-3 py-1 mb-0 fz-12" ></label>{{ $totalDonations ?? '0' }} 
							</td>
							<td>
								<label class="switch">
								<input type="checkbox" class="status-toggle" data-id="{{ $indianMember->id }}" {{ $indianMember->status ? 'checked' : '' }}>
								<span class="slider round"></span>
								</label> 
							</td>
							<td>
								<label class="switch">
								<input type="checkbox" class="email-verify-status-toggle" data-id="{{ $indianMember->id }}" {{ $indianMember->email_verified_at ? 'checked' : '' }}>
								<span class="slider round"></span>
								</label> 
							</td>
							<td>
								<a href="{{ route('admin.member.member-info',encrypt($indianMember->id)) }}" class="btn btn-dark btn-sm" >View</a>
							</td>
						</tr>
						@endforeach
						@else
						<tr>
							<td colspan="6" class="text-danger text-center">No Member Register Yet.</td>
						</tr>
						@endif
					</tbody>					
				</table>
				<div class="d-flex justify-content-center mt-4">
						{{ $members->links('pagination::bootstrap-4') }}
				</div>
				
			</div>
		</div>
	</div>
@endif

@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
{{-- Report Graph Script Start --}}
<script>
	document.addEventListener("DOMContentLoaded", function() {
		const ctx = document.getElementById('myLineChart').getContext('2d');
		let chartInstance = null;

		const monthLabels = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
		const weekLabels = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];

		function generateMonthDays() {
			let days = [];
			let currentMonthDays = new Date(new Date().getFullYear(), new Date().getMonth() + 1, 0).getDate();
			for (let i = 1; i <= currentMonthDays; i++) {
				days.push(i);
			}
			return days;
		}

		function generateWeekDays() {
			let days = weekLabels;
			return days;
		}

		function generateDateRange(startDate, endDate) {
			let dates = [];
			let currentDate = new Date(startDate);
			let stopDate = new Date(endDate);

			while (currentDate <= stopDate) {
				let formattedDate = currentDate.toISOString().split('T')[0]; // Format as YYYY-MM-DD
				dates.push(formattedDate);
				currentDate.setDate(currentDate.getDate() + 1);
			}
			return dates;
		}

		function createChart(data, labels) {
			if (chartInstance) chartInstance.destroy();

			chartInstance = new Chart(ctx, {
				type: 'line',
				data: {
					labels: labels,
					datasets: [{
						label: "Followup",
						data: data,
						borderColor: "#FF6384",
						backgroundColor: "rgba(255, 99, 132, 0.2)",
						borderWidth: 2,
						tension: 0.4,
					}]
				},
				options: {
					responsive: true,
					plugins: {
						legend: {
							position: 'top'
						},
						tooltip: {
							enabled: true
						}
					},
					scales: {
						x: {
							ticks: {
								autoSkip: false
							}
						},
						y: {
							beginAtZero: true
						}
					}
				}
			});
		}

		function fetchData(filterValues = 'this_year', startDate = '', endDate = '') {
			$.ajax({
				url: "{{ route('admin.employee.filter-follow-up-report') }}",
				method: "POST",
				data: {
					_token: "{{ csrf_token() }}",
					filter_values: filterValues,
					startDate: startDate,
					endDate: endDate,
					admin_id: "{{ $admin->id ?? 'N/A' }}"
				},
				success: function(response) {
					let labels = monthLabels;
					if (filterValues === "this_month") {
						labels = generateMonthDays();
					} else if (filterValues === "this_week") {
						labels = generateWeekDays();
					} else if (filterValues === "custom" && startDate && endDate) {
						labels = generateDateRange(startDate, endDate);
					}

					createChart(response.monthlyData, labels);
					let totalEarnings = response.monthlyData.reduce((sum, val) => sum + parseFloat(val), 0);
					let formattedEarnings = new Intl.NumberFormat('en-AE', {
						minimumFractionDigits: 2,
						maximumFractionDigits: 2
					}).format(totalEarnings);
					// Update the span inside the earnings card
					$('#total-earnings').html(`<b><span style="direction: ltr;">&#x62F;.&#x625; ${formattedEarnings}</span></b>`);
					$('#filter-data-submit').html('Submit').attr('disabled', false);

				}
			});
		}

		// Initial Load
		fetchData();

		// Form Submit
		$('#filter-form').on('submit', function(e) {
			e.preventDefault();
			$('#filter-data-submit').html('<span class="spinner-border spinner-border-sm"></span> Please Wait...').attr('disabled', true);
			const filterValue = $('#dateRangeSelect').val();
			const startDate = $('#startDate').val();
			const endDate = $('#endDate').val();
			fetchData(filterValue, startDate, endDate);
		});

		// Show/Hide Date Inputs for "Custom Range"
		$('#dateRangeSelect').change(function() {
			if ($(this).val() === 'custom') {
				$('#startDate').css('width', '20%').show();
				$('#endDate').css('width', '20%').show();
			} else {
				$('#startDate').hide().val('');
				$('#endDate').hide().val('');
			}
		});
	});

	
</script>

@endpush