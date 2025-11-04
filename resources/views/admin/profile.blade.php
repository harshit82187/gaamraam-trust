@extends('admin.layout.app')
@push('css')

@endpush
@section('content')
<div class="main-content admin-profile">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <!-- Left Side: Tabs -->
                    <div class="col-md-3 admin-profile-menu" >
                        <ul class="nav flex-column nav-pills profile-update-nav-pills" id="profileTabs" role="tablist">
                            <li class="nav-item mb-2" role="presentation">
                                <a class="nav-link active " id="profile-tab" data-bs-toggle="pill" href="#profile" role="tab" aria-controls="profile" aria-selected="true">Update Profile</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="password-tab" data-bs-toggle="pill" href="#password" role="tab" aria-controls="password" aria-selected="false">Change Password</a>
                            </li>
                            @if($admin->id_card_pdf_path != null)
                            <a class="nav-link mt-2" href="{{ route('admin.id-card-download', encrypt($admin->id)) }}">
                                Download ID Card
                            </a>
                            @endif
                             @if($admin->admin_role_id != 1)
                            <a class="nav-link mt-3" href="{{ route('admin.earn-point') }}">
                                Earn Point
                            </a>
                            @endif
                        </ul>
                    </div>

                <!-- Right Side: Forms -->
                <div class="col-md-9">
                    <div class="tab-content px-5" id="profileTabsContent">
                        <!-- Update Profile Form -->
                         <div class="text-center mb-4">  
                            @php $avatarUrl = $admin->image ?? 'admin/assets/img/profile.jpg'; @endphp                                             
                            <img src="{{ asset($avatarUrl) }}" alt="Admin Avatar" class="rounded-circle shadow" width="120" height="120" style="object-fit: cover; border: 4px solid #f0f0f0;">
                            <h5 class="mt-3">{{ $admin->name }}</h5>
                            <p class="text-muted">{{ $admin->email }}</p>
                        </div>
                        <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <form id="profile-update" action="{{route('admin.profile-update')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="type" value="1" >
                                <!-- Name --> 
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $admin->name) }}" required>
                                </div>
                                <!-- mobile_no -->
                                <div class="mb-3">
                                    <label for="mobile_no" class="form-label">Mobile Number</label>
                                    <input type="text" name="mobile_no" class="form-control" id="mobile_no" value="{{ old('mobile_no', $admin->mobile_no) }}">
                                </div>
                                <!-- Email (readonly or optional) -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" id="email" value="{{ $admin->email }}" >
                                </div>
                                <!-- Profile Image -->
                                <div class="mb-3">
                                    <label for="image" class="form-label">Profile Image</label>
                                    <input type="file" name="image" class="form-control" accept="image/*" id="avatar">
                                </div>
                                <div class="mb-3">
                                    <label for="blood_group" class="form-label">Blood Group</label>
                                    <select name="blood_group" id="blood_group" class="form-control select" required>
                                        <option value="A+" {{ ($admin->blood_group ?? '') == 'A+' ? 'selected' : '' }}>A+</option>
                                        <option value="A−" {{ ($admin->blood_group ?? '') == 'A−' ? 'selected' : '' }}>A−</option>
                                        <option value="B+" {{ ($admin->blood_group ?? '') == 'B+' ? 'selected' : '' }}>B+</option>
                                        <option value="B-" {{ ($admin->blood_group ?? '') == 'B-' ? 'selected' : '' }}>B-</option>
                                        <option value="AB+" {{ ($admin->blood_group ?? '') == 'AB+' ? 'selected' : '' }}>AB+</option>
                                        <option value="AB−" {{ ($admin->blood_group ?? '') == 'AB−' ? 'selected' : '' }}>AB−</option>
                                        <option value="O+" {{ ($admin->blood_group ?? '') == 'O+' ? 'selected' : '' }}>O+</option>
                                        <option value="O-" {{ ($admin->blood_group ?? '') == 'O-' ? 'selected' : '' }}>O-</option>
                                    </select>
                                </div>
                               <div class="mb-3">
                                    <label for="referral_code" class="form-label">Referral Code</label>
                                    <div class="input-group">
                                        <input type="text" id="referralCode" class="form-control" value="{{ $admin->referral_code }}" readonly>
                                        <button type="button" class="btn profile-button" id="copyButton">Copy</button>
                                    </div>
                                </div>
                            
                                <!-- Submit -->
                                <button type="submit" class="btn btn-primary profile-button">Update Profile</button>
                            </form>
                        </div>

                        <!-- Change Password Form -->
                        <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
                            <form id="password-update" action="{{route('admin.profile-update')}}" method="POST">
                                <input type="hidden" name="type" value="2" >
                                @csrf

                                <!-- New Password -->
                                <div class="mb-3 position-relative">
                                    <label for="new_password" class="form-label">New Password</label>
                                    <input type="password" name="new_password" class="form-control" id="new_password" required>
                                    <span class="toggle-password" toggle="#new_password"><i class="fas fa-eye"></i></span>
                                </div>

                                <!-- Confirm Password -->
                                <div class="mb-3 position-relative">
                                    <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                                    <input type="password" name="new_password_confirmation" class="form-control" id="new_password_confirmation" required>
                                    <span class="toggle-password" toggle="#new_password_confirmation"><i class="fas fa-eye"></i></span>
                                    <span id="password-error" class="text-danger" ></span>
                                </div>

                                <button type="submit" id="password-submit" class="btn btn-warning profile-button">Change Password</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div> <!-- end row -->
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    document.querySelectorAll('.toggle-password').forEach(function (el) {
        el.addEventListener('click', function () {
            const input = document.querySelector(el.getAttribute('toggle'));
            const icon = el.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });
    $(document).on('submit', '#profile-update', function() {
        let btn = $('button[type="submit"]');
        btn.html('<span class="spinner-border spinner-border-sm"></span> Please Wait...').prop('disabled', true).css('cursor', 'no-drop');
    });
    $(document).on('submit', '#password-update', function() {
        let btn = $('button[type="submit"]');
        btn.html('<span class="spinner-border spinner-border-sm"></span> Please Wait...').prop('disabled', true).css('cursor', 'no-drop');
    });
</script>
<script>
    $(document).ready(function() {
        $('#new_password_confirmation').on('keyup', function() {
            var new_password_confirmation = $(this).val();
            var new_password = $('#new_password').val();
            let btn = $('#password-submit');

            if (new_password_confirmation !== new_password) {
                $('#password-error').html('Passwords do not match!');
                btn.prop('disabled', true).css('cursor', 'not-allowed');
            } else {
                $('#password-error').html('');
                btn.prop('disabled', false).css('cursor', 'pointer');
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $(document).on('click', '#copyButton', function (event) {
            event.preventDefault(); 
            let referralInput = document.getElementById('referralCode');
            if (referralInput) {
                referralInput.select();
                referralInput.setSelectionRange(0, 99999);
                document.execCommand("copy");
                iziToast.info({
                    title: 'Copied!',
                    message: 'Referral code copied to clipboard',
                    position: 'topRight'
                });
            }
        });
    });
</script>



@endpush