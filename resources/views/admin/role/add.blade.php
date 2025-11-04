@extends('admin.layout.app')
@section('content')
@push('css')

@endpush

<div class="card">
	<div class="card-header" style="display: flex; gap: 10px; align-items: center;">
        <img src="{{ asset('admin/assets/img/employee.png') }}" width="40px" width="40px">
        <h3 class="mt-3">Employee role setup <span class="count-circle mt-3">{{ count($roles ) }}</span></h3>	
	</div>
</div>

<div class="row">
    <div class="col-12">        
        @if(session()->get('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session()->get('error') }}
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
    <div class="card-body">
        <form id="submit-create-role" method="post" action="{{ route('admin.custom-role.store') }}" class="text-start">
            @csrf
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group mb-4">
                        <label for="name" class="title-color">Role name</label>
                        <input type="text" name="name" class="form-control" id="name" aria-describedby="emailHelp"  placeholder="Ex:Store" required>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-4 flex-wrap align-items-center">
                <label for="name" class="title-color font-weight-bold mb-0">Module permission </label>
                <div class="form-group d-flex gap-2">
                    <input type="checkbox" id="select-all" class="cursor-pointer">
                    <label class="title-color mb-0 cursor-pointer text-capitalize" for="select-all">Select all</label>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6 col-lg-3">
                    <div class="form-group d-flex gap-2">
                        <input type="checkbox" name="module[]" value="dashboard" class="module-permission" id="dashboard">
                        <label class="title-color mb-0" 
                                for="dashboard">Dashboard</label>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="form-group d-flex gap-2">
                        <input type="checkbox" name="module[]" value="manage_student" class="module-permission" id="manage_student">
                        <label class="title-color mb-0"  for="manage_student">Manage Student</label>
                    </div>
                </div>
               
                <div class="col-sm-6 col-lg-3">
                    <div class="form-group d-flex gap-2">
                        <input type="checkbox" class="module-permission" name="module[]" value="manage_member" id="manage_member">
                        <label class="title-color mb-0 text-capitalize" for="order">Manage Member</label>
                    </div>
                </div>
                 <div class="col-sm-6 col-lg-3">
                    <div class="form-group d-flex gap-2">
                        <input type="checkbox" name="module[]" value="follow_up" class="module-permission" id="follow_up">
                        <label class="title-color mb-0"  for="follow_up">Follow Up</label>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="form-group d-flex gap-2">
                        <input type="checkbox" class="module-permission" name="module[]" value="donation" id="donation">
                        <label class="title-color mb-0 text-capitalize" for="donation">Donation & Point's</label>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="form-group d-flex gap-2">
                        <input type="checkbox" class="module-permission" name="module[]" value="notification_management" id="notification_management">
                        <label class="title-color mb-0 text-capitalize" for="notification_management">Notification Management</label>
                    </div>
                </div>
                
                <div class="col-sm-6 col-lg-3">
                    <div class="form-group d-flex gap-2">
                        <input type="checkbox" class="module-permission" name="module[]" value="course_management" id="course_management">
                        <label class="title-color mb-0 text-capitalize" for="course_management">Course Management</label>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="form-group d-flex gap-2">
                        <input type="checkbox" class="module-permission" name="module[]" value="college_management" id="college_management">
                        <label class="title-color mb-0 text-capitalize" for="college_management">College management</label>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="form-group d-flex gap-2">
                        <input type="checkbox" class="module-permission" name="module[]" value="question_bank" id="question_bank">
                        <label class="title-color mb-0 text-capitalize" for="question_bank">Question Bank</label>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="form-group d-flex gap-2">
                        <input type="checkbox" class="module-permission" name="module[]" value="manage_task" id="manage_task">
                        <label class="title-color mb-0 text-capitalize" for="manage_task">Manage Task</label>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="form-group d-flex gap-2">
                        <input type="checkbox" class="module-permission" name="module[]" value="trust_setting" id="trust_setting">
                        <label class="title-color mb-0 text-capitalize" for="trust_setting">Trust Setting</label>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="form-group d-flex gap-2">
                        <input type="checkbox" class="module-permission" name="module[]" value="log_setting" id="log_setting">
                        <label class="title-color mb-0 text-capitalize" for="log_setting">Log Details</label>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="form-group d-flex gap-2">
                        <input type="checkbox" class="module-permission" name="module[]" value="support_ticket" id="support_ticket">
                        <label class="title-color mb-0 text-capitalize" for="support_ticket">Support Ticket</label>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>        
</div>

<div class="card">
    <div class="card-header d-block d-sm-flex justify-content-between align-items-center">
        <span></span>
        <div class="d-block d-sm-flex gap-2 align-items-center justify-content-between">
            <form action="{{ url()->current() }}" method="get" class="d-block d-sm-flex gap-2">
                <input type="text" class="form-control" value="{{ request()->query('name', '') }}" name="name" placeholder="Search Role">
                <button class="btn btn-primary mt-2 mt-sm-0">Search</button>
                <button type="submit" name="export" value="1" class="btn btn-dark text-nowrap mt-2 mt-sm-0">Export Excel</button>
                <button type="button" class="btn btn-info mt-2 mt-sm-0 " onclick="window.location.href='{{ route(Route::currentRouteName()) }}';">Reset</button>
                </form>
        </div>
    </div>
<div class="card-body">
            <div class="table-responsive table-card mt-3 mb-1">
                <table class="table align-middle table-nowrap table-hover table-striped">
                    <thead class="table-light table-dark">
                        <tr>
                            <th>SL</th>
                            <th>Role name</th>
                            <th>Modules</th>
                            <th>Created at	</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($roles) && $roles->count())
                                @foreach($roles as $key => $role)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $role->name ?? "N/A" }}</td>
                                    @php $decodedModules = json_decode($role->module, true) ?? []; @endphp
                                    <td class="text-capitalize">
                                        @foreach($decodedModules as $decodedModule)
                                        {{ ucwords(str_replace('_', ' ', $decodedModule)) }} <br>
                                        @endforeach
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($role->created_at)->format('d-M-Y h:i A') }}</td>
                                    <td>
                                        <label class="switch">
                                        <input type="checkbox" class="status-toggle" data-id="{{ $role->id }}" {{ $role->status ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                        </label> 
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.custom-role.edit',$role->id) }}" class="btn btn-info btn-sm" >Edit</a>
                                        <a href="javascript:void(0)" onclick="deleteRole({{ $role->id }})" class="btn btn-danger btn-sm" >Delete</a>
                                    </td>
                                </tr>
                                @endforeach
                            @else 
                            <tr>
                                <td colspan="6" class="text-danger text-center" >No Role Found!</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-4">
                {{ $roles->links('pagination::bootstrap-4') }}
            </div>
        </div>
</div>

@endsection
@push('js')
<script>
    $(document).ready(function() {
        $('#select-all').change(function() {
            $('.module-permission').prop('checked', $(this).prop('checked'));
        });

        $('.module-permission').change(function() {
            if (!$(this).prop('checked')) {
                $('#select-all').prop('checked', false);
            } else if ($('.module-permission:checked').length === $('.module-permission').length) {
                $('#select-all').prop('checked', true);
            }
        });

       
        $('.status-toggle').change(function() {
            var status = $(this).prop('checked') == true ? 1 : 0;
            var role_id = $(this).data('id');
    
            $.ajax({
                url: '{{ url('admin/custom-role/status-change') }}',
                type: 'POST',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'role_id': role_id,
                    'status': status
                },
                success: function(response) {
                    iziToast.info({
                        title: 'Info',
                        message: response.message,
                        position: 'topRight',
                        timeout: 3000,
                    });
                },
                error: function(xhr, status, error) {
                    iziToast.error({
                        title: 'Error',
                        message: 'Error updating status!',
                        position: 'topRight',
                        timeout: 4000,
                        backgroundColor: '#F0D5B6',
                        titleColor: '#000', 
                        messageColor: '#000', 
                        titleSize: '16px',
                        messageSize: '16px',
                        titleLineHeight: '20px',
                        messageLineHeight: '16px',
                        titleFontWeight: '700', 
                        messageFontWeight: '700'
                        });
                }
            });
        });
        
    });

    function deleteRole(id) {
        Swal.fire({
            title: 'Are you sure to delete this?',
            text: '',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes Delete It!',
            customClass: {
                popup: 'swal2-large',
                content: 'swal2-large'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('admin.custom-role.delete', ':id') }}".replace(':id', id);
            }
        });
    }
</script>
<script>
	$(document).on('submit', '#submit-create-role', function() {
		let btn = $('button[type="submit"]');
		btn.html('<span class="spinner-border spinner-border-sm"></span> Please Wait...').prop('disabled', true).css('cursor', 'no-drop');
	});
</script>
@endpush