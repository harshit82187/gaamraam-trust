<div class="card" style="border-radius: 5px;box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;">
	<div class="card-header" style="display: flex; justify-content: start; align-items: center;padding:15px 25px !important;">
        <ul class="website-setting-menu p-0">
            <li><a href="{{ route('admin.social-pages.website-profile') }}" class="{{ Request::routeIs('admin.social-pages.website-profile') ? 'active' : '' }} text-nowrap" style="color: {{ Request::routeIs('admin.social-pages.website-profile') ? 'gray' : '#d56337' }};">Website Setting</a></li>
            <li><a href="{{ route('admin.social-pages.social-media-chat') }}" class="{{ Request::routeIs('admin.social-pages.social-media-chat') ? 'active' : '' }} text-nowrap" style="color: {{ Request::routeIs('admin.social-pages.social-media-chat') ? 'gray' : '#d56337' }};">Whatsapp</a></li>
            <li><a href="{{ route('admin.social-pages.mail-configuration') }}" class="{{ Request::routeIs('admin.social-pages.mail-configuration') ? 'active' : '' }} text-nowrap" style="color: {{ Request::routeIs('admin.social-pages.mail-configuration') ? 'gray' : '#d56337' }};">Mail Config</a></li>
             <li><a href="{{ route('admin.social-pages.accessories') }}" class="{{ Request::routeIs('admin.social-pages.accessories') ? 'active' : '' }} text-nowrap" style="color: {{ Request::routeIs('admin.social-pages.accessories') ? 'gray' : '#d56337' }};">Accessories</a></li>
            <li><a href="{{ route('admin.social-pages.social-media') }}" class="{{ Request::routeIs('admin.social-pages.social-media') ? 'active' : '' }} text-nowrap" style="color: {{ Request::routeIs('admin.social-pages.social-media') ? 'gray' : '#d56337' }};">Social Media</a></li>
            <li><a href="{{ route('admin.social-pages.privacy-policy') }}" class="{{ Request::routeIs('admin.social-pages.privacy-policy') ? 'active' : '' }} text-nowrap" style="color: {{ Request::routeIs('admin.social-pages.privacy-policy') ? 'gray' : '#d56337' }}; ">Privacy Policy</a></li>
            <li><a href="{{ route('admin.social-pages.term-condition') }}" class="{{ Request::routeIs('admin.social-pages.term-condition') ? 'active' : '' }} text-nowrap" style="color: {{ Request::routeIs('admin.social-pages.term-condition') ? 'gray' : '#d56337' }}; ">Term & Condition</a></li>
        </ul>
    </div>
</div>