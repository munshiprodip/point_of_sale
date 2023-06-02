<ul class="nav nav-pills flex-column flex-md-row mb-4">
    <li class="nav-item"><a class="nav-link {{ Route::currentRouteNamed('profiles.account') ?  'active' : '' }}" href="{{ route('profiles.account') }}"><i class="ti-xs ti ti-users me-1"></i> Account</a></li>
    <li class="nav-item"><a class="nav-link {{ Route::currentRouteNamed('profiles.security') ?  'active' : '' }}" href="{{ route('profiles.security') }}"><i class="ti-xs ti ti-lock me-1"></i> Security</a></li>
</ul>