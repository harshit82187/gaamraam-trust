@extends('front.layout.app')
@section('content')
<!-- ------------------ Website  format ------------------ -->
<style>
	.main_id_card {
	width: 100%;
	max-width: 400px;
	margin: 25px auto;
	position: relative;
	padding: 0;
	min-height: 500px;
	height: 100%;
	}
	.id-card-tag {
	width: 0;
	height: 0;
	border-left: 100px solid transparent;
	border-right: 100px solid transparent;
	border-top: 100px solid #2aa457;
	margin: -10px auto -30px auto;
	}
	.id-card-tag:after {
	content: '';
	display: block;
	width: 0;
	height: 0;
	border-left: 50px solid transparent;
	border-right: 50px solid transparent;
	border-top: 100px solid white;
	margin: -10px auto -30px auto;
	position: relative;
	top: -130px;
	left: -50px;
	}
	.id-card-tag-strip {
	width: 45px;
	height: 40px;
	background-color: #dc6c41;
	margin: 0 auto;
	border-radius: 5px;
	position: relative;
	top: 9px;
	z-index: 1;
	border: 1px solid #dc6c41;
	}
	.id-card-tag-strip:after {
	content: '';
	display: block;
	width: 100%;
	height: 1px;
	background-color: #e65b34;
	position: relative;
	top: 10px;
	}
	.id-card-hook {
	background-color: black;
	width: 70px;
	margin: 0 auto;
	height: 15px;
	border-radius: 5px 5px 0 0;
	}
	.id-card-hook:after {
	content: '';
	background-color: white;
	width: 47px;
	height: 6px;
	display: block;
	margin: 0px auto;
	position: relative;
	top: 6px;
	border-radius: 4px;
	}
	.id-card-wrapper {
	perspective: 1000px;
	}
	.id-card-holder {
	width: 225px;
	min-height: 400px;
	height: 100%;
	padding: 4px;
	margin: 0 auto;
	background-color: #1f1f1f;
	border-radius: 10px;
	position: relative;
	transform-style: preserve-3d;
	transition: transform 0.8s;
	cursor: pointer;
	box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
	}
	.id-card-holder.flipped {
	transform: rotateY(180deg);
	}
	.id-card-holder:after {
	content: '';
	width: 7px;
	display: block;
	background-color: #2aa457;
	height: 100px;
	position: absolute;
	top: 105px;
	border-radius: 5px 0 0 5px;
	right: 0;
	}
	.id-card-holder:before {
	content: '';
	width: 7px;
	display: block;
	background-color: #2aa457;
	height: 100px;
	position: absolute;
	top: 105px;
	left: 0;
	border-radius: 0px 5px 5px 0;
	z-index: 2;
	}
	.id-card-front,
	.id-card-back {
	position: absolute;
	width: 100%;
	height: 100%;
	background-color: #fff;
	top: 0;
	left: 0;
	backface-visibility: hidden;
	border-radius: 10px;
	padding: 10px;
	text-align: center;
	box-shadow: 0 0 1.5px 0px #b9b9b9;
	}
	.id-card-back {
	transform: rotateY(180deg);
	}
	.header img {
	width: 100px;
	margin-top: 15px;
	}
	.photo img {
	width: 80px;
	margin-top: 15px;
	border-radius: 50%;
	border: 1px solid #ddd;
	}
	h2 {
	font-size: 15px;
	margin: 5px;
	display: flex;
	justify-content: center;
	}
	h3 {
	font-size: 12px;
	margin: 8px 5px !important;
	font-weight: 300;
	display: flex;
	justify-content: space-between;
	}
	.qr-code img {
	width: 50px;
	}
	p {
	font-size: 10px;
	margin: 2px;
	line-height: 20px;
	}
</style>
<div class="main_id_card">
	<p style="font-size: 16px; margin: 10px auto 0 auto; font-style: italic; color: #333; text-align: center; width: 40%; padding: 5px 20px;">
		Tap or scan the QR code above using any standard scanner app to verify this ID or access admin information.
	</p>
	<div class="id-card-tag mt-5"></div>
	<div class="id-card-tag-strip"></div>
	<div class="id-card-hook"></div>
	<div class="id-card-wrapper">
		<div class="id-card-holder" onclick="this.classList.toggle('flipped')">
			<div class="id-card-front">
				<div class="header">
					<img src="{{ asset($websiteLogo) }}" />
				</div>
				<div class="photo">
					<img src="{{ asset($admin->image) }}" />
				</div>
				<h2> {{ $admin->name }}</h2>
				<h3><strong>Profile:</strong> {{ $admin->name }}</h3>
				<h3><strong>Designation:</strong> {{ $admin->role->name }}</h3>
				<h3><strong>ID:</strong> {{ $admin->id }}</h3>
				<h3><strong>Blood Group:</strong> {{ $admin->blood_group }}</h3>
				<h3><strong>Mobile:</strong> {{ $admin->mobile_no }}</h3>
				<h3><strong>Email:</strong> {{ $admin->email }}</h3>
			</div>
			<div class="id-card-back">
				<h2>Scan QR Code</h2>
				<img src="{{  asset($admin->qr_code_path) }}" alt="Barcode">
				<p style="font-size: 12px; margin-top:10px;">Scan this code to verify identity</p>
				<hr />
				<p>House No. 81 Village Shimla Moulana Post office Chandoli District Panipat Panipat HARYANA 132103</p>
				<p>Ph: 9053903100</p>
			</div>
		</div>
	</div>
</div>
@endsection