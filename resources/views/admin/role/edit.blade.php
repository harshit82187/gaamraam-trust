@extends('admin.layout.app')
@section('content')
@push('css')

@endpush

<div class="card">
	<div class="card-header" style="display: flex; gap: 10px; align-items: center;justify-content: space-between;">
        <div style="display: flex; gap: 10px; align-items: center;">
            <img src="{{ asset('admin/assets/img/employee.png') }}" width="40px" width="40px">
            <h3 class="mt-3" > Role Update</h3>
        </div>       	
     <a href="{{ route('admin.custom-role.add') }}" class="btn btn-dark bt-sm" >Back</a>
	</div>
</div>

<div class="row">
    <div class="col-12">        
        @if(session()->get('error'))
            <div class="alert alert-danger alert-dismissible fade show d-flex justify-content-between align-items-center" role="alert">
                {{ session()->get('error') }}
                <button type="button" class="close fs-1 text-dark" data-dismiss="alert" aria-label="Close">
                    <span class="text-dark" aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show d-flex justify-content-between align-items-center">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li style="font-size:larger;">{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close fs-1 text-dark" data-dismiss="alert" aria-label="Close">
                    <span class="text-dark" aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    </div>
</div>

<div class="card">
    <div class="card-body">
         <form id="update-role" method="post" action="{{ route('admin.custom-role.update') }}" class="text-start">
            @csrf
            <input type="hidden" name="id" value="{{ $role->id }}">

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group mb-4">
                        <label for="name" class="title-color">Role name</label>
                        <input type="text" name="name" class="form-control" value="{{ $role->name ?? 'N/A' }}" required>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-4 flex-wrap">
                <label for="name" class="title-color font-weight-bold mb-0">Module permission</label>
                <div class="form-group d-flex gap-2">
                    <input type="checkbox" id="select-all" class="cursor-pointer">
                    <label class="title-color mb-0 cursor-pointer text-capitalize" for="select-all">Select all</label>
                </div>
            </div>

            <div class="row">
                @php
                    $modules = [
                        'dashboard' => 'Dashboard',
                        'manage_student' => 'Manage Student',
                        'follow_up' => 'Follow Up',
                        'manage_member' => 'Manage Member',
                        'donation' => "Donation & Point's",
                        'notification_management' => 'Notification Management',
                        'course_management' => 'Course Management',
                        'college_management' => 'College Management',
                        'question_bank' => 'Question Bank',
                        'manage_task' => 'Manage Task',
                        'trust_setting' => 'Trust Setting',
                        'log_setting' => 'Log Details',
                        'support_ticket' => 'Support Ticket',
                    ];
                @endphp

                @foreach($modules as $value => $label)
                <div class="col-sm-6 col-lg-3">
                    <div class="form-group d-flex gap-2">
                        <input type="checkbox" name="module[]" class="module-permission" value="{{ $value }}" id="{{ $value }}"
                               {{ in_array($value, $selectedModules) ? 'checked' : '' }}>
                        <label class="title-color mb-0 text-capitalize" for="{{ $value }}">{{ $label }}</label>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>        
</div>



@endsection
@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const allCheckboxes = document.querySelectorAll('.module-permission');
        const selectAll = document.getElementById('select-all');

        // Auto check select-all if all are checked
        const allChecked = Array.from(allCheckboxes).every(cb => cb.checked);
        selectAll.checked = allChecked;

        // Toggle all on click
        selectAll.addEventListener('change', function () {
            allCheckboxes.forEach(cb => cb.checked = this.checked);
        });
    });
</script>
<script>
	$(document).on('submit', '#update-role', function() {
		let btn = $('button[type="submit"]');
		btn.html('<span class="spinner-border spinner-border-sm"></span> Please Wait...').prop('disabled', true).css('cursor', 'no-drop');
	});
</script>
@endpush