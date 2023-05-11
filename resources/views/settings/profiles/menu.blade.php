<ul class="nav nav-pills flex-column flex-md-row mb-4">
    <li class="nav-item"><a class="nav-link {{ Route::currentRouteNamed('profiles.account') ?  'active' : '' }}" href="{{ route('profiles.account') }}"><i class="ti-xs ti ti-users me-1"></i> Account</a></li>
    <li class="nav-item"><a class="nav-link {{ Route::currentRouteNamed('profiles.security') ?  'active' : '' }}" href="{{ route('profiles.security') }}"><i class="ti-xs ti ti-lock me-1"></i> Security</a></li>
    @can('RX Setup')
    <li class="nav-item"><a class="nav-link  {{ Route::currentRouteNamed('settings.organization') ?  'active' : '' }}" href="{{ route('settings.organization') }}"><i class="ti-xs ti ti-building-hospital me-1"></i> Organization</a></li>
    <li class="nav-item"><a class="nav-link {{ Route::currentRouteNamed('settings.emr') ?  'active' : '' }}" href="{{ route('settings.emr') }}"><i class="ti-xs ti ti-stethoscope me-1"></i> EMR</a></li>
    <li class="nav-item"><a class="nav-link {{ Route::currentRouteNamed('settings.print') ?  'active' : '' }}" href="{{ route('settings.print') }}"><i class="ti-xs ti ti-printer me-1"></i> Print</a></li>
    @endcan
</ul>