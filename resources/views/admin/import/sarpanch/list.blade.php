@extends('admin.layout.app')
@section('content')
@push('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
@endpush


<div class="row">
    <div class="col-12">        
        @if(session()->get('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex justify-content-between align-items-center" role="alert">
                {{ session()->get('success') }}
                <button type="button" class="close fs-1 text-dark" data-dismiss="alert" aria-label="Close">
                    <span class="text-dark" aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session()->get('warning'))
            <div class="alert alert-warning alert-dismissible fade show d-flex justify-content-between align-items-center" role="alert">
                {{ session()->get('warning') }}
                <button type="button" class="close fs-1 text-dark" data-dismiss="alert" aria-label="Close">
                    <span class="text-dark" aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session()->get('error'))
            <div class="alert alert-danger alert-dismissible fade show d-flex justify-content-between align-items-center" role="alert">
                {{ session()->get('error') }}
                <button type="button" class="close fs-1 text-dark" data-dismiss="alert" aria-label="Close">
                    <span class="text-dark" aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show d-flex justify-content-between align-items-center">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li style="font-size:larger;">{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close fs-1 text-dark" data-dismiss="alert" aria-label="Close">
                    <span class="text-dark" aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    </div>
</div>



<div class="card">
	<div class="card-header student-enrolls-div">
		<h3>Sarpanch Listing<span class="count-circle">{{ count($sarpanches ) }}</span></h3>

		<div class="student-enroll-form-div">
			<form action="{{ url()->current() }}" method="get">
				<select class="form-control select2" name="district_name">
					<option value="null" selected>--Select District--</option>
					@isset($districts)
					@foreach($districts as $district)
					<option value="{{ $district }}">{{ $district ?? 'N/A' }}</option>
					@endforeach
					@endisset
				</select>
				<div class="enroll-form-btttn">
					<input type="text" class="" value="{{ request()->query('name', '') }}" name="name" placeholder="Search Sarpanch Name">
					<button class="btn btn-primary">Search</button>
					<a class="btn btn-dark" data-bs-target="#import-sarpanch" data-bs-toggle="modal" >Import Sarpanch</a>
					<a class="btn btn-info" onclick="window.location.href='{{ route(Route::currentRouteName()) }}';">Reset</a>
				</div>

			</form>
		</div>
	</div>
	<br>
	<div class="card-body">
		<div class="table-responsive table-card mt-3 mb-1">
			<table class="table align-middle table-nowrap table-hover table-striped">
				<thead class="table-light table-dark">
					<tr>
						<th>Name</th>
						<th>Other Info</th>
                        <th>Occupation</th>
						<th>Enrool Date</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@if($sarpanches->count() > 0)
					@foreach($sarpanches as $sarpanche)
					<tr>
						<td>
							<div style="font-weight: bold;">{{ $loop->iteration }}. {{ $sarpanche->name }}</div>
							<div><a href="tel:{{ $sarpanche->mobile_no ?? 'N/A' }}" style="font-weight: 700;color:#767676;text-decoration: none;background-color: transparent;cursor: pointer;" class="title-color hover-c1">{{ $sarpanche->mobile_no ?? 'N/A' }}</a><br></div>
						</td>
						<td>
							@php $meta = \App\Models\SarpanchMeta::where('sarpanch_id',$sarpanche->id)->first(); 
							     $tellecaller = \App\Models\Admin::FindOrFail($meta->reciever_id);  
							@endphp
							<div class="mb-1">
								<div style="font-size: 14px;">Following Member Name: <strong>{{ $tellecaller->name ?? 'N/A' }}</strong></div>
								<strong>
									<a href="javascript:void(0)" class="" style="font-weight:500;color:#999;">{{ $sarpanche->district_name ?? 'N/A' }}</a> <br>
                                    <a href="javascript:void(0)" class="" style="font-weight:500;color:#999;">{{ $sarpanche->village_name ?? 'N/A' }}</a>

								</strong>
							</div>

						</td>
						<td>
							<div class="mb-1">
                                <strong>    
                                    <a href="javascript:void(0)" class="" style="font-weight:600;color:#424242;">{{ $sarpanche->occupation ?? 'N/A' }}</a><br>
                                     <a href="javascript:void(0)" class="" style="font-weight:600;color:#424242;">{{ $sarpanche->work_type ?? 'N/A' }}</a>

                                </strong>
                            </div>
						</td>
						
						<td class="white-space: pre;" style="text-wrap-mode:nowrap;">{{ \Carbon\Carbon::parse($sarpanche->created_at)->format('d-M-Y') }}</td>
						<td class="d-flex align-items-center gap-1" style="height:117px;">							
							<a href="{{ route('admin.sarpanch.view-follow-up',encrypt($sarpanche->id)) }}" class="btn btn-dark btn-sm">View FollowUp</a>
						</td>
					</tr>
					@endforeach
					@else
					<tr>
						<td colspan="7" class="text-danger text-center">No Sarpanch Details Found Yet.</td>
					</tr>
					@endif
				</tbody>
			</table>
		</div>
		<div class="d-flex justify-content-center mt-4">
			{{ $sarpanches->links('pagination::bootstrap-4') }}
		</div>
	</div>
</div>


<div class="modal fade" id="import-sarpanch" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalLabel">Import Sarpanch</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form id="sarpanch-import" action="{{ route('admin.sarpanch.import') }}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="modal-body">
					<div class="mb-3">
                        <label for="name" class="form-label">Upload Excel File <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="file" accept=".xlsx" required>
                        <div class="form-text mt-3">
                            <a href="{{ asset('app/admin/import-sample/sarpanch/sarpanch-import-format.xlsx') }}" target="_blank">📥 Download Sample Excel Format</a>
                        </div>
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
		});
	});
</script>
<script>
	$(document).on('submit', '#sarpanch-import', function() {
		let btn = $('button[type="submit"]');
		btn.html('<span class="spinner-border spinner-border-sm"></span> Please Wait...').prop('disabled', true).css('cursor', 'no-drop');
	});
</script>
@endpush