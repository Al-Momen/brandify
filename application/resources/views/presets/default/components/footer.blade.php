@php
    $contactSection = getContent('contact_us.content', true);
    $socialIcons = getContent('social_icon.element', false);
    $companyLinks = App\Models\Menu::with(['items', 'menuItems'])
        ->where('code', 'company_link')
        ->first();
    $quickLinks = App\Models\Menu::with(['items', 'menuItems'])
        ->where('code', 'important_link')
        ->first();
    $policyLinks = getContent('policy_pages.element', false, null, true);
@endphp

<!-- ==================== Footer Start Here ==================== -->
<footer class="footer__area">
    <div class="footer__area-left">
        <img src="{{ asset($activeTemplateTrue . 'images/shape/footer-left.png') }}" alt="@lang('footer-left')">
    </div>
    <div class="footer__area-right">
        <img src="{{ asset($activeTemplateTrue . 'images/shape/footer-right.png') }}" alt="@lang('footer-right')">
    </div>
    <div class="footer__topbar">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="footer__topbar__content">
                        <a href="{{ route('home') }}" class="main__logo">
                            <img src="{{ getImage(getFilePath('logoIcon') . '/logo_white.png', '?' . time()) }}"
                                alt="@lang('logo image')">
                        </a>
                        <ul class="social__icon">
                            @foreach ($socialIcons ?? [] as $item)
                                <li>
                                    <a href="{{ $item->data_values->url }}" target="_blank">
                                        @php echo $item->data_values->social_icon; @endphp
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="border__footer"></div>
    </div>
    <div class="container">
        <div class="row gy-4 justify-content-center">
            <div class="col-lg-3 col-sm-4">
                <div class="footer__about">
                    <h4>@lang('About Us')</h4>
                    <p>{{ __($contactSection->data_values->footer_short_details) }}</p>
                </div>
            </div>
            <div class="col-lg-3 col-sm-4 col-6 d-flex justify-content-start justify-content-sm-center">
                <div class="footer__menu">
                    <h4>@lang('Company links')</h4>
                    <ul>
                        @foreach ($companyLinks->items ?? [] as $k => $data)
                            @if ($data->link_type == 2)
                                <li>
                                    <a href="{{ $data->url ?? '' }}" target="_blank"><i
                                            class="fa-solid fa-caret-right"></i>{{ __($data->title) }}</a>
                                </li>
                            @else
                                <li>
                                    <a href="{{ route('pages', [$data->url]) }}"
                                        class="footer__menu-link {{ Request::url() == url($data->url) ? 'active' : '' }}">
                                        <i class="fa-solid fa-caret-right"></i>
                                        {{ __(ucfirst(strtolower($data->title)) ?? '') }}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-sm-4 col-6 d-flex justify-content-start justify-content-sm-center">
                <div class="footer__menu">
                    <h4>@lang('Quick Links')</h4>
                    <ul>
                        @foreach ($quickLinks->items ?? [] as $k => $data)
                            @if ($data->link_type == 2)
                                <li>
                                    <a href="{{ $data->url ?? '' }}" target="_blank">
                                        <i class="fa-solid fa-caret-right"></i> {{ __($data->title) }}</a>
                                </li>
                            @else
                                <li>
                                    <a href="{{ route('pages', [$data->url]) }}"
                                        class="{{ Request::url() == url($data->url) ? 'active' : '' }}">
                                        <i class="fa-solid fa-caret-right"></i>
                                        {{ __(ucfirst(strtolower($data->title ?? ''))) }}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="footer__newsletter">
                    <h4>@lang('Newsletter')</h4>
                    <p>@lang('Subscribe to get account listings & deals')</p>
                    <form action="{{ route('subscribe') }}" method="POST">
                        @csrf
                        <div class="newsletter__input">
                            <input type="email" class="form-control" name="email" placeholder="@lang('Your email please')">
                            <button type="submit"><i class="fa-solid fa-paper-plane"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="footer__copyright">
        <p>@php echo $contactSection->data_values->website_footer; @endphp</p>
    </div>
</footer>
<!-- ==================== Footer End Here ==================== -->
