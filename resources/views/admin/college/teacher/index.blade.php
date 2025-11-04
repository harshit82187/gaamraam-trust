@extends('admin.layout.app')
@section('content')
<div class="card">
	<div class="card-header d-block d-md-flex justify-content-between align-items-center" >
		<div class="gap-2  d-flex align-items-center">
			<h3 class="mb-0"><img src="{{ asset('admin/assets/img/school.png') }}" alt="school Icon" class="me-2" style="width: 35px; height: 35px;">Teacher Listing</h3>
			<span class="count-circle" style="position:unset;" >{{ count($teachers) }}</span>
		</div>
		<div class="d-flex align-items-center justify-content-between gap-3">
			<form action="{{ url()->current() }}" method="get" class="gap-2 d-block d-sm-flex ">
				<input type="text" class="form-control mt-2 mt-sm-0" value="{{ request()->query('name', '') }}" name="name" required placeholder="Search Teacher Name">
				<button class="btn btn-primary mt-2 mt-sm-0">Search</button>
				<a class="btn btn-dark mt-2 mt-sm-0 text-nowrap" href="{{ route('admin.teacher.create') }}" >Add Teacher</a>
				<a class="btn btn-info mt-2 mt-sm-0" href="{{ route('admin.teacher.index') }}">Reset</a>
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
						<th>Image</th>
						<th>Name</th>
						<th>Education </th>
						<th>Experience (In Year)</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@if(count($teachers) > 0)
					@foreach($teachers as $teacher) 
					<tr>
						<td>{{ $loop->iteration }}</td>
						<td>
							<img src="{{ $teacher->image ? asset($teacher->image) : asset('front/images/no-image.jpg') }}" style="height: 50px; width: 50px;" class="avatar-img rounded-circle"   />
						</td>
						<td>{{ $teacher->name ?? '' }}</td>
						<td>{{ $teacher->education ?? '' }}</td>
						<td>{{ $teacher->experience ?? '' }}</td>
						<td>
							<div class="d-flex gap-2">
								<a href="{{ route('admin.teacher.show',$teacher->id) }}" class="btn btn-primary btn-sm" >View</a>
								<a href="{{ route('admin.teacher.edit',$teacher->id) }}" class="btn btn-warning btn-sm" >Edit</a>
                                <a href="javascript:void(0);" class="btn btn-sm btn-danger" onclick="deleteTeacher({{ $teacher->id }})">Delete</a>
								<form id="delete-teacher-form-{{ $teacher->id }}" action="{{ route('admin.teacher.destroy', $teacher->id) }}" method="POST" style="display:none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
							</div>
						</td>
					</tr>
					@endforeach  
					@else
					<tr>
						<td colspan="5" class="text-center">Teacher's Not Found</td>
					</tr>
					@endif                      
				</tbody>
			</table>
			<div class="d-flex justify-content-center mt-3">
				{{ $teachers->links() }}
			</div>
		</div>
	</div>
</div>
@endsection
@push('js')
<script>
    function deleteTeacher(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Delete',
            customClass: {
                popup: 'swal2-large',
                content: 'swal2-large'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                 document.getElementById('delete-teacher-form-' + id).submit();
            }
        });
    }
</script>
@endpush