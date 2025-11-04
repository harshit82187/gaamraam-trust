
<header id="page-topbar">
	<div class="layout-width">
        
		<div class="navbar-header">
            <div class="date-t-i-m-e" style="padding: 15px; border-radius: 8px;  margin-bottom: 0px; width:81%; font-size: 17px;">			
                <div class="row justify-content-between align-items-center" >
                    <div class="col-md-4 today-date">
                        <span id="current-date">{{ \Carbon\Carbon::now()->format('d-M-Y') }}</span> 
                        <span id="live-time"></span>
                    </div>
                </div>
            </div>

			<div class="d-flex">
				<div class="navbar-brand-box horizontal-logo">
					<a href="{{url('/')}}" target="_blank" class="logo logo-dark">
					<span class="logo-sm">
					<img src="{{ asset('front/images/Gaam_Raam_logo.png') }}" alt="" height="22">
					</span>
					<span class="logo-lg">
					<img src="{{  asset('front/images/Gaam_Raam_logo.png') }}" alt="" height="17">
					</span>
					</a>
				</div>
			</div>
          
			<div class="d-flex align-items-center">
				<div class="dropdown ms-sm-3 header-item topbar-user">
					<button type="button" class="btn shadow-none" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span class="d-flex align-items-center">
					    	@if(Auth::user()->profile_image != null)
							<img class="rounde d-circle header-profile-user" src="{{ asset(Auth::user()->profile_image) }}" alt="Header Avatar">
							@else
							<img class="rounded-circle header-profile-user" src="{{ asset('admin/assets/img/employee.png') }}" alt="Header Avatar">
							@endif
							<span class="text-start ms-xl-2">
								<span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{  Auth::user()->name ?? '' }}</span>
								<!-- <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">Founder</span> -->
							</span>
						</span>
					</button>
					<div class="dropdown-menu dropdown-menu-end" style="width:80%;">
						<h6 class="dropdown-header">Welcome Member!</h6>
						
						<a class="dropdown-item" href="{{ route('member.profile') }}"><i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Profile</span></a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" onclick="logout()" style="cursor: pointer;"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout" >Logout</span></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>
