<ul class="nav nav-tabs mb-4 border-bottom">
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.member.member-info') ? 'active' : '' }}" href="{{ route('admin.member.member-info', encrypt($member->id)) }}">Member Info</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.member.member-donation-online') ? 'active' : '' }}" href="{{ route('admin.member.member-donation-online', encrypt($member->id)) }}">Donation</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.member.member-task') ? 'active' : '' }}" href="{{ route('admin.member.member-task', encrypt($member->id)) }}">Task</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.member.member-refferal') ? 'active' : '' }}" href="{{ route('admin.member.member-refferal', encrypt($member->id)) }}">Referral</a>
    </li>
</ul>
