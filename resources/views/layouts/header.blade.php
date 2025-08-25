<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center bg-genix">
        <a class="navbar-brand brand-logo mr-5" href="{{ route('dashboard') }}"><img
                src="{{ file_url(support_setting('main_logo')) }}" class="mr-2" alt="logo" /></a>
        <a class="navbar-brand brand-logo-mini" href="{{ route('dashboard') }}"><img
                src="{{ file_url(support_setting('small_logo')) }}" alt="logo" /></a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end bg-genix">
        <button class="navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="icon-menu"></span>
        </button>

        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                    <img src="{{ asset('assets/images/user.png') }}" alt="profile" />
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                    <a href="{{ route('account') }}" class="dropdown-item">
                        <i class="ti-settings text-primary"></i>
                        {{ trans('general.my_account') }}
                    </a>
                    <a class="dropdown-item" href="javascript:void(0)"
                        onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                        <i class="ti-power-off text-primary"></i>
                        {{ trans('general.logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                    {{ app()->getLocale() }}
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown">
                    @foreach ($languages as $code => $lang)
                        <a href="{{ route('lang', $code) }}" class="dropdown-item">
                            {{ trans('general.' . $code) }}
                        </a>
                    @endforeach
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
            data-toggle="offcanvas">
            <span class="icon-menu"></span>
        </button>
    </div>
</nav>
