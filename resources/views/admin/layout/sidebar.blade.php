@php  $permissions = session('role_permissions', []);
	  $admin = \App\Models\Admin::find(session('admin_id'));
@endphp

<div class="sidebar" data-background-color="dark">
	<div class="sidebar-logo">
		<!-- Logo Header -->
		<div class="logo-header" data-background-color="dark" style="background:white;">
			<a href="{{ url('/') }}" target="_blank" class="logo">
			<img src="{{ asset('front/images/Gaam_Raam_logo.png') }}"	alt="navbar brand"	class="navbar-brand" height="50"/></a>
			<div class="nav-toggle"><button class="btn btn-toggle toggle-sidebar"><i class="gg-menu-right"></i>	</button>
				<button class="btn btn-toggle sidenav-toggler"><i class="gg-menu-left"></i></button>
			</div>
			<button class="topbar-toggler more"><i class="gg-more-vertical-alt"></i></button>
		</div>
		<!-- End Logo Header -->
	</div>
	<div class="sidebar-wrapper scrollbar scrollbar-inner">
		<div class="sidebar-content">
			<div class="search_field">
				<i class="fa-solid fa-magnifying-glass"></i>
				<input type="text" id="sidebar-search" placeholder="Search menu...">
			</div>
			<ul class="nav nav-secondary">
				@if(in_array('dashboard', $permissions))
				<li class="nav-item active" data-name="dashboard">
					<a	href="{{ route('admin.dashboard') }}"	aria-expanded="false">
						<i class="fas fa-home"></i>	<p>Dashboard</p>						
					</a>					
				</li>
				@endif

				@if(in_array('manage_student', $permissions))
				<li class="nav-item {{ request()->routeIs('admin.enrool-student','admin.enrool-student-info','admin.student-bulk-import','admin.student.document','admin.student.create') ? 'active' : '' }}" data-name="member member list member info member donation member task member referral">
					<a data-bs-toggle="collapse" href="#students">
						<i class="fas fa-user-plus"></i>
						<p>Manage Student</p>
						<span class="caret"></span>
					</a>
					<div class="collapse  {{ request()->routeIs('admin.enrool-student','admin.enrool-student-info','admin.student-bulk-import','admin.student.document','admin.student.create') ? 'show' : '' }}"  id="students">
						<ul class="nav nav-collapse ">
							<li class="{{ request()->routeIs('admin.enrool-student','admin.enrool-student-info','') ? 'active' : '' }}">
								<a href="{{ route('admin.enrool-student') }}">
									<i class="fas fa-users mr-2"></i>Student List</a>
							</li>
							<li class="{{ request()->routeIs('admin.student.create') ? 'active' : '' }}">
								<a href="{{ route('admin.student.create') }}">
									<i class="fas fa-user-plus mr-2"></i>Student Add									
								</a>
							</li>
							<li class="{{ request()->routeIs('admin.student-bulk-import') ? 'active' : '' }}">
								<a href="{{ route('admin.student-bulk-import') }}">
									<i class="fas fa-file-import mr-2"></i>Bulk Import
								</a>
							</li>
							<li class="{{ request()->routeIs('admin.student.document','admin.member.member-info') ? 'active' : '' }}">
								<a href="{{ route('admin.student.document') }}">
									<i class="fas fa-file-alt mr-2"></i>Student Document
								</a>
							</li>
						</ul>
					</div>
				</li>
				@endif			
			

				@if($admin->id == 1)
				<li class="nav-item {{ request()->routeIs('admin.custom-role.add','admin.employee.referral','admin.custom-role.edit','admin.employee.add','admin.employee.view','admin.sarpanch.view','admin.sarpanch.view-follow-up') ? 'active' : '' }}" data-name="employee employee role setup import sarpanch">
					<a data-bs-toggle="collapse" href="#employee">
						<i class="fas fa-user-tie"></i>
						<p>Manage Employee</p>
						<span class="caret"></span>
					</a>
					<div class="collapse  {{ request()->routeIs('admin.custom-role.add','admin.employee.referral','admin.custom-role.edit','admin.employee.add','admin.employee.view','admin.sarpanch.view','admin.sarpanch.view-follow-up')  ? 'show' : '' }}"  id="employee">
						<ul class="nav nav-collapse">
							<li class="{{ request()->routeIs('admin.custom-role.add','admin.custom-role.edit') ? 'active' : '' }}" >
								<a href="{{ route('admin.custom-role.add') }}">
								<span class="sub-item">Employee Role Setup</span>
								</a>
							</li>

							<li class="{{ request()->routeIs('admin.employee.add','admin.employee.view','admin.employee.referral') ? 'active' : '' }}" >
								<a href="{{ route('admin.employee.add') }}">
								<span class="sub-item">Employees</span>
								</a>
							</li>

							<li class="{{ request()->routeIs('admin.sarpanch.view','admin.sarpanch.view-follow-up') ? 'active' : '' }}" >
								<a href="{{ route('admin.sarpanch.view') }}">
								<span class="sub-item">Import Sarpanch</span>
								</a>
							</li>
							
						</ul>
					</div>
				</li>
				@endif
				
				@if(in_array('manage_member', $permissions))
				<li class="nav-item {{ request()->routeIs('admin.member.indian-list','admin.member.member-info','admin.member.member-donation','admin.member.member-task','admin.member.member-refferal') ? 'active' : '' }}" data-name="member member list member info member donation member task member referral">
					<a data-bs-toggle="collapse" href="#members">
						<i class="fas fa-id-card"></i>
						<p>Manage Member</p>
						<span class="caret"></span>
					</a>
					<div class="collapse  {{ request()->routeIs('admin.member.indian-list','admin.member.member-info','admin.member.member-donation','admin.member.member-task','admin.member.member-refferal') ? 'show' : '' }}"  id="members">
						<ul class="nav nav-collapse">
							<li class="{{ request()->routeIs('admin.member.indian-list','admin.member.member-info','admin.member.member-donation','admin.member.member-task','admin.member.member-refferal') ? 'active' : '' }}" >
								<a href="{{ route('admin.member.indian-list') }}">
								<span class="sub-item">Member List</span>
								</a>
							</li>
							<li class="{{ request()->routeIs('admin.member.indian-list','admin.member.member-info','admin.member.member-donation','admin.member.member-task','admin.member.member-refferal') ? 'active' : '' }}" >
								<a href="{{ route('admin.member.member-add') }}">
								<span class="sub-item">Member Add</span>
								</a>
							</li>
							
						</ul>
					</div>
				</li>
				@endif

				@if($admin->id == 1 || in_array('follow_up', $permissions))
				<li class="nav-item {{ request()->routeIs('admin.follow-up.view') ? 'active' : '' }}" data-name="follow up">
					<a	href="{{ route('admin.follow-up.view') }}"	aria-expanded="false">
						<i class="fas fa-reply"></i> <p>Follow Up</p>					
					</a>					
				</li>
				@endif

				@if(in_array('donation', $permissions))
				<li class="nav-item {{ request()->routeIs('admin.donation-report') ? 'active' : '' }}" data-name="donation donation report">
					<a data-bs-toggle="collapse" href="#donations">
						<i class="fas fa-gem"></i>
						<p>Donation</p>
						<span class="caret"></span>
					</a>
					<div class="collapse {{ request()->routeIs('admin.member.donation') ? 'show' : '' }}" id="donations">
						<ul class="nav nav-collapse">
							<li class="{{ request()->routeIs('admin.member.donation') ? 'active' : '' }}">
								<a href="{{ route('admin.member.donation') }}">	<span class="sub-item">Add Member Donation</span></a>
							</li>
							<li class="{{ request()->routeIs('admin.donation-report') ? 'active' : '' }}">
								<a href="{{ route('admin.donation-report') }}">	<span class="sub-item">Donation Report</span></a>
							</li>
						</ul>
					</div>
				</li>
				@endif 

				@if(in_array('notification_management', $permissions))
				<li class="nav-item {{ request()->routeIs('admin.notification') ? 'active' : '' }}" data-name="notification management">
					<a href="{{ route('admin.notification') }}">
						<i class="fas fa-bell"></i>
						<p>Notification Management</p>
					</a>				
				</li>
				@endif 

				

				@if(in_array('course_management', $permissions))
				<li class="nav-item {{ request()->routeIs('admin.courses') ? 'active' : '' }}" data-name="course management add course ">
					<a data-bs-toggle="collapse" href="#courses" class="menu-link">
						<i class="fas fa-book-open"></i>
						<p>Course Management</p>
						<span class="caret"></span>
					</a>
					<div class="collapse {{ request()->routeIs('admin.courses') || request()->routeIs('admin.edit-course') ? 'show' : '' }}" id="courses">
						<ul class="nav nav-collapse">
							<li class="{{ request()->routeIs('admin.courses') || request()->routeIs('admin.edit-course') ? 'active' : '' }}">
								<a href="{{ route('admin.courses') }}">
									<span class="sub-item">Add Course</span>
								</a>
							</li>
						</ul>
					</div>
				</li>
				@endif 

				@if(in_array('college_management', $permissions))
				<li class="nav-item {{ request()->routeIs('admin.college-add') ? 'active' : '' }}" data-name="college management college add college list college staff list teacher list">
					<a data-bs-toggle="collapse" href="#collegeManagement">
						<i class="fas fa-university"></i>
						<p>College Management</p>
						<span class="caret"></span>
					</a>
					<div class="collapse {{ request()->routeIs('admin.college-add') || request()->routeIs('admin.college-list') || request()->routeIs('admin.college-staff-list') ? 'show' : '' }}" id="collegeManagement">
						<ul class="nav nav-collapse">
							<li class="{{ request()->routeIs('admin.college-add') ? 'active' : '' }}">
								<a href="{{ route('admin.college-add') }}">
									<i class="fas fa-plus-circle"></i> College Add
								</a>
							</li>

							<li class="{{ request()->routeIs('admin.college-list') ? 'active' : '' }}">
								<a href="{{ route('admin.college-list') }}">
									<i class="fas fa-university"></i> College List
								</a>
							</li>

							<li class="{{ request()->routeIs('admin.college-staff-list') ? 'active' : '' }}">
								<a href="{{ route('admin.college-staff-list') }}">
									<i class="fas fa-user-tie"></i>Staff List
								</a>
							</li>

							<li class="{{ request()->routeIs('admin.teacher.index') ? 'active' : '' }}">
								<a href="{{ route('admin.teacher.index') }}">
									<i class="fas fa-chalkboard-teacher"></i> Teacher List
								</a>
							</li>

							
						</ul>
					</div>
				</li>
				@endif

				<li class="nav-item {{ request()->routeIs('admin.broadcast-list') ? 'active' : '' }}" data-name="follow up">
					<a	href="{{ route('admin.broadcast-list') }}"	aria-expanded="false">
						<i class="fas fa-reply"></i> <p>Broadcast</p>					
					</a>					
				</li>

				@if(in_array('question_bank', $permissions))
				<li class="nav-item {{ request()->routeIs('admin.test-series.list') ? 'active' : '' }}" data-name="question bank add test series add question">
					<a data-bs-toggle="collapse" href="#questions">
						<i class="fas fa-question-circle"></i>
						<p>Question Bank</p>
						<span class="caret"></span>
					</a>
					<div class="collapse  {{ request()->routeIs('admin.test-series.list') || request()->routeIs('admin.question.list') ? 'show' : '' }}"  id="questions">
						<ul class="nav nav-collapse">
							<li class="{{ request()->routeIs('admin.test-series.list') ? 'active' : '' }}" >
								<a href="{{ route('admin.test-series.list') }}">
								<span class="sub-item">Add Test Series</span>
								</a>
							</li>

							<li class="{{ request()->routeIs('admin.question.list') ? 'active' : '' }}" >
								<a href="{{ route('admin.question.list') }}">
								<span class="sub-item">Add Question</span>
								</a>
							</li>
							
						</ul>
					</div>
				</li>
				@endif 

				@if(in_array('manage_task', $permissions))
				<li class="nav-item {{ request()->routeIs('admin.task-list','admin.task-report-check') ? 'active' : '' }}" data-name="manage task add task">
					<a data-bs-toggle="collapse" href="#tasks">
						<i class="fas fa-tasks"></i>
						<p>Manage Task</p>
						<span class="caret"></span>
					</a>
					<div class="collapse  {{ request()->routeIs('admin.task-list','admin.task-report-check') ? 'show' : '' }}" id="tasks">
						<ul class="nav nav-collapse">
							<li class="{{ request()->routeIs('admin.task-list','admin.task-report-check') ? 'active' : '' }}" >
								<a href="{{ route('admin.task-list') }}">
								<span class="sub-item">Add Task</span>
								</a>
							</li>
							
						</ul>
					</div>
				</li>
				@endif

				@if(in_array('trust_setting', $permissions))
				<li class="nav-item {{ request()->routeIs(['admin.social-pages.privacy-policy','admin.social-pages.accessories','admin.social-pages.term-condition','admin.contact-us','admin.social-pages.website-profile','admin.social-pages.social-media-chat','admin.social-pages.mail-configuration','admin.social-pages.social-media']) ? 'active' : '' }}" 
					data-name="trust setting social pages contact us privacy policy accessories term condition website profile social media chat mail configuration social media">
					<a data-bs-toggle="collapse" href="#settings">
						<i class="fas fa-shield-alt"></i>
						<p>Trust Setting</p>
						<span class="caret"></span>
					</a>
					<div class="collapse {{ request()->routeIs(['admin.social-pages.privacy-policy','admin.social-pages.accessories','admin.social-pages.term-condition','admin.social-pages.website-profile','admin.social-pages.social-media-chat','admin.social-pages.mail-configuration','admin.social-pages.social-media']) ? 'show' : '' }}" id="settings">
						<ul class="nav nav-collapse">
							<li class="{{ request()->routeIs(['admin.social-pages.privacy-policy','admin.social-pages.accessories','admin.social-pages.term-condition','admin.social-pages.website-profile','admin.social-pages.social-media-chat','admin.social-pages.mail-configuration','admin.social-pages.social-media']) ? 'active' : '' }}">
								<a href="{{ route('admin.social-pages.website-profile') }}">
								<span class="sub-item">Social Pages</span>
								</a>
							</li>

							<li class="{{ request()->routeIs('admin.contact-us')  ? 'active' : '' }}" >
								<a href="{{ route('admin.contact-us') }}">
								<span class="sub-item">Contact Us</span>
								</a>
							</li>
							
						</ul>
					</div>
				</li>
				@endif

				@if(in_array('log_setting', $permissions))
				<li class="nav-item {{ request()->routeIs('admin.logs-student') ||  request()->routeIs('admin.logs-visitor')  ? 'active' : '' }}" data-name="log setting log details student log visitor log">
					<a data-bs-toggle="collapse" href="#log-details">
						<i class="fas fa-lock"></i>
						<p>Log Details</p>
						<span class="caret"></span>
					</a>
					<div class="collapse  {{ request()->routeIs('admin.logs-student') || request()->routeIs('admin.logs-visitor') ? 'show' : '' }}"  id="log-details">
						<ul class="nav nav-collapse">
							<li class="{{ request()->routeIs('admin.logs-student') || request()->routeIs('admin.logs-visitor') ? 'active' : '' }}" >
								<a href="{{ route('admin.logs-student') }}">
								<span class="sub-item">Student Log </span>
								</a>
							</li>

							<li class="{{ request()->routeIs('admin.logs-visitor')  ? 'active' : '' }}" >
								<a href="{{ route('admin.logs-visitor') }}">
								<span class="sub-item">Visitor Log</span>
								</a>
							</li>
							
						</ul>
					</div>
				</li>
				@endif	

				@if(in_array('support_ticket', $permissions))
				<li class="nav-item {{ request()->routeIs('admin.tickets.list') || request()->routeIs('admin.tickets.info') ||  request()->routeIs('admin/tickets/member')  || request()->routeIs('admin/tickets/college-member') ? 'active' : '' }}" data-name="support ticket support ticket list support ticket info support ticket member support ticket college member ticket">
					<a data-bs-toggle="collapse" href="#support-tickets">
						<i class="fas fa-ticket-alt"></i>
						<p>Support Ticket</p>
						<span class="caret"></span>
					</a>
					<div class="collapse  {{ request()->routeIs('admin.tickets.list') || request()->routeIs('admin.tickets.info') || request()->routeIs('admin/tickets/member') || request()->routeIs('admin/tickets/college-member') ? 'show' : '' }}"  id="support-tickets">
						<ul class="nav nav-collapse">
							<li class="{{ request()->is('admin/tickets/student') ? 'active' : '' }}">
								<a href="{{ route('admin.tickets.list', 'student') }}">
									<span class="sub-item">Student Ticket</span>
								</a>
							</li>

							<li class="{{ request()->is('admin/tickets/member') ? 'active' : '' }}">
								<a href="{{ route('admin.tickets.list', 'member') }}">
									<span class="sub-item">Member Ticket</span>
								</a>
							</li>

							<li class="{{ request()->is('admin/tickets/college-member') ? 'active' : '' }}">
								<a href="{{ route('admin.tickets.list', 'college-member') }}">
									<span class="sub-item">College Member Ticket</span>
								</a>
							</li>
						</ul>

					</div>
				</li>
				@endif


			</ul>
		</div>
	</div>
</div>
@push('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
	const searchInput = document.getElementById('sidebar-search');

	searchInput.addEventListener('input', function () {
		const query = this.value.toLowerCase();
		document.querySelectorAll('.sidebar .nav-item').forEach(function (item) {
			const name = item.getAttribute('data-name') || '';
			if (name.toLowerCase().includes(query)) {
				item.style.display = '';
			} else {
				item.style.display = 'none';
			}
		});
	});
});
</script>
@endpush