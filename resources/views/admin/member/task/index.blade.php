@extends('admin.layout.app')
@section('content')
@push('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

@endpush
<div class="page-content">
	<div class="container-fluid">
		<div class="card">
			<div class="card-header">
				<h4>Add Task</h4>
			</div>
			<div class="card-body">
				<form id="task-add-form" method="POST" action="{{ route('admin.task-add') }}"  >
					@csrf
					<div class="row">
						<div class="col-12"  >
							<label>Task Name<span class="text-danger">* </span></label>
							<textarea name="task" class="form-control customTextarea" required></textarea>
						</div>
						<div class="col-12">
							<label>Assign Member<span class="text-danger">* </span></label>
							<select class="form-control select2" multiple name="member_id[]" required >
								<option>-- Select Members --</option>
								@isset($members)
								@foreach($members as $member)
								<option value="{{ $member->id }}">{{ $member->name }}</option>
								@endforeach
								@endisset
							</select>
						</div>
						<div class="col-12" style="margin-top: 44px;" >
							<button type="submit" class="btn btn-primary pay-online" id="submit-task-btn" >Submit</button
						</div>
					</div>
				</form>
			</div>

            <div class="card-body">
                <div class="table-responsive table-card mt-3 mb-1">
                    <table class="table align-middle table-nowrap table-striped table-hover">
                        <thead class="table-light table-dark">
                            <tr>
                                <th>S No.</th>
                                <th>Member Name</th>
                                <th>Task Name</th>
                                <th class="text-nowrap">Assign Date</th>
								<th >Task Status</th>
                                <th>Action </th>
                            </tr>
                        </thead>
                        <tbody>
							@if($tasks->count() > 0)
                            @foreach($tasks as $task)							
							
									
								<tr>
									<td class="text-nowrap">{{ $loop->iteration }}</td>
									<td class="text-nowrap"> {{ \App\Models\User::find($task->assign_to)->name ?? 'N/A' }}</td>
									<td class="text-nowrap">{{ Illuminate\Support\Str::limit($task->task, 35) }} <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ $task->task }}"></i></td>
									<td class="text-nowrap">{{ \Carbon\Carbon::parse($task->created_at)->format('d-M-Y') }} </td>
									<td class="text-center text-nowrap">
                                        <div class="status">
                                            <span class="status-dot @if($task->status == 0) status-reject @elseif($task->status == 1) status-accept   @elseif($task->status == 2) status-pending  @endif">
                                            </span>
                                            @if($task->status == 0)
                                                Rejected
                                            @elseif($task->status == 1)
                                                Accepted
											@elseif($task->status == 2)
                                               Pending 
                                            @elseif($task->status == 3)
                                                Complete Mark

                                            @endif
                                        </div>
                                    </td>
									<td class="text-nowrap">
										<a href="{{ route('admin.task-report-check', ['task_id' => $task->id, 'member_id' => $task->assign_to]) }}" class="btn btn-dark"  >Check Report</a>
									</td>

								</tr>
										
								
                            @endforeach
							@else
								<tr>
									<td colspan="5" class="text-danger text-center">No Tasks Assigned Yet.</td>
								</tr>
							@endif
                        </tbody>
                       
                    </table>
                    <div class="d-flex justify-content-center mt-3">
                        {{ $tasks->links() }}
                    </div>
                    
                </div>
            </div>
		</div>
	</div>
</div>
@endsection
@push('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
	$('.select2').select2({
	    allowClear: true,
	});
	$(document).on('submit', '#task-add-form', function() {
		let btn = $('button[type="submit"]');
		btn.html('<span class="spinner-border spinner-border-sm"></span> Please Wait...').prop('disabled', true).css('cursor', 'no-drop');
	});
</script>

@endpush
