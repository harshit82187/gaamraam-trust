@extends('member.layouts.app')
@section('content')
<div class="page-content">
    <div class="container-fluid">      
        <br>
        <div class="card">
            <div class="card-header" style="display: flex;justify-content: space-between;align-items: center;">
                <h3>Enroll Student's</h3>
                <span class="count-circle" style="margin-left:18%;top:20px;" >{{ count($students ) }}</span>
                <div style="display: flex; gap: 10px; align-items: center;justify-content: space-between;">
                    <form action="{{ url()->current() }}" method="get" style="display: flex;gap:15px;">
                        <input type="text" class="form-control" value="{{ request()->query('name', '') }}" name="name" required placeholder="Search Student Name">
                        <button class="btn btn-primary">Search</button>
                        <a class="btn btn-dark" data-bs-target="#add-student" data-bs-toggle="modal" style="width:58%;">Add Student</a>
                        <a class="btn btn-info" href="{{ route('member.enrool-student') }}">Reset</a>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive table-card mt-3 mb-1">
                    <table class="table align-middle table-nowrap ">
                        <thead class="table-light">
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Mobile No</th>
                                <th>Email </th>
                                <th>Course</th>
                                <th>Enrool Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($students->count() > 0)
                            @foreach($students as $student) 
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->mobile }}</td>
                                <td>{{ $student->email }}</td>
                                <td>
                                    @if($student->course == 1)
                                        UPSC
                                    @elseif($student->course == 2)
                                        SSC
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($student->created_at)->format('d-M-Y') }}</td>
                                <td>
                                    <a href="{{ route('member.enrool-student-info',$student->id) }}" class="btn btn-dark btn-sm" >View</a>
                                </td>
                            </tr>
                            @endforeach        
                            @else 
                            <tr>
                                <td colspan="7" class="text-danger text-center">No Student Register Yet.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>             
    </div>
</div>
<div class="modal fade" id="add-student" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content" style="width:165%;margin-left:-27%">
			<div class="modal-header">
				<h5 class="modal-title" id="modalLabel">Student Enrollment</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form id="enrool-student-save-form" action="{{ route('member.enrool-student-save') }}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="modal-body">
					<div class="mb-3">
						<label for="name" class="form-label">Student Name <span class="text-danger">*</span></label>
						<input type="text" class="form-control" name="name" placeholder="Enter Student Name" required>
					</div>
					
					<div class="mb-3">
						<label for="email" class="form-label">Student Email <span class="text-danger">*</span></label>
						<input type="email" class="form-control"  name="email" placeholder="Enter Student Email Address" autocomplete="one-time-code" required>
					</div>
					
					<div class="mb-3">
						<label for="password" class="form-label">Student Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control"  name="password" placeholder="Create Student Password " autocomplete="one-time-code" required>				
				    </div>

                    <div class="mb-3">
						<label for="phone" class="form-label">Student Whatsapp Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control"  name="phone" placeholder="Enter Student  Whatsapp Number" required>	
    				</div>

                    <div class="mb-3">
						<label for="course" class="form-label">Course <span class="text-danger">*</span></label>
                        <select class="form-control select" name="course"  required>
                            <option disabled value="" selected >--Choose Course --</option>
                            <option value="1" >UPSC</option>
                            <option value="2" >SSC</option>
                        </select>
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
<script>
    $(document).on('submit', '#enrool-student-save-form', function() {
        let btn = $('button[type="submit"]');
        btn.html('<span class="spinner-border spinner-border-sm"></span> Please Wait...').prop('disabled', true).css('cursor', 'no-drop');
    });
</script>
@endpush