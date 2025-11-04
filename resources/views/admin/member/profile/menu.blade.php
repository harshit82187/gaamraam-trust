<div class="card">
    <div class="card-header">
        <div class="mail-menu" style="display: flex; gap: 20px;">
            <div style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                <img src="{{ asset('admin/assets/img/user-1.png') }}">
                <a href="{{ route('admin.member.indian-list') }}" 
                    style=" {{ Request::routeIs('admin.member.indian-list') ? 'gray' : '#d56337' }};
                            
                            text-decoration: none;
                            font-weight: {{ Request::routeIs('admin.member.indian-list') ? 'bold' : 'normal' }};
                            display: inline-block;
                        
                            border-bottom: {{ Request::routeIs('admin.member.indian-list') ? '2px solid #6c757d' : 'none' }};">
                    Indian Member
                </a>
            </div>
            @if($admin->admin_role_id != 8)
            <div style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                <img src="{{ asset('admin/assets/img/user-2.png') }}" >
                <a href="{{ route('admin.member.nri-list') }}" 
                    style="color: {{ Request::routeIs('admin.member.nri-list') ? 'gray' : '#d56337' }};
                            
                            text-decoration: none;
                            font-weight: {{ Request::routeIs('admin.member.nri-list') ? 'bold' : 'normal' }};
                            display: inline-block;
                            
                            border-bottom: {{ Request::routeIs('admin.member.nri-list') ? '2px solid #6c757d' : 'none' }};">
                    NRI Member
                </a>
            </div>
            @endif
        </div>
    </div>
</div>