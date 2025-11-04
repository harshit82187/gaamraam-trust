<div id="scrollbar">
	<div class="container-fluid">
		<div id="two-column-menu">
		</div>
		<ul class="navbar-nav" id="navbar-nav">
			<li class="menu-title"><span data-key="t-menu">Menu</span></li>
	
			<li class="nav-item">
				<a class="nav-link menu-link" href="{{ route('student.dashboard') }}">
				<i class="mdi mdi-speedometer"></i> <span data-key="t-dashboards">Dashboard</span>
				</a>
			</li>
			<li class="nav-item">
				<a href="{{ route('student.profile') }}" class="nav-link menu-link {{ request()->routeIs('student.profile') ? 'active' : '' }}">
					<i class="fas fa-user"></i> 
					<span data-key="t-users">Profile</span>
				</a>
			</li>
			<li class="nav-item">
				<a href="{{ route('student.document-list') }}" class="nav-link menu-link {{ request()->routeIs('student.document-list') ? 'active' : '' }}">
					<i class="fas fa-file-alt"></i> 
					<span data-key="t-users">Document</span>
				</a>
			</li>

			<li class="nav-item">
                <a class="nav-link menu-link {{ request()->routeIs('student.test-series-list') || request()->routeIs('student.attempt-test-list') ? 'active' : '' }}" href="#testSeries" data-bs-toggle="collapse" role="button"
                    aria-expanded="true" aria-controls="testSeries">
                    <i class="fas fa-pen-alt"></i> <span data-key="t-maps">Test Series</span>
                </a>
                <div class="collapse menu-dropdown" id="testSeries">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a href="{{ route('student.test-series-list') }}" class="nav-link {{ request()->routeIs('student.test-series-list') ? 'active' : '' }}" data-key="t-google">
								Test Series List
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('student.attempt-test-list') }}" class="nav-link {{ request()->routeIs('student.attempt-test-list') ? 'active' : '' }}" data-key="t-vector">
								Attempted Tests
                            </a>
                        </li>
                       
                    </ul>
                </div>
            </li>

			<li class="nav-item">
				<a href="{{ route('student.notification') }}" class="nav-link menu-link {{ request()->routeIs('student.notification') ? 'active' : '' }}">
					<i class="fas fa-bell"></i> 
					<span data-key="t-users">Notification</span>
				</a>
			</li>
			@if(!empty(auth()->guard('student')->user()->student_id))
			<li class="nav-item">
				<a href="{{ route('student.student-id-card') }}" class="nav-link menu-link {{ request()->routeIs('student.notification') ? 'active' : '' }}">
					<i class="fas fa-id-card"></i> 
					<span data-key="t-users">Student ID card</span>
				</a>
			</li>
			@endif

			<li class="nav-item">
				<a href="{{ route('student.change-password') }}" class="nav-link menu-link {{ request()->routeIs('student.change-password') ? 'active' : '' }}">
					<i class="fas fa-key"></i>
					<span data-key="t-users">Change password</span>
				</a>
			</li>

			<li class="nav-item">
				<a href="{{ route('student.tickets.view') }}" class="nav-link menu-link {{ request()->routeIs('student.tickets.view') ? 'active' : '' }}">
					<i class="fas fa-lock"></i>
					<span data-key="t-users">Support Ticket</span>
				</a>
			</li>
		</ul>
	</div>
	<!-- Sidebar -->
</div>