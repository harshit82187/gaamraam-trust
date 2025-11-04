@extends('admin.layout.app')
@section('content')
@include('admin.setting.social-pages.menu-bar')

<!-- Tabs Navigation -->
<div class="card mail_config">
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs" id="mailTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="config-tab" data-bs-toggle="tab" data-bs-target="#mail-config" type="button" role="tab">
                    <img src="{{ asset('front/images/mail-config.png') }}" width="24" class="me-2">
                    Mail Configuration
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="test-tab" data-bs-toggle="tab" data-bs-target="#send-test" type="button" role="tab">
                    <img src="{{ asset('front/images/send-test-mail.png') }}" width="24" class="me-2">
                    Send Test Mail
                </button>
            </li>
        </ul>
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



    <!-- Tabs Content -->
    <div class="card">
        <div class="card-body tab-content" id="mailTabContent">
            <!-- Mail Configuration Tab -->
            <div class="tab-pane fade show active" id="mail-config" role="tabpanel">
                <form id="mail-configuration" action="{{ route('admin.social-pages.mail-configuration') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Mailer name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" value="{{ $mailConfig['name'] ?? '' }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Host <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="host" value="{{ $mailConfig['host'] ?? '' }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Driver <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="driver" value="{{ $mailConfig['driver'] ?? '' }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Port <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="port" value="{{ $mailConfig['port'] ?? '' }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Username <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="username" value="{{ $mailConfig['username'] ?? '' }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email ID <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" value="{{ $mailConfig['email'] ?? '' }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Encryption <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="encryption" value="{{ $mailConfig['encryption'] ?? '' }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="password" value="{{ $mailConfig['password'] ?? '' }}" required>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>

            <!-- Send Test Mail Tab -->
            <div class="tab-pane fade" id="send-test" role="tabpanel">
                <form id="send-mail" action="{{ route('admin.social-pages.send-mail') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Send Mail</button>
                    </div>
                </form>
            </div>
        </div>        
    </div>
    
</div>


@endsection
@push('js')
<script>
    $(document).on('submit', '#mail-configuration', function() {
        let btn = $('button[type="submit"]');
        btn.html('<span class="spinner-border spinner-border-sm"></span> Please Wait...').prop('disabled', true).css('cursor', 'no-drop');
    });
    $(document).on('submit', '#send-mail', function() {
        let btn = $('button[type="submit"]');
        btn.html('<span class="spinner-border spinner-border-sm"></span> Please Wait...').prop('disabled', true).css('cursor', 'no-drop');
    });
</script>


@endpush