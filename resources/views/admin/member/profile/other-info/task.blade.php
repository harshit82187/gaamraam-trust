@extends('admin.layout.app')
@section('content')
<div class="page-content member_info">
    <div class="container-fluid">
        @include('admin.member.profile.other-info.menu-bar')
        <div class="card">
            <div class="card-header">
                <div style="display: flex; align-items: center; justify-content: space-between; cursor: pointer;width: 100%;"> 
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <img src="{{ asset('admin/assets/img/task.png') }}" style="width: 30px;" alt="Task Info">
                        <h1>Task Info</h1>
                    </div>
                    <h1>Member Name : {{ $member->name }}</h1>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div style="display: flex; gap: 10px; align-items: center;justify-content: space-between;">
                    <form action="{{ url()->current() }}" method="get" style="display: flex;gap:15px;">
                        <input type="text" class="form-control" value="{{ request()->query('task', '') }}" name="task" required placeholder="Search Task Name">
                        <button class="btn btn-primary">Search</button>
                        <button type="button" class="btn btn-info" onclick="window.location.href='{{ route(Route::currentRouteName(), encrypt($member->id)) }}';">Reset</button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive table-card mt-3 mb-1">
                    <table class="table align-middle table-nowrap table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>SL</th>
                                <th>Task Name</th>
                                <th>Assign Date	</th>
                                <th>Task Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($tasks->count() > 0)
                                @foreach($tasks as $key => $task)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $task->task ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($task->created_at)->format('d-M-Y') }} </td>
                                    <td class="text-center">
                                        <div class="status">
                                            <span class="status-dot @if($task->status == 0) status-reject @elseif($task->status == 1) status-accept  @else status-pending  @endif">
                                            </span>
                                            @if($task->status == 0)
                                                Rejected
                                            @elseif($task->status == 1)
                                                Accepted
                                            @else 
                                                Pending
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
                                <td colspan="5" class="text-center text-danger">Task's Not Found</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center mt-3">
                        {{ $tasks->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
        
      
    </div>
</div>
@endsection


