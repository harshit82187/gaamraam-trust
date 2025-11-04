@extends('member.layouts.app')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Task Update ( {{ $task->task ?? '' }}) </h4> 
                    <a href="{{ url('member/task-list') }}" class="btn btn-dark mx-2"  >Back</a>
                </div>
            </div>
        </div>
        <br>

        <div class="card" >
            <div class="card-body">
                @if($task->status != 3 && $task->complete != 100)
                <form id="task-updates-form" action="{{ route('member.task-updates') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="task_id" value="{{ $task->id }}">
                    <div id="taskDetails" >
                        <div class="row mb-2">                        
                                <div class="col-8">
                                    <input type="text" class="form-control" required name="updates[]" placeholder="Enter Task Update">
                                </div> 
                                <div class="col-3">
                                    <input type="file" class="form-control" name="image[]" accept="image/jpg,image/jpeg,image/png">
                                </div>                       
                                <div class="col-1">
                                    <button type="button" class="btn btn-success add-row">+</button>
                                </div>                                               
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>  
                    </div>
                </form>   
                @else
                <div class="d-flex justify-content-between">
                    <p class="m-0">Task Status :- <strong class="text-success fs-5">Complete</strong></p>
                    <p class="m-0">Attachemnt :- <a href="{{ asset($task->attachment) }}" target="_blank">🔗</a></p>
                </div>
                @endif
                
            </div>
        </div>

        <div class="card "  >
            <div class="card-body">
                <table class="table table-striped" id="dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
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
                            <td> {{ $task->updates ?? 'N/A' }}  </td>
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
                            <td colspan="3" class="text-danger text-center">No Task Update Yet.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
                <div class="d-flex justify-content-center new-one-nav">
                    {{ $taskUpdates->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')

<script>
    $(document).ready(function() {
        // Add new row
        $(document).on("click", ".add-row", function() {
            let rowHtml = `<div class="row mb-2">
                           <div class="col-8">
                                <input type="text" class="form-control" required name="updates[]" placeholder="Enter Task Update">
                            </div>  
                            <div class="col-3">
                                <input type="file" class="form-control" name="image[]" accept="image/jpg,image/jpeg,image/png">
                            </div>                            
                            <div class="col-1">
                                <button type="button" class="btn btn-danger remove-row">-</button>
                            </div>
                        </div>`;
            $("#taskDetails").append(rowHtml);
        });
        // Remove row
        $(document).on("click", ".remove-row", function() {
            $(this).closest(".row").remove();
        });
    });

    $(document).on('submit', '#task-updates-form', function() {
        let btn = $('button[type="submit"]');
        btn.html('<span class="spinner-border spinner-border-sm"></span> Please Wait...').prop('disabled', true).css('cursor', 'no-drop');
    });
</script>

@endpush