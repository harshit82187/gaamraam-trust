@extends('admin.layout.app')
@section('content')
@include('admin.setting.social-pages.menu-bar')

<div class="">
    <div class="">
        <div class="card-maintenance mb-3">
            <div class="card-body maintenance-mode">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex justify-content-between alig-items-center">
                            <label style="color:#0177cd; margin:0px">Maintenance Mode:</label>
                            <label class="switch">
                                <input type="checkbox" id="maintenanceToggle">
                                 {{ \App\Models\Setting::get('maintenance_mode') === 'on' ? 'checked' : '' }}>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <p>*By turning the, "Maintenance Mode"ON your website will be disabled until you turn this mode OFF Only the Admin Panel will be functional</p>
        </div>

        <div class="card-maintenance">
            <div class="card-body">
                <form action="{{ route('admin.social-pages.website-profile-update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12 d-flex justify-content-center mb-5">
                            @if(isset($settings['logo']) && $settings['logo'] != null)
                            <div class="col-12">                                   
                                <img src="{{ asset($settings['logo']) }}" alt="Website Logo" style="margin-left:45%;" width="100">
                            </div>
                            @endif
                        </div>
                        <div class="col-sm-6">
                            <label style="color: black">Website Logo</label>
                            <input type="file" class="form-control" name="logo">
                        </div>
                        <div class="col-sm-6">
                            <label style="color: black">Name</label>
                            <input type="text" class="form-control alphabet" name="name" value="{{ $settings['name'] ?? '' }}">
                        </div>
                        <div class="col-sm-6" style="margin-top: 2%;">
                            <label style="color: black">Mobile No</label>
                            <input type="text" class="form-control number" name="mobile_no1" value="{{ $settings['mobile_no1'] ?? '' }}">
                        </div>
                        <div class="col-sm-6" style="margin-top: 2%;">
                            <label style="color: black">Mobile No 2</label>
                            <input type="text" class="form-control number" name="mobile_no2" value="{{ $settings['mobile_no2'] ?? '' }}">
                        </div>
                        <div class="col-sm-6" style="margin-top: 2%;">
                            <label style="color: black">Email</label>
                            <input type="email" class="form-control" name="email" value="{{ $settings['email'] ?? '' }}">
                        </div>
                        <div class="col-sm-6" style="margin-top: 2%;">
                            <label style="color: black">Address</label>
                            <input type="text" class="form-control" name="address" value="{{ $settings['address'] ?? '' }}">
                        </div>
                        <div class="col-sm-6" style="margin-top: 2%;">
                            <label style="color: black">Google Map Link</label>
                            <input type="text" class="form-control" name="map_link" value="{{ $settings['map_link'] ?? '' }}">
                        </div>
                    </div>
                    <div class="row" style="margin-top: 2%;">
                        <div class="col-2">
                            <input type="submit" class="btn btn-primary btn-sm" value="Save Information">
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

</div>

@endsection
@push('js')
<script>
    $('#maintenanceToggle').on('change', function () {
        const checkbox = $(this);
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to change the maintenance mode setting?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, update it!',
            customClass: {
                popup: 'swal2-large',
                content: 'swal2-large'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                let status = checkbox.is(':checked') ? 'on' : 'off';
                $.ajax({
                    url: "{{ route('admin.social-pages.toggle.maintenance') }}",
                    type: "POST",
                    data: {
                        status: status,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        Swal.fire('Updated!', response.message, 'success');
                    },
                    error: function () {
                        Swal.fire('Error!', 'An error occurred while updating maintenance mode.', 'error');
                        checkbox.prop('checked', !checkbox.is(':checked'));
                    }
                });
            } else {
                checkbox.prop('checked', !checkbox.is(':checked'));
            }
        });
    });
</script>
@endpush