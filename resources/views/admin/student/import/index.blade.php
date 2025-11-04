@extends('admin.layout.app')
@section('content')
@push('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

@endpush

<div class="card" style="padding: 0px !important;">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
        {{-- Left: Image and Title --}}
        <div class="d-flex align-items-center gap-3">
            <img src="{{ asset('admin/assets/img/graduated.png') }}" width="40px" height="40px">
            <h3 class="mb-0">Student Bulk Import <span class="count-circle" style="margin-top: 0.5%;">{{ count($excels) }}</span></h3>
        </div>

        {{-- Right: Form --}}
        <div class="student-enroll-form-div mt-2 mt-md-0">
            <form action="{{ url()->current() }}" method="get" class="d-flex align-items-center gap-2 ">
                    <input type="date" class="form-control" name="start_date" value="{{ request()->query('start_date', '') }}" title="Search Start Date" style="cursor: pointer;">
                    <input type="date" class="form-control" name="end_date" value="{{ request()->query('end_date', '') }}" title="Search End Date" style="cursor: pointer;">
                    <button class="btn btn-primary">Search</button>
                    <a class="btn btn-dark text-nowrap" data-bs-target="#import-student" data-bs-toggle="modal">Import Student</a>
                    <a class="btn btn-info" onclick="window.location.href='{{ route(Route::currentRouteName()) }}';">Reset</a>
            </form>
        </div>
    </div>
</div>
<div class="row">
	<div class="col-12">
		@if(session()->get('error'))
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
			{{ session()->get('error') }}
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
		@endif
		@if ($errors->any())
		<div class="alert alert-danger alert-dismissible fade show">
			<ul>
				@foreach ($errors->all() as $error)
				<li style="font-size:larger;">{{ $error }}</li>
				@endforeach
			</ul>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
		@endif
	</div>
</div>
<div class="card">
	<div class="card-body">
		<form id="enrool-student" action="{{ route('admin.enrool-student-save') }}" method="post" enctype="multipart/form-data" class="text-start">
			@csrf                  
			<div class="card">
				<div class="card-body">
                    <div class="table-responsive table-card mt-3 mb-1">
                        <table class="table align-middle table-nowrap table-striped table-hover table-responsive">
                            <thead class="table-light table-dark">
                                <tr>
                                    <th>SL</th>
                                    <th>Excel File</th>
                                    @if($admin->admin_role_id == 1)
                                    <th>Uploaded By</th>
                                    @endif
                                    <th>Student Count</th>
                                    <th>Upload Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($excels->count() > 0)
                                @foreach($excels as $excel)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <a href="{{ asset($excel->file_path) }}" download="{{ asset($excel->file_path) }}" style="text-decoration: none;color:#334257;" class="title-color hover-c1 d-flex align-items-center gap-15">
                                            @if($excel->file_path != null)
                                                📥 Download Excel                          
                                            @else
                                            <img src="{{ asset('front/images/no-image.jpg') }}" class="avatar rounded-circle" height="50px" width="50px">
                                            @endif                                           
                                        </a>
                                    </td>
                                    @if($admin->admin_role_id == 1)
                                    <td><a href="{{ url('admin/employee/view/'. encrypt($excel->adminInfo->id)) }}" style="text-decoration: none;color:blue !important;" class="hover-link d-flex align-items-center gap-15">{{ $excel->adminInfo->name ?? '' }}</a></td>
                                    @endif
                                    <td class="text-center">{{ $excel->imported_count ?? '0' }}</td>
                                   
                                    
                                    <td class="white-space: pre;" style="text-wrap-mode:nowrap;">{{ \Carbon\Carbon::parse($excel->created_at)->format('d-M-Y') }}</td>
                                  
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="4" class="text-danger text-center">No Excel File Uploaded Yet!</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        {{ $excels->links('pagination::bootstrap-4') }}
                    </div>
                </div>
			</div>
		</form>
	</div>
</div>

<div class="modal fade" id="import-student" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalLabel">Import Student</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form id="student-bulk-import-store" action="{{ route('admin.student-bulk-import-store') }}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="modal-body">
					<div class="mb-3">
                        <label for="name" class="form-label">Upload Excel File <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="file" accept=".xlsx" required>
                        <div class="form-text mt-3">
                            <a href="{{ asset('app/admin/import-sample/student/student-import-format.xlsx') }}" target="_blank">📥 Download Sample Excel Format</a>
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
	$(document).on('submit', '#student-bulk-import-store', function() {
		let btn = $('button[type="submit"]');
		btn.html('<span class="spinner-border spinner-border-sm"></span> Please Wait...').prop('disabled', true).css('cursor', 'no-drop');
	});
</script>
@endpush

@endpush