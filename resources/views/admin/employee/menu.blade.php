<ul class="nav nav-tabs mb-4 border-bottom">
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.employee.view') ? 'active' : '' }}" href="{{ route('admin.employee.view', ['id' => encrypt($admin->id)]) }}">Member Info</a>
    </li>  
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.employee.referral') ? 'active' : '' }}" href="{{ route('admin.employee.referral', ['id' => encrypt($admin->id)]) }}">Referral</a>
    </li>
</ul>
