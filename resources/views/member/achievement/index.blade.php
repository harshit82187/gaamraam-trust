@extends('member.layouts.app')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Achievement List <span class="count-circle" style="margin-left: 1%;" >{{ count($tasks) }}</span> </h4> 
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
                            <th>Achievement Name</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($tasks->count() > 0)
                        @foreach($tasks as $task)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td> Task Complete </td>                           
                            <td>{{ \Carbon\Carbon::parse($task->complete_mark_date)->format('d-M-Y') }} </td>                            
                            <td class="d-flex gap-2">
                                <a href="{{ asset($task->attachment) }}" target="_blank" class="btn btn-dark btn-sm">Download</a>
                              
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="4" class="text-danger text-center">No Achievement found Yet.</td>
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

@endpush