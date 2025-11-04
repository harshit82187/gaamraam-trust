@extends('admin.layout.app')
@section('content')

<div class="card">
	<div class="card-header d-block d-md-flex justify-content-between align-items-center">
		<div class="gap-2  d-flex align-items-center">
			<h3 class="mb-0">Manage broadcast</h3>
			<span class="count-circle" style="position:unset;" >{{ count($broadcasts) }}</span>
		</div>
		<div class="d-flex align-items-center justify-content-between gap-3">
			<a class="btn btn-dark text-nowrap" data-bs-target="#add-staff" data-bs-toggle="modal" >Add broadcast</a>
	    </div>
    </div>
	<br>
	<div class="card-body">
		<div class="table-responsive table-card mt-3 mb-1">
			<table class="table align-middle table-nowrap table-hover table-striped">
				<thead class="table-light table-dark">
					<tr>
						<th>S No.</th>
                        <th>Teacher</th>
						<th>Date</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@if(count($broadcasts) > 0)
						@foreach($broadcasts as $broadcast) 
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $broadcast->teacher->name ?? '' }}</td>
                                <td> {{ \Carbon\Carbon::parse($broadcast->datetime)->format('l, d M Y h:i A') }}</td>								
							    <td>
								<form action="{{ route('admin.broadcast-delete', $broadcast->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this broadcast?')">
                                        Delete
                                    </button>
                                </form>
							   </td>
							</tr>
						@endforeach  
					@else
					<tr>
						<td colspan="5" class="text-center">Broadcast's Not Found</td>
					</tr>
					@endif                      
				</tbody>
			</table>
			<div class="d-flex justify-content-center mt-3">
				{{ $broadcasts->links() }}
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="add-staff" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content" >
			<div class="modal-header">
				<h5 class="modal-title" id="modalLabel">Add broadcast</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form id="college-staff-add-form" action="{{route('admin.broadcast-add')}}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="modal-body">
                    <div class="mb-3">
						<label for="college" class="form-label">Teacher <span class="text-danger">*</span></label>
                        <select class="form-control select" name="teacher_id"  required>
                            @php $teachers = \App\Models\Teacher::get(); @endphp
                            <option disabled value="" selected >--Select Teacher --</option>
                            @isset($teachers)
                            @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" >{{ $teacher->name ?? 'N/A' }}</option>
                            @endforeach
                            @endisset
                        </select>
    				</div>

                    <div class="mb-3">
						<label for="datetime" class="form-label">Date<span class="text-danger">*</span></label>
						<input type="datetime-local" class="form-control" name="datetime" autocomplete="one-time-code" required>
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
    $(document).on('submit', '#college-staff-add-form', function() {
        let btn = $('button[type="submit"]');
        btn.html('<span class="spinner-border spinner-border-sm"></span> Please Wait...').prop('disabled', true).css('cursor', 'no-drop');
    });
	$("input[type='number'], .number").on("input", function () {
        this.value = this.value.replace(/[^0-9]/g, '');
         if (this.value.length > 10) {
          this.value = this.value.slice(0, 10); 
      }
    });
   
</script>


@endpush