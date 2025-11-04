@extends('institute.layout.app')
@section('content')
@push('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
@endpush
<div class="row">
    <div class="col-12">
		@if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
				{!! nl2br(e(session('success'))) !!}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
		@elseif(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {!! nl2br(e(session('error'))) !!}
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
	<div class="card-header">
		<div class="d-flex justify-content-between align-items-center student-attendences">
			<h3>Student Attendance</h3>
			<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#mark-punch-out" class="btn btn-dark" >Mark Punch-Out Time</a>
		</div>
		
		<form id="student-attendance-mark" method="POST" action="{{ route('institute.student-attendance-mark') }}"  >
            @csrf
            <div class="row">
                <div class="col-6" style="margin-top: 18px;" >
                    <label>Attandence Date<span class="text-danger">* </span></label>
					<input type="date" name="date" readonly value="{{ now()->format('Y-m-d') }}" class="form-control" required>
                </div>
				<div class="col-6" style="margin-top: 18px;" >
                    <label>Attandence Time<span class="text-danger">* </span></label>
					<input type="time" name="time" class="form-control" required>
                </div>
				
                <div class="col-12" style="margin-top: 18px;" >
                    <label>Select Student<span class="text-danger">* </span></label>
                    <select class="form-control select2" multiple name="student_id[]" id="student-select" required data-placeholder="Select Student">
						<option value="all">All Students</option>
						@isset($students)
						@foreach($students as $student)
							<option value="{{ $student->id }}">{{ $student->name }}</option>
						@endforeach
						@endisset
					</select>
					
                </div>
                <div class="col-12" style="margin-top: 44px;" >
                    <button type="submit" class="btn btn-primary" >Mark Attendance</button>
                </div>
            </div>
        </form>
	</div>
</div>
	<br>
	<div class="card">
		<div class="card-body">
			<div class="table-responsive table-card mt-3 mb-1">
				<table class="table align-middle table-nowrap ">
					<thead class="table-light">
						<tr>
							<th>SL</th>
							<th>Student Name</th>
							<th>Punch In</th>
							<th>Punch Out</th>
							<th>Remark</th>
							<th>Created By</th>
						</tr>
					</thead>
					<tbody>
						@forelse ($attendances as $index => $attendance)
							<tr>
								<td>{{ $index + 1 }}</td>
								<td>{{ $attendance->student->name ?? 'N/A' }}</td>
								<td>{{ \Carbon\Carbon::parse($attendance->punch_in)->format('d-m-Y h:i A') }}</td>
								<td>{{ $attendance->punch_out ? \Carbon\Carbon::parse($attendance->punch_out)->format('d-m-Y h:i A') : 'N/A' }}</td>
								<td>{{ Illuminate\Support\Str::limit($attendance->note, 35) ?? 'N/A' }} <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ $attendance->note ?? 'N/A' }}"></i></td>
								<td>{{ $attendance->instituteMember->name ?? 'N/A' }}</td>
							</tr>
						@empty
							<tr>
								<td colspan="5" class="text-center text-danger" >No attendance records found.</td>
							</tr>
						@endforelse    
					</tbody>
				</table>
			</div>
		</div>
	</div>	
</div>

<div class="modal fade" id="mark-punch-out" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalLabel">Student Puch Out Record</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form id="student-attendance-punch-out-form" action="{{ route('institute.student-attendance-punch-out') }}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="modal-body">
					<!-- Subject Field -->
					<input type="hidden" name="student_id" >
					<div class="mb-3">
						<label>Attandence Date<span class="text-danger">* </span></label>
						<input type="date" name="date" readonly value="{{ now()->format('Y-m-d') }}" class="form-control" required>
					</div>
					<div class="mb-3">
						<label>Punch Out Time<span class="text-danger">* </span></label>
						<input type="time" name="time" class="form-control" required>
					</div>
					<div class="mb-3" >
						<label>Note (If you want to mention anything)</label>
						<input type="text" name="note" class="form-control" required>
					</div>
					<!-- Description Field -->
					<div class="mb-3">
						<label>Select Student<span class="text-danger">* </span></label>
						<select class="form-control select22" multiple name="student_id[]" id="student-select2" required data-placeholder="Select Student">
							<option value="all">All Students</option>
							@isset($students)
							@foreach($students as $student)
								<option value="{{ $student->id }}">{{ $student->name }}</option>
							@endforeach
							@endisset
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Mark Punch Out</button>
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
	    $('.summernote').summernote({
	    tabsize: 2,
	    height: 120,
	    toolbar: [
	      ['style', ['style']],
	      ['font', ['bold', 'underline', 'clear']],
	      ['color', ['color']],
	      ['para', ['ul', 'ol', 'paragraph']],
	      ['table', ['table']],
	      ['insert', ['link', 'picture', 'video']],
	      ['view', ['fullscreen', 'codeview', 'help']]
	    ]
	   });
	
	});
	$(document).ready(function() {
		let $select = $('#student-select');
		$select.select2();

		$select.on('select2:select', function(e) {
			if (e.params.data.id === "all") {
				$select.find('option:not([value="all"])').prop('selected', true);
				$select.trigger('change');
			}
		});

		$select.on('select2:unselect', function(e) {
			if (e.params.data.id === "all") {
				$select.val(null).trigger('change');
			}
		});

		

		
	});
    $(document).on('submit', '#student-attendance-mark', function() {
        let btn = $('button[type="submit"]');
        btn.html('<span class="spinner-border spinner-border-sm"></span> Please Wait...').prop('disabled', true).css('cursor', 'no-drop');
    });
	$(document).on('submit', '#student-attendance-punch-out-form', function() {
        let btn = $('button[type="submit"]');
        btn.html('<span class="spinner-border spinner-border-sm"></span> Please Wait...').prop('disabled', true).css('cursor', 'no-drop');
    });
</script>
<script>
	$(document).ready(function() {
    $('#mark-punch-out').on('shown.bs.modal', function () {
        $('.select22').select2({
            allowClear: true,
            dropdownParent: $('#mark-punch-out')  
        });
    });

    let $select = $('#student-select2');
    $select.select2();
    $select.on('select2:select', function(e) {
        if (e.params.data.id === "all") {
            // If "All Students" is selected, select all other students
            $select.find('option:not([value="all"])').prop('selected', true);
            $select.trigger('change');
        }
    });

    $select.on('select2:unselect', function(e) {
        if (e.params.data.id === "all") {
            $select.val(null).trigger('change');
        }
    });
});

</script>
@endpush