<ul class="nav">
    <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="bi bi-speedometer2 menu-icon"></i>
            <span class="menu-title">{{ trans('general.dashboard') }}</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('garage.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('garage.index') }}">
            <i class="bi bi-car-front menu-icon"></i>
            <span class="menu-title">{{ trans('general.view_garage') }}</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('memberships.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('memberships.index') }}">
            <i class="bi bi-box-seam menu-icon"></i>
            <span class="menu-title">{{ trans('general.membership') }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
            <i class="icon-layout menu-icon"></i>
            <span class="menu-title">{{ trans('general.book_a_service') }}</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-basic">
            <ul class="nav flex-column sub-menu">
                @if (garage()?->is_mot && is_uk())
                    <li class="nav-item"> <a class="nav-link"
                            href="{{ route('mots.index') }}">{{ trans('general.mots') }}</a></li>
                @endif
                @if (garage()?->is_services)
                    <li class="nav-item"> <a class="nav-link"
                            href="{{ route('services.index') }}">{{ trans('general.services') }}</a></li>
                @endif
                @if (garage()?->is_repairs)
                    <li class="nav-item"> <a class="nav-link"
                            href="{{ route('repairs.index') }}">{{ trans('general.repairs') }}</a></li>
                @endif
                <li class="nav-item"> <a class="nav-link"
                        href="{{ route('recoveries.index') }}">{{ trans('general.recoveries') }}</a></li>
            </ul>
        </div>
    </li>

    <li class="nav-item {{ request()->routeIs('marketplace.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('marketplace.index') }}">
            <i class="bi bi-shop menu-icon"></i>
            <span class="menu-title">{{ trans('general.marketplace') }}</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('communities.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('communities.index') }}">
            <i class="bi bi bi-chat-square-text menu-icon"></i>
            <span class="menu-title">{{ trans('general.community') }}</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('supports.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('supports.index') }}">
            <i class="bi bi-ticket-perforated menu-icon"></i>
            <span class="menu-title">{{ trans('general.support_tickets') }}</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('notification') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('notification') }}">
            <i class="bi bi-bell menu-icon"></i>
            <span class="menu-title">{{ trans('general.notifications') }}</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('selected') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('selected') }}">
            <i class="bi bi-check-circle menu-icon"></i>
            <span class="menu-title">{{ trans('general.selected_garage') }}</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('account') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('account') }}">
            <i class="bi bi-person menu-icon"></i>
            <span class="menu-title">{{ trans('general.account') }}</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('feedback.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('feedback.index') }}">
            <i class="bi bi-chat-left-text menu-icon"></i>
            <span class="menu-title">{{ trans('general.feedback') }}</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="javascript:void(0)"
            onclick="event.preventDefault();
        document.getElementById('logout-form').submit();">
            <i class="ti-power-off menu-icon"></i>
            <span class="menu-title">{{ trans('general.logout') }}</span>
        </a>
    </li>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

</ul>
