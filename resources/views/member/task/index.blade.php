@extends('member.layouts.app')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Task List <span class="count-circle" style="margin-left: 1%;" >{{ count($tasks) }}</span> </h4> 
                </div>
            </div>
        </div>
        <br>

        <div class="card" style="margin-left: -2%;">
            <div class="card-body">
                <table class="table table-striped" id="dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Task Name</th>
                            <th>Assign By</th>
                            <th>Assign Date</th>
                             <th>Task</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($tasks->count() > 0)
                        @foreach($tasks as $task)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td> {{ $task->task ?? 'N/A' }} </td>
                            <td>
                                {{ $task->adminDetail->name ?? 'N/A' }}
                            </td>
                            <td>{{ \Carbon\Carbon::parse($task->created_at)->format('d-M-Y') }} </td>
                            <td class="text-center text-nowrap">
                                <div class="status">
                                    <span class="status-dot @if($task->status == 0) status-reject @elseif($task->status == 1) status-accept   @elseif($task->status == 2) status-pending  @endif">
                                    </span>
                                    @if($task->status == 0)
                                        <div class="inline-flex items-center" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" title="Rejected On : {{ \Carbon\Carbon::parse($task->updated_at)->format('d-M-Y') }}  Reject Reason : {{ $task->note }}">Rejected <i class="fa fa-info-circle ml-1"></i></div>
                                    @elseif($task->status == 1)
                                        <div class="inline-flex items-center" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" title="Accepted On : {{ \Carbon\Carbon::parse($task->updated_at)->format('d-M-Y') }}">Accepted <i class="fa fa-info-circle ml-1"></i></div>
                                    @elseif($task->status == 2)
                                        Pending 
                                    @elseif($task->status == 3)
                                         <div class="inline-flex items-center" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" title="Complete Mark On : {{ \Carbon\Carbon::parse($task->complete_mark_date)->format('d-M-Y') }}"> Complete Mark  <i class="fa fa-info-circle ml-1"></i></div>
                                    @endif
                                </div>
                            </td>
                            <td class="d-flex gap-2">
                                @if($task->status == 0)
                                 <a href="javascript:void(0)" class="btn btn-danger" >Rejected</a>
                                @elseif($task->status == 1)
                                    <a href="{{ route('member.task-update', $task->id) }}" class="btn btn-dark" >Update Task</a>                              
                                @elseif($task->status == 2)
                                    <a href="javascript:void(0)"  onclick="acceptTask({{ $task->id }})" class="btn btn-success" >✔️ </a>
                                    <a href="javascript:void(0)" data-id="{{ $task->id }}" data-name="{{ $task->task }}"  class="btn btn-danger reject-task" >✖️ </a>
                                 @elseif($task->status == 3)
                                    <a href="{{ route('member.task-update', $task->id) }}" class="btn btn-dark" >View</a>  
                                @endif
                              
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="4" class="text-danger text-center">No Task Assigned Yet.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
                <div class="d-flex justify-content-center new-one-nav">
                    {{ $tasks->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reject-modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form id="reject-task-form" action="{{ route('member.task-reject') }}" method="POST" enctype="multipart/form-data">
                        @csrf     
                        <input type="hidden" name="id"> 
                        <div class="form-group">
                            <div class="mb-3">
                                <label for="reject_reason" class="form-label">Reject Reason <span class="text-danger" >*</span> </label>
                                <textarea class="form-control" id="reject_reason" name="note" rows="4" placeholder="Enter reason for rejection..." required></textarea>
                              </div>
                        </div>                        
                        
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection



  
  
@push('js')
<script>
    $('.reject-task').on('click',function(e){
        e.preventDefault();
        var id = $(this).data('id');
        var name = $(this).data('name');
        console.log("Id Is : "+id);
        $('#rejectModal').modal('show');
        $('#reject-task-form').find('input[name="id"]').val(id);
        $('#reject-modal-title').html('Task Name: <b>' + name + '</b>');

    });

    $(document).on('submit', '#reject-task-form', function() {
        let btn = $('button[type="submit"]');
        btn.html('<span class="spinner-border spinner-border-sm"></span> Please Wait...').prop('disabled', true).css('cursor', 'no-drop');
    });


function acceptTask(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: '',
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#28a745', // Green
        cancelButtonColor: '#d33',     // Red or whatever you want for cancel
        confirmButtonText: 'Accept',
        customClass: {
            popup: 'swal2-large',
            content: 'swal2-large'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "{{ route('member.task-accept', ':id') }}".replace(':id', id);
        }
    });
}

</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
});
</script>


@endpush