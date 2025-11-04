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