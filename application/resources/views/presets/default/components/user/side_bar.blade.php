@php
    $user = auth()->user();
@endphp

<!--==========================   User-sidebar Start  ==========================-->
<div class="dashboard__sidebar">
    <div class="sidebar__close">
        <i class="las la-times"></i>
    </div>
    <div class="dashboard__logo">
        <a href="{{ route('home') }}">
            <img src="{{ getImage(getFilePath('logoIcon') . '/logo_white.png', '?' . time()) }}"
                alt="{{ config('app.name') }}">
        </a>
    </div>
    <div class="dashboard__menu">
        <ul>
            <li>
                <a href="{{ route('user.home') }}" class="{{ Route::is('user.home') ? 'active' : '' }}">
                    <span class="link__icon">
                        <i class="fa-solid fa-table-columns"></i>
                    </span>
                    @lang('Dashboard')
                </a>
            </li>

            <li>
                <a href="#my-logos"
                    class="{{ Route::is('user.logo.index') ||
                    Route::is('user.logo.view') ||
                    
                    Route::is('user.logo.answer.detail')
                        ? 'active'
                        : 'collapsed' }}"
                    data-bs-toggle="collapse" role="button"
                    aria-expanded="{{ Route::is('user.logo.index')  || Route::is('user.logo.view') || Route::is('logo.details') || Route::is('user.logo.create') ? 'true' : 'false' }}"
                    aria-controls="my-logos">
                    <span class="link__icon">
                        <i class="fa-brands fa-font-awesome"></i>
                    </span>
                    @lang('Logos')
                    <span class="dropdown__arrow">
                        <i class="fa-solid fa-chevron-right"></i>
                    </span>
                </a>
                <div class="collapse {{ Route::is('user.logo.index') || Route::is('user.logo.view') || Route::is('logo.details') || Route::is('user.logo.create') ? 'show' : '' }}"
                    id="my-logos">
                    <div class="sidebar__dropdown">
                        <ul>
                            <li>
                                <a href="{{ route('user.logo.create') }}"
                                    class="{{ Route::is('user.logo.create') || Route::is('logo.details') ? 'active' : '' }}">
                                    <span class="link__icon">
                                        <i class="fa-brands fa-font-awesome"></i>
                                    </span>
                                    @lang('Create Logo')
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('user.logo.index') }}"
                                    class="{{ Route::is('user.logo.index') || Route::is('user.logo.view') ? 'active' : '' }}">
                                    <span class="link__icon">
                                        <i class="fa-solid fa-indent"></i>
                                    </span>
                                    @lang('My logo List')
                                </a>
                            </li>
                           
                        </ul>
                    </div>
                </div>
            </li>

            <li>
                <a href="#payments"
                    class="{{ Route::is('user.credit.purchase') || Route::is('user.deposit') || Route::is('user.deposit.history') ? 'active' : 'collapsed' }}"
                    data-bs-toggle="collapse" role="button"
                    aria-expanded="{{ Route::is('user.credit.purchase')|| Route::is('user.deposit') || Route::is('user.deposit.history') ? 'true' : 'false' }}"
                    aria-controls="payments">
                    <span class="link__icon">
                        <i class="fa-solid fa-money-bills"></i>
                    </span>
                    @lang('Payments')
                    <span class="dropdown__arrow"><i class="fa-solid fa-chevron-right"></i></span></a>
                <div class="collapse {{ Route::is('user.credit.purchase') || Route::is('user.deposit.history') ? 'show' : '' }}"
                    id="payments">
                    <div class="sidebar__dropdown">
                        <ul>
                            <li>
                                <a href="{{ route('user.credit.purchase') }}"
                                    class="{{ Route::is('user.credit.purchase') ? 'active' : '' }}">
                                    <span class="link__icon">
                                        <i class="fa-solid fa-coins"></i>
                                    </span>
                                    @lang('Credit Purchase')
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('user.deposit') }}"
                                    class="{{ Route::is('user.deposit') ? 'active' : '' }}">
                                    <span class="link__icon">
                                        <i class="fa-solid fa-coins"></i>
                                    </span>
                                    @lang('Deposit')
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('user.deposit.history') }}"
                                    class="{{ Route::is('user.deposit.history') ? 'active' : '' }}">
                                    <span class="link__icon">
                                        <i class="fa-solid fa-money-bill-1-wave"></i>
                                    </span>
                                    @lang('Payments History')
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>

            <li>
                <a href="{{ route('user.transactions') }}"
                    class="{{ Route::is('user.transactions') ? 'active' : '' }}">
                    <span class="link__icon">
                        <i class="fa-solid fa-right-left"></i>
                    </span>
                    @lang('Transactions')
                </a>
            </li>
            <li>
                <a href="{{ route('ticket') }}" class="{{ Route::is('ticket') ? 'active' : '' }}">
                    <span class="link__icon">
                        <i class="fa-solid fa-ticket"></i>
                    </span>
                    @lang('Support Tickets')
                </a>
            </li>
            <li>
                <a href="{{ route('user.change.password') }}"
                    class="{{ Route::is('user.change.password') ? 'active' : '' }}">
                    <span class="link__icon">
                        <i class="fa-solid fa-key"></i>
                    </span>
                    @lang('Change Password')
                </a>
            </li>
            <li>
                <a href="{{ route('user.profile.setting') }}"
                    class="{{ Route::is('user.profile.setting') ? 'active' : '' }}">
                    <span class="link__icon">
                        <i class="fa-solid fa-screwdriver-wrench"></i>
                    </span>
                    @lang('Profile Setting')</a>
            </li>
            <li>
                <a href="{{ route('user.twofactor') }}" class="{{ Route::is('user.twofactor') ? 'active' : '' }}">
                    <span class="link__icon">
                        <i class="fa-solid fa-diagram-project"></i>
                    </span>
                    @lang('2FA Security')
                </a>
            </li>

            <li>
                <a href="{{ route('user.logout') }}">
                    <span class="link__icon">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </span>
                    @lang('Logout')
                </a>
            </li>
        </ul>
    </div>
</div>
<!--==========================  User-sidebar End  ==========================-->
