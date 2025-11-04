@php use Illuminate\Support\Facades\Auth;@endphp
<div id="scrollbar">
    <div class="container-fluid">
        <div id="two-column-menu">
        </div>
        <ul class="navbar-nav" id="navbar-nav">
            <li class="menu-title"><span data-key="t-menu">Menu</span></li>

            <li class="nav-item">
                <a class="nav-link menu-link {{ request()->routeIs('member.dashboard') ? 'active' : '' }}" href="{{ route('member.dashboard') }}">
                    <i class="mdi mdi-speedometer"></i> <span data-key="t-dashboards">Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('member.profile') }}" class="nav-link {{ request()->routeIs('member.profile') ? 'active' : '' }}">
                    <i class="mdi mdi-account"></i> Profile
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('member.change-password') }}" class="nav-link {{ request()->routeIs('member.change-password') ? 'active' : '' }}">
                    <i class="fas fa-key"></i> Change password
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('member.payment') }}" class="nav-link {{ request()->routeIs('member.payment') ? 'active' : '' }}">
                    <i class="mdi mdi-credit-card"></i> Payment
                </a>
            </li>

            @php
                $taskActive = request()->routeIs('member.task-list') || request()->routeIs('member.reject-task-list') || request()->routeIs('member.task-update');
            @endphp
            <li class="nav-item">
                <a class="nav-link menu-link {{ $taskActive ? 'active' : '' }}" href="#tasks" data-bs-toggle="collapse" role="button"
                    aria-expanded="{{ $taskActive ? 'true' : 'false' }}" aria-controls="tasks">
                    <i class="mdi mdi-clipboard-list"></i> <span data-key="t-maps">Manage Task</span>
                </a>
                <div class="collapse menu-dropdown {{ $taskActive ? 'show' : '' }}" id="tasks">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a href="{{ route('member.task-list') }}" class="nav-link {{ request()->routeIs('member.task-list','member.task-update') ? 'active' : '' }}" data-key="t-google">
                                Task List
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('member.reject-task-list') }}" class="nav-link {{ request()->routeIs('member.reject-task-list') ? 'active' : '' }}" data-key="t-vector">
                                Reject Task List
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a href="{{ route('member.referral-list') }}" class="nav-link {{ request()->routeIs('member.referral-list') ? 'active' : '' }}">
                    <i class="mdi mdi-account-multiple-plus"></i> Referral
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('member.enrool-student') }}" class="nav-link {{ request()->routeIs('member.enrool-student') ? 'active' : '' }}">
                    <i class="mdi mdi-chart-line"></i> Enroll Student
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('member.tickets.view') }}" class="nav-link {{ request()->routeIs('member.tickets.view') ? 'active' : '' }}">
                    <i class="mdi mdi-chart-line"></i> Support Ticket 
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('member.donation-detail') }}" class="nav-link {{ request()->routeIs('member.donation-detail') ? 'active' : '' }}">
                    <i class="mdi mdi-bank"></i> Transparency & Financial Accountability
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('member.achievement') }}" class="nav-link {{ request()->routeIs('member.achievement') ? 'active' : '' }}">
                    <i class="mdi mdi-trophy"></i> Earn & Share Achievements
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('member.social-point') }}" class="nav-link {{ request()->routeIs('member.social-point') ? 'active' : '' }}">
                    <i class="mdi mdi-podium"></i> Social Points & Leaderboard
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="mdi mdi-certificate"></i> Automatic 80G Certificate
                </a>
            </li>
</ul>


    </div>
</div>