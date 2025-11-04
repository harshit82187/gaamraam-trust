@extends('admin.layout.app')
@section('content')
@include('admin.setting.social-pages.menu-bar')

<div class="">
    <div class="card-maintenance">
        <div class="card-body">
            <form id="whatsapp-api" action="{{ route('admin.social-pages.social-media-chat') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">                                
                    <div class="col-6">
                        <div class="d-flex align-items-end gap-2">
                            <img src="https://cdn-icons-png.flaticon.com/128/3536/3536445.png" class="admin_whatsapp_image">
                            <div class="w-100">
                                <label style="color: black;margin-left:1%;">Whatsapp Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control number" required="" value="{{ $setting->value }}" name="whatsapp">
                            </div>	
                        </div>							
                    </div>   
                    <div class="col-6">
                        <div class="d-flex align-items-end gap-2">
                            <div class="w-100">
                                <label style="color: black;margin-left:1%;">Whatsapp API <span class="text-danger">*</span></label>
                                <input type="text" class="form-control number" name="whatsapp_api" required="" value="{{ $whatsapp_api->value }}" name="whatsapp">
                            </div>	
                        </div>							
                    </div>                                                    
                </div>
                <div class="row" style="margin-top: 1%;">
                    <div class="col-2">
                        <input type="submit" class="btn btn-primary" value="Update">
                    </div>
                </div>
            </form>
            
        </div>
    </div>
</div>

<div class="row mt-5">
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


<div class="card-maintenance mt-5">
    <div class="card-body">
        <form id="send-whatsapp-message" action="{{ route('admin.social-pages.send-whatsapp-message') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">                               
                <div class="col-6">
                    <div class="d-flex align-items-end gap-2">
                        <div class="w-100">
                            <label style="color: black;margin-left:1%;">Whatsapp Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control number" required maxlength="10" minlength="10" pattern="\d{10}" placeholder="Check Here Whatsapp API Working Or Not..."  name="whatsapp_no">
                        </div>	
                    </div>							
                </div>                                                  
            </div>
            <div class="row" style="margin-top: 1%;">
                <div class="col-2">
                    <input type="submit" class="btn btn-primary" value="Send Message">
                </div>
            </div>
        </form>
        
    </div>
</div>

@endsection
@push('js')
<script>
    $(document).on('submit', '#whatsapp-api, #send-whatsapp-message', function () {
        let btn = $(this).find('input[type="submit"]');
        btn.val('Please Wait...').prop('disabled', true).css('cursor', 'no-drop');
    });

</script>
@endpush