@extends('admin.layout.app')
@section('content')
<div class="page-content">
	<div class="container-fluid">
		<div class="card">
			<div class="card-header" style="display: flex; gap:15px; align-items: center;justify-content:space-between;">
                <h4 class="w-75">Task Report ({{ $task->task ?? '' }}) - Assigned to {{ $member->name ?? 'N/A' }}</h4>
                <div class="d-flex align-items-center gap-3">
					<a href="{{ url('admin/task-list') }}" class="btn btn-dark btn-sm">Back</a>
					@if($taskUpdates->count() > 0 && $task->complete == 0)
					<a href="javascript:void(0)"  onclick="markComplete({{ $task->id }}, {{ $member->id }})" class="btn btn-dark btn-sm">Mark Complete</a>
					@endif
					
				</div>
			</div>    
			@if($task->complete == 100)
				<div class="d-flex align-items-center justify-content-between p-3">
					<p>Task Status :- <strong class="text-success">Complete</strong> </p> <br>
					<p>Attachment :- <a href="{{ asset($task->attachment) }}" target="_blank">🔗</a></p>
				</div>
			@endif        
			<div class="card-body">
				<div class="table-responsive table-card mt-3 mb-1">
					<table class="table align-middle table-nowrap ">
						<thead class="table-light">
							<tr>
								<th>S No.</th>
								<th>Task Update</th>
								<th>Image</th>
								<th>Update Date</th>
							</tr>
						</thead>
						<tbody>
							@if($taskUpdates->count() > 0)
							@foreach($taskUpdates as $task)								
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ Illuminate\Support\Str::limit($task->updates, 80) }} <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ $task->updates }}"></i></td>
								<td>
									@if($task->image != null)
									<a href="{{ asset($task->image) }}" target="_blank">
									 <img src="{{ asset($task->image) }}" alt="{{ asset($task->image) }}" height="50px" width="50px" >
									</a>
								   
									@else 
									N/A
									@endif
								 </td>
								<td>{{ \Carbon\Carbon::parse($task->created_at)->format('d-M-Y') }} </td>
							</tr>
							@endforeach
							@else
							<tr>
								<td colspan="3" class="text-danger text-center">No Tasks Report Generate Yet.</td>
							</tr>
							@endif
						</tbody>
					</table>
					<div class="d-flex justify-content-center mt-3">
						{{ $taskUpdates->links() }}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
@push('js')
<script>
    function markComplete(id,member_id) {
        Swal.fire({
            title: 'Are you sure to complete mark this task?',
            text: 'This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText:'Yes',
            customClass: {
                popup: 'swal2-large',
                content: 'swal2-large'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ url('admin/task-complete-mark') }}/" + id + "/" + member_id;
                console.log("Harshit");
            }
        });
    }
</script>
@endpush