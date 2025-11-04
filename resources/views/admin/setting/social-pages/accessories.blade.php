@extends('admin.layout.app')
@section('content')
<style>

</style>
@include('admin.setting.social-pages.menu-bar')
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
<div class="card" style="box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;border-radius: 15px;padding: 15px;">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="card p-4">
                    <form id="send-model" action="{{ route('admin.social-pages.accessories') }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="model">
                        <label class="form-label">Model Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="model" placeholder="Enter Model Name" required>
                        <div class="mt-3">
                            <button type="submit" id="create-model" class="btn btn-primary">Create Model</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-4">
                    <form id="send-controller" action="{{ route('admin.social-pages.accessories') }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="controller">
                        <label class="form-label">Controller Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="controller" placeholder="e.g., Admin/Auth/LoginController"  required>
                        <div class="mt-3">
                            <button type="submit" id="create-controller" class="btn btn-primary">Create Controller</button>
                        </div>
                    </form>
                </div>
            </div>
            @if(session('migration_path'))
            <hr/>
            <div class="col-12">
                <div class="card mt-4">
                    <div class="card-header">Migration Created</div>
                    <div class="card-body">
                        <form action="{{ route('admin.social-pages.accessories') }}" method="POST" class="d-flex align-items-center">
                            @csrf
                            <div class="d-flex flex-column gap-3 w-100">
                                <div class="d-flex">
                                    <input type="hidden" name="type" value="migrate_file">
                                    <input type="text" class="form-control me-2" name="migration_path" id="migrationPath" value="{{ session('migration_path') }}" readonly>
                                </div>
                                <div class="d-flex">
                                    <button type="submit" class="btn btn-success me-2">Run Migration</button>
                                    <button type="button" class="btn btn-secondary" onclick="copyMigrationPath()">Copy Path</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>  
</div>

@endsection
@push('js')
<script>
	$(document).on('submit', '#send-model', function() {
	    let btn1 = $('button[id="create-model"]');
	    btn1.html('<span class="spinner-border spinner-border-sm"></span> Please Wait...').prop('disabled', true).css('cursor', 'no-drop');
	});
	$(document).on('submit', '#send-controller', function() {
	    let btn2 = $('button[id="create-controller"]');
	    btn2.html('<span class="spinner-border spinner-border-sm"></span> Please Wait...').prop('disabled', true).css('cursor', 'no-drop');
	});
	
	function copyMigrationPath() {
	    const input = document.getElementById("migrationPath");
	    input.select();
	    input.setSelectionRange(0, 99999); // For mobile
	    navigator.clipboard.writeText(input.value);
	    alert("Migration path copied!");
	}
</script>


@endpush