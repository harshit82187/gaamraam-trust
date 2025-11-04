@extends('admin.layout.app')
@section('content')
@push('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<style>
.filter-data{
    color:#000000 !important;font-size:20px !important;font-weight: 700;
}
.select2-container--default .select2-selection--single {
    height: 38px !important;
    line-height: 38px !important; 
    padding: 5px 10px;
}

.select2-container--default .select2-selection--multiple {
    min-height: 38px !important; 
    line-height: 28px !important; 
    padding: 5px 10px;
}
</style>

@endpush
<div class="card">
    <div class="card-header">        
            <div class="row">
                <div class="col-12">
                    <label class="filter-data" >Filter Data</label>
                    <form id="filter-form" method="GET">
                        <div class="d-flex align-items-center mt-3" style="gap:16px ;align-items: center;" >
                            <select class="form-control select2" name="member_id">
                                <option value="all" {{ request('member_id', 'all') == 'all' ? 'selected' : '' }}>All Members</option>
                                @foreach($members as $member)
                                  <option value="{{ $member->id }}" {{ request('member_id') == $member->id ? 'selected' : '' }}>{{ $member->name }}</option>
                                @endforeach
                            </select>
                            <select id="dateRangeSelect" name="filter_values" style="width:22%;" class="form-control mr-2">
                                <option value="this_year" {{ request('filter_values', 'this_year') == 'this_year' ? 'selected' : '' }}>This Year</option>
                                <option value="this_month" {{ request('filter_values') == 'this_month' ? 'selected' : '' }}>This Month</option>
                                <option value="this_week" {{ request('filter_values') == 'this_week' ? 'selected' : '' }}>This Week</option>
                                <option value="custom" {{ request('filter_values') == 'custom' ? 'selected' : '' }}>Custom Range</option>
                            </select>
                            <input type="date" class="form-control mr-2" id="startDate" value="{{ request('startDate') }}" name="startDate" placeholder="Start Date" value="" style="display: none;width:22%;">
                            <input type="date" class="form-control ml-2" id="endDate" value="{{ request('endDate') }}" name="endDate" placeholder="End Date" value="" style="display: none;width:22%;">
                            <button class="btn btn-submit ml-3" id="filter-data-submit" style="background-color: #007bff;color: #fff;border: none;cursor: pointer;" type="submit">Filter</button>


                        </div>
                    </form>
                </div>
            </div>
        
    </div>
</div>

<div class="card">
	<div class="card-header d-block d-md-flex justify-content-between align-items-center">
        <div class="d-flex gap-2 align-items-center">
            <i class="fas fa-piggy-bank fa-2x mt-2" style="font-size: 24px;"></i>
            <h3 class="mb-0">Donations</h3>
            <span class="count-circle" style="position: unset;" >{{ count($donations ) }}</span>
        </div>	 
		<div class="d-block d-md-flexgap-3 align-items-center gap-3 justify-content-between">
			<form action="{{ url()->current() }}" method="get" class="d-block d-md-flex gap-2" >
				<input type="text" class="form-control" value="{{ request()->query('invoice_no', '') }}" name="invoice_no" required placeholder="Search Invoice No">
				<button class="btn btn-primary mt-3 mt-md-0">Search</button>
			    <a class="btn btn-dark mt-3 mt-md-0 text-nowrap" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#add-donation" >Add Donation</a>
				<a class="btn btn-info mt-3 mt-md-0" href="{{ route('admin.donation-report') }}">Reset</a>

			</form>
		</div>
	</div>
	<br>
	<div class="card-body">
		<div class="table-responsive table-card mt-3 mb-1">
			<table class="table align-middle table-nowrap table-hover table-striped">
				<thead class="table-light table-dark">
					<tr>
						<th>SL</th>
						<th>Invoice No</th>
						<th>Transaction Id</th>
                        <th>Mode</th>
						<th>Donor Name</th>
                        <th>Donate Amount</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@if(count($donations) > 0)
						@foreach($donations as $donation) 
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $donation->invoice_no ?? '' }}</td>
								<td>{{ $donation->r_payment_id ?? 'Payment Recieved Via QR Code' }}</td>
                                <td class="text-center">
                                    {{ $donation->mode == '1' ? 'Online' : 'Offline' }}
                                </td>
                                @if($donation->user_id != null)
								    <td> <a href="{{ route('admin.member.member-info',$donation->user_id) }}" style="text-decoration:none;font-weight:700;color:black;" >{{ $donation->member->name ?? '' }}</a> </td>
                                    @else
                                    <td style="cursor:no-drop;">{{ $donation->user_name }}</td>
                                @endif
                                <td class="text-center">
                                    <i class="fas {{ $donation->currency == 'USD' ? 'fa-dollar-sign' : 'fa-rupee-sign' }}"></i> 
                                    {{ $donation->amount }}
                                </td>
							   <td>
								<a href="{{ asset($donation->donation_pdf) }}" target="_blank" class="btn btn-dark btn-sm" >Download</a>
							   </td>
								
							</tr>
						@endforeach  
					@else
					<tr>
						<td colspan="7" class="text-center text-danger">Donation's Not Found</td>
					</tr>
					@endif                      
				</tbody>
			</table>
			<div class="d-flex justify-content-center mt-3">
                {{ $donations->links('pagination::bootstrap-5') }}
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="add-donation" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalLabel">Add Donation</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form action="{{ route('admin.donation-add') }}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="modal-body">			
					<div class="mb-3">
						<label for="name" class="form-label">Donor Name  <span class="text-danger" >*</span> </label>
						<input type="text" class="form-control" id="name" name="user_name" placeholder="Enter Donor Name" required>
					</div>
					<div class="mb-3">
						<label for="image" class="form-label">Donor Mobile</label>
						<input type="text" class="form-control" id="user_mobile" name="user_mobile" placeholder="Enter Donor Mobile No"  >
					</div>

                    <div class="mb-3">
						<label for="image" class="form-label">Donor Email</label>
						<input type="text" class="form-control" id="user_email" name="user_email" placeholder="Enter Donor Email" >
					</div>

                    <div class="mb-3">
						<label for="image" class="form-label">Currency <span class="text-danger" >*</span></label>
						<select class="form-control" name="currency" required >
                            <option value="INR" selected>Indian Rupees (₹)</option>
                            <option value="USD">USD ($)</option>
                        </select>
                        </div>

                    <div class="mb-3">
						<label for="image" class="form-label">Donate Amount</label>
						<input type="text" class="form-control" id="amount" name="amount"  placeholder="Enter Donate Amount" >
					</div>
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>


@endsection
@push('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            allowClear: true,
            width:'300px'
        });
    });
</script>
<script>
	document.addEventListener("DOMContentLoaded", function() {
		const dateRangeSelect = document.getElementById('dateRangeSelect');
		const startDate = document.getElementById('startDate');
		const endDate = document.getElementById('endDate');

		function toggleDateFields() {
			if (dateRangeSelect.value === 'custom') {
				startDate.style.display = 'block';
				endDate.style.display = 'block';
			} else {
				startDate.style.display = 'none';
				endDate.style.display = 'none';
			}
		}
		dateRangeSelect.addEventListener('change', toggleDateFields);
		toggleDateFields(); 
	});
</script>
<script>
    $(document).ready(function () {
        $('#filter-form').on('submit', function () {
        let $button = $('#filter-data-submit'); 
        $button.html('<span class="spinner-border spinner-border-sm"></span> Please Wait...')
               .prop('disabled', true)
               .css('cursor', 'not-allowed');
    });
});

</script>

@endpush