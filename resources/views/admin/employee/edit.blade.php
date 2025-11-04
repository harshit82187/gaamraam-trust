@extends('admin.layout.app')
@section('content')
@push('css')

@endpush
<div class="card">
	<div class="card-header" style="display: flex; gap: 10px; align-items: center;">
		<img src="{{ asset('admin/assets/img/employee.png') }}" width="40px" width="40px">
		<h3 class="mt-3">Edit Employee <span class="count-circle mt-3"></h3>
	</div>
</div>







@endsection
@push('js')

@endpush