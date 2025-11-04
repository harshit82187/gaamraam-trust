@extends('admin.layout.app')
@section('content')

@include('admin.setting.social-pages.menu-bar')

<div class="card" style="box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;border-radius: 15px;padding: 15px;">
    <div class="card-body">
        <form action="{{ route('admin.social-pages.term-condition') }}" method="POST">
            @csrf
            <div class="row">
                <label style="font-size: 20px !important;font-weight: 500;">Term & Condition<span class="text-danger ml-2">*</span></label>
                <textarea class="form-control summernote" cols="8" rows="8" name="value">{!! $termCondition->value ?? '' !!}</textarea>
            </div>
            <div class="col-4 mt-5">
                <input type="submit" class="btn btn-primary " value="Update">
            </div>
        </form>
    </div>

</div>

@endsection
@push('js')
<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            tabsize: 2,
            height: 550,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });

    });
</script>


@endpush