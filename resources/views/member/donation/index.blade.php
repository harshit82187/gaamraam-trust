@extends('member.layouts.app')
@section('content')
@push('css')
<link rel="stylesheet" href="{{ asset('admin/assets/css/card.css') }}">
@endpush
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0"> Transparency & Financial Accountability List </h4> 
                </div>
            </div>
        </div>
        <br>

        <div class="card" style="margin-left: -2%;">
            <div class="card-body">
                <div class="card-maintenance">
					<div class="card-body " id="">
						<div class="row">
							<div class="col-12">
								<label style="color:#000000;font-size:20px;font-weight: 800;">Filter Data</label>
								<form id="filter-form" method="post">
									@csrf
									<div class=" mt-3 select-year-div">
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
						<hr style="border: none; height: 5px; background: linear-gradient(to right, #ff7e5f, #feb47b); margin: 20px 0; border-radius: 8px;">
						<div class="row">							
							<div class="col-md-12 my-2">
								<div class="line-chart-container">
									<div>
										<h2 style="color:#000000;font-size:20px;font-weight: 800;">Donation Statistics</h2>
										<canvas id="myLineChart"></canvas>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card mt-3" id="">
					<div class="card-header">
						<div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
							<h1 style="color:#000000; font-size: 20px; font-weight: 800; margin: 0;">Total Donation </h1>
							<!-- <a href="" class="btn btn-dark btn-sm">Export In Excel</a> -->
						</div>
					</div>
					<div class="card-body">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Duration</th>
									<th>Donation</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
                                @foreach($months as $index => $month)
                                @php
                                $monthIndex = $index + 1;
                                $totalEarning = $earnings[$monthIndex] ?? 0;
                                @endphp
                                <tr>
                                    <td>{{ $month ?? 'N/A' }}</td>
                                    <td>{{ $earnings[$index + 1] ?? '0' }}</td>
                                    <td>
   										<a href="{{ route('member.donation-duration-download-pdf', ['month' => $index + 1]) }}"><img src="{{ asset('front/images/pdf.png') }}" height="40px" width="40px" ></a>
                                    </td>
                                </tr>
                                @endforeach
								
							</tbody>
						</table>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>


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
						label: "Donation ",
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
				url: "{{ route('member.filter-donation-detail') }}",
				method: "POST",
				data: {
					_token: "{{ csrf_token() }}",
					filter_values: filterValues,
					startDate: startDate,
					endDate: endDate
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
{{-- Report Graph Script End --}}
@endpush