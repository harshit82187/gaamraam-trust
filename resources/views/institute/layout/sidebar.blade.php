<div class="sidebar" data-background-color="dark">
	<div class="sidebar-logo">
		<!-- Logo Header -->
		<div class="logo-header" data-background-color="dark" style="background:white;">
			<a href="{{ url('/') }}" target="_blank" class="logo">
			<img
				src="{{ asset('front/images/Gaam_Raam_logo.png') }}"
				alt="navbar brand"
				class="navbar-brand"
				height="50"
				/>
			</a>
			<div class="nav-toggle">
				<button class="btn btn-toggle toggle-sidebar">
				<i class="gg-menu-right"></i>
				</button>
				<button class="btn btn-toggle sidenav-toggler">
				<i class="gg-menu-left"></i>
				</button>
			</div>
			<button class="topbar-toggler more">
			<i class="gg-more-vertical-alt"></i>
			</button>
		</div>
		<!-- End Logo Header -->
	</div>
	<div class="sidebar-wrapper scrollbar scrollbar-inner">
		<div class="sidebar-content">
			<ul class="nav nav-secondary">
				<li class="nav-item active">
					<a	href="{{ route('institute.dashboard') }}"	aria-expanded="false">
						<i class="fas fa-home"></i>	
						<p>Dashboard</p>
					</a>
				</li>
				<li class="nav-item {{ request()->routeIs('institute.enrool-student') ? 'active' : '' }}">
					<a data-bs-toggle="collapse" href="#courses" class="menu-link">
						<i class="fas fa-user-graduate"></i>
						<p>Manage Student</p>
						<span class="caret"></span>
					</a>
					<div class="collapse {{ request()->routeIs('institute.enrool-student') || request()->routeIs('institute.my-disctrict-student') ? 'show' : '' }}" id="courses">
						<ul class="nav nav-collapse">
							<li class="{{ request()->routeIs('institute.enrool-student') ? 'active' : '' }}">
								<a href="{{ route('institute.enrool-student') }}">
								<span class="sub-item">Enroll Student</span>
								</a>
							</li>
							<!-- <li class="{{ request()->routeIs('institute.my-disctrict-student') ? 'active' : '' }}">
								<a href="{{ route('institute.my-disctrict-student') }}">
									<span class="sub-item">My Discrtict Student</span>
								</a>
								</li> -->
						</ul>
					</div>
				</li>
				<li class="nav-item {{ request()->routeIs('institute.student-attendance') ? 'active' : '' }}">
					<a data-bs-toggle="collapse" href="#attendance" class="menu-link">
						<i class="fas fa-calendar-check"></i>
						<p>Manage Attendance</p>
						<span class="caret"></span>
					</a>
					<div class="collapse {{ request()->routeIs('institute.student-attendance')  ? 'show' : '' }}" id="attendance">
						<ul class="nav nav-collapse">
							<li class="{{ request()->routeIs('institute.student-attendance') ? 'active' : '' }}">
								<a href="{{ route('institute.student-attendance') }}">
								<span class="sub-item">Mark Attendance</span>
								</a>
							</li>
						</ul>
					</div>
				</li>
				<li class="nav-item {{ request()->routeIs('institute.notification') ? 'active' : '' }}">
					<a	href="{{ route('institute.notification') }}"	aria-expanded="false">
						<i class="fas fa-bell"></i>	
						<p>Notification</p>
					</a>
				</li>
				<li class="nav-item {{ request()->routeIs('institute.tickets.view') ? 'active' : '' }}">
					<a	href="{{ route('institute.tickets.view') }}"	aria-expanded="false">
						<i class="fas fa-ticket-alt"></i>	
						<p>Support Ticket</p>
					</a>
				</li>
			</ul>
		</div>
	</div>
</div>