<nav class="au-partner-navigation">
    <div class="au-partner-wrapper">
        <!-- Logo Header -->
        <div class="au-partner-logo-header">
            <a href="{{ route('partner.dashboard') }}" class="au-partner-brand">
                @if(auth()->user()->funderPortal && auth()->user()->funderPortal->hasLogo())
                    <img src="{{ auth()->user()->funderPortal->getLogoUrl() }}"
                         alt="{{ auth()->user()->funderPortal->name }}"
                         class="au-partner-logo-lg">
                    <img src="{{ auth()->user()->funderPortal->getLogoUrl() }}"
                         alt="{{ auth()->user()->funderPortal->name }}"
                         class="au-partner-logo-sm">
                @else
                    <img src="{{ asset('assets/images/au.png') }}" alt="AU Logo" class="au-partner-logo-lg">
                    <img src="{{ asset('assets/images/au.png') }}" alt="AU Logo" class="au-partner-logo-sm">
                @endif
            </a>
        </div>

        <div class="au-partner-content">
            <!-- User Profile Section -->
            <div class="au-partner-profile">
                <div class="au-partner-avatar">
                    <i class="feather-user"></i>
                </div>
                <div class="au-partner-info">
                    <h6 class="au-partner-name">{{ auth()->user()->name }}</h6>
                    <p class="au-partner-org">{{ auth()->user()->funderPortal->name ?? 'Partner' }}</p>
                </div>
            </div>

            <hr class="au-partner-divider">

            <ul class="au-partner-menu">
                <!-- Dashboard Section -->
                <li class="au-partner-menu-caption">
                    <span>{{ __('partner.portal') }}</span>
                </li>

                <li class="au-partner-menu-item {{ request()->routeIs('partner.dashboard') ? 'au-active' : '' }}">
                    <a href="{{ route('partner.dashboard') }}" class="au-partner-menu-link">
                        <span class="au-partner-icon"><i class="feather-home"></i></span>
                        <span class="au-partner-text">{{ __('partner.dashboard') }}</span>
                    </a>
                </li>

                <!-- Funded Programs -->
                @can('partner.programs.view')
                    <li class="au-partner-menu-item {{ request()->routeIs('partner.programs.index') ? 'au-active' : '' }}">
                        <a href="{{ route('partner.programs.index') }}" class="au-partner-menu-link">
                            <span class="au-partner-icon"><i class="feather-folder"></i></span>
                            <span class="au-partner-text">{{ __('partner.funded_programs') }}</span>
                        </a>
                    </li>
                @endcan

                <!-- Program Insights -->
                @can('partner.programs.view')
                    <li class="au-partner-menu-item {{ request()->routeIs('partner.insights') ? 'au-active' : '' }}">
                        <a href="{{ route('partner.insights') }}" class="au-partner-menu-link">
                            <span class="au-partner-icon"><i class="feather-bar-chart-2"></i></span>
                            <span class="au-partner-text">{{ __('partner.program_insights') }}</span>
                        </a>
                    </li>
                @endcan

                <!-- Communication Section -->
                <li class="au-partner-menu-caption">
                    <span>{{ __('partner.communication') }}</span>
                </li>

                @can('partner.requests.view')
                    <li
                        class="au-partner-menu-item {{ request()->routeIs('partner.requests.index') || request()->routeIs('partner.requests.show') ? 'au-active' : '' }}">
                        <a href="{{ route('partner.requests.index') }}" class="au-partner-menu-link">
                            <span class="au-partner-icon"><i class="feather-message-circle"></i></span>
                            <span class="au-partner-text">{{ __('partner.my_requests') }}</span>
                            @php
                                $pendingCount =
                                    auth()
                                        ->user()
                                        ->funderPortal?->informationRequests()
                                        ->where('status', 'pending')
                                        ->count() ?? 0;
                            @endphp
                            @if ($pendingCount > 0)
                                <span class="au-partner-badge">{{ $pendingCount }}</span>
                            @endif
                        </a>
                    </li>
                @endcan

                @can('partner.requests.create')
                    <li
                        class="au-partner-menu-item {{ request()->routeIs('partner.requests.create') ? 'au-active' : '' }}">
                        <a href="{{ route('partner.requests.create') }}" class="au-partner-menu-link">
                            <span class="au-partner-icon"><i class="feather-plus-circle"></i></span>
                            <span class="au-partner-text">{{ __('partner.new_request') }}</span>
                        </a>
                    </li>
                @endcan

                <!-- Account Section -->
                <li class="au-partner-menu-caption">
                    <span>{{ __('partner.account') }}</span>
                </li>

                <li class="au-partner-menu-item {{ request()->routeIs('partner.profile.edit') ? 'au-active' : '' }}">
                    <a href="{{ route('partner.profile.edit') }}" class="au-partner-menu-link">
                        <span class="au-partner-icon"><i class="feather-settings"></i></span>
                        <span class="au-partner-text">{{ __('partner.profile_settings') }}</span>
                    </a>
                </li>
            </ul>

            <!-- Logout Button -->
            <div class="au-partner-footer">
                <form method="POST" action="{{ route('logout') }}" class="w-100">
                    @csrf
                    <button type="submit" class="au-partner-logout-btn">
                        <i class="feather-log-out me-2"></i>
                        {{ __('partner.logout') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
