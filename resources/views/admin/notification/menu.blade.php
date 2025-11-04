<div class="card">
            <div class="card-header">
                <div class="mail-menu d-block d-sm-flex gap-5">
                    <div class="d-flex gap-2 align-items-center pointer my-2 my-sm-0" >
                        <img src="{{ asset('admin/assets/img/bell.png') }}">
                        <a href="{{ route('admin.notification') }}" class="fs-sm-5 fs-6" 
                           style="color: {{ Request::routeIs('admin.notification') ? 'gray' : '#d56337' }};
                                  padding: 0 20px 5px 15px; 
                                  text-decoration: none;
                                  font-weight: {{ Request::routeIs('admin.notification') ? 'bold' : 'normal' }};
                                  display: inline-block;
                                  
                                  border-bottom: {{ Request::routeIs('admin.notification') ? '2px solid #6c757d' : 'none' }};">
                            Student Notification
                        </a>
                    </div>
                    <div class="d-flex gap-2 align-items-center pointer my-2 my-sm-0" >
                        <img src="{{ asset('admin/assets/img/notification-bell.png') }}">
                        <a href="{{ route('admin.college-member-notification') }}"
                        class="fs-sm-5 fs-6" 
                           style="color: {{ Request::routeIs('admin.college-member-notification') ? 'gray' : '#d56337' }};
                                  padding: 0 20px 5px 15px; 
                                  text-decoration: none;
                                  font-weight: {{ Request::routeIs('admin.college-member-notification') ? 'bold' : 'normal' }};
                                  display: inline-block;
                                 
                                  border-bottom: {{ Request::routeIs('admin.college-member-notification') ? '2px solid #6c757d' : 'none' }};">
                            College Member Notification
                        </a>
                    </div>
                </div>
            </div>
        </div>