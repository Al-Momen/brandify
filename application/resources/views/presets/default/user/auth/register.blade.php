@php
    $credentials = $general->socialite_credentials;
    $policyPages = getContent('policy_pages.element', false, null, true);
@endphp

@extends($activeTemplate . 'layouts.frontend')
@section('content')
   
    <!--==========================  Auth Section Start  ==========================-->
    <div class="auth__area">
        <div class="auth__main position-relative z--1">
            <div class="auth__bg bg--img"
                data-background-image="{{ asset($activeTemplateTrue . 'images/shape/line.png') }}"></div>
            <div class="auth__thumb bg-img">
                <img src="{{ asset($activeTemplateTrue . 'images/shape/sign-in.png') }}" alt="@lang('image')">
            </div>
            <div class="auth__wrapper sign-up__wrapper">
                <div class="auth__logo">
                    <a href="index.html"><img src="{{ getImage(getFilePath('logoIcon') . '/logo.png', '?' . time()) }}"
                            alt="@lang('logo')"></a>
                </div>
                <div class="auth__title">
                    <h3>@lang('Sign up your account')</h3>
                </div>
                <form action="{{ route('user.register') }}" method="POST" class="verify-gcaptcha">
                    @csrf
                    <div class="auth__form">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="auth__form__single">
                                    <input id="username" type="text" class="form-control checkUser" name="username"
                                        value="{{ old('username') }}" id="usernameInput"
                                        placeholder="@lang('Username')" required>
                                    <p class="text--danger usernameExist"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="auth__form__single">
                                    <input id="email" type="email" class="form-control checkUser" id="emailInput"
                                        value="{{ old('email') }}" name="email" placeholder="@lang('Email Address')"
                                        required>
                                    <p class="text--danger mt-1 emailExist"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="auth__form__single">
                                    <select id="country" name="country" class="select2" required>
                                        @foreach ($countries as $key => $country)
                                            <option data-mobile_code="{{ $country->dial_code }}"
                                                value="{{ $country->country }}" data-code="{{ $key }}">
                                                {{ __($country->country) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="auth__form__single">
                                    <input type="hidden" name="mobile_code">
                                    <input type="hidden" name="country_code">
                                    <div class="input-group">
                                        <span class="input-group-text mobile-code"></span>
                                        <input id="phone" type="text" name="mobile"
                                            id="phoneInput" value="" class="form-control checkUser" required
                                            id="mobile" placeholder="@lang('Phone Number')">
                                        <p class="text--danger mobileExist"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="auth__form__single">
                                    <div class="password__input">
                                        <input id="password" type="password" class="form-control" id="passwordInput"
                                            placeholder="@lang('Password')" name="password" type="password" required>
                                        <div class="password-show-hide">
                                            <i class="fa-solid fa-eye close-eye-icon"></i>
                                            <i class="fa-solid fa-eye-slash open-eye-icon"></i>
                                        </div>
                                        @if ($general->secure_password)
                                            <div class="input-popup">
                                                <p class="error lower text--white">@lang('1 small letter minimum')</p>
                                                <p class="error capital text--white">@lang('1 capital letter minimum')</p>
                                                <p class="error number text--white">@lang('1 number minimum')</p>
                                                <p class="error special text--white">@lang('1 special character minimum')</p>
                                                <p class="error minimum text--white">@lang('6 character password')</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="auth__form__single">
                                    <div class="password__input">
                                        <input id="confirmPassword" type="password" class="form-control"
                                            id="confirmPasswordInput" placeholder="Confirm Password"
                                            name="password_confirmation" type="password" required>
                                        <div class="password-show-hide">
                                            <i class="fa-solid fa-eye close-eye-icon"></i>
                                            <i class="fa-solid fa-eye-slash open-eye-icon"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-6 col-sm-6 recap">
                                <x-captcha></x-captcha>
                            </div>
                            @if ($general->agree)
                                <div class="col-lg-12">
                                    <div class="auth__check">
                                        <div class="form-check">
                                            <input id="checkDefault" class="form-check-input" type="checkbox"
                                                name="agree" @checked(old('agree')) id="checkDefault" required>
                                            <label class="form-check-label" for="checkDefault">
                                                @lang('I agree with')
                                                @foreach ($policyPages as $policy)
                                                    <a href="{{ route('policy.pages', [slug($policy->data_values->title), $policy->id]) }}"
                                                        class="btn--underline">{{ __($policy->data_values->title) ?? '' }}</a>
                                                    @if (!$loop->last)
                                                        ,
                                                    @endif
                                                @endforeach
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="col-lg-12">
                                <div class="auth__form__single">
                                    <button type="submit" class="btn btn--base w-100"
                                        id="recaptcha">@lang('SIGN UP')</button>
                                </div>
                            </div>
                            @if ($credentials->google->status == 1 || $credentials->facebook->status == 1)
                                <div class="col-lg-12">
                                    <div class="auth__or">
                                        <p>@lang('OR')</p>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <ul class="social__icon justify-content-center">
                                        @if ($credentials->google->status == 1)
                                            <li>
                                                <a href="{{ route('user.social.login', 'google') }}">
                                                    <i class="fa-brands fa-google"></i>
                                                </a>
                                            </li>
                                        @endif
                                        @if ($credentials->facebook->status == 1)
                                            <li>
                                                <a href="{{ route('user.social.login', 'facebook') }}">
                                                    <i class="fa-brands fa-facebook-f"></i>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            @endif
                            <div class="col-lg-12">
                                <div class="auth__already">
                                    <p>@lang('You have any account?') <a href="{{ route('user.login') }}">@lang('Sign In')</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--==========================  Auth Section End  ==========================-->


    {{-- =======-** Sign Up End **-======= --}}
    <div class="modal fade" id="existModalCenter" tabindex="-1" role="dialog" aria-labelledby="existModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="existModalLongTitle">@lang('You are with us')</h5>
                    <span type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                    </span>
                </div>
                <div class="modal-body">
                    <h6 class="text-center my-4">@lang('You already have an account please Login ')</h6>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('user.login') }}" class="btn btn--base btn--md">@lang('Login')</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-lib')
    <script src="{{ asset('assets/common/js/secure_password.js') }}"></script>
@endpush
@push('script')
    <script>
        (function($) {
            "use strict";
            @if ($mobileCode)
                $(`option[data-code={{ $mobileCode }}]`).attr('selected', '');
            @endif

            $('select[name=country]').on('change', function() {
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
            });
            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
            @if ($general->secure_password)
                $('input[name=password]').on('input', function() {
                    secure_password($(this));
                });

                $('[name=password]').on('focus'function() {
                    $(this).closest('.form-group').addClass('hover-input-popup');
                });

                $('[name=password]').on('focusout', function() {
                    $(this).closest('.form-group').removeClass('hover-input-popup');
                });
            @endif

            $('.checkUser').on('focusout', function(e) {
                var url = '{{ route('user.checkUser') }}';
                var value = $(this).val();
                var token = '{{ csrf_token() }}';
                if ($(this).attr('name') == 'mobile') {
                    var mobile = `${$('.mobile-code').text().substr(1)}${value}`;

                    var data = {
                        mobile: mobile,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'email') {
                    var data = {
                        email: value,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'username') {
                    var data = {
                        username: value,
                        _token: token
                    }
                }
                $.post(url, data, function(response) {


                    if (response.data != false && response.type == 'email') {
                        $('#existModalCenter').modal('show');
                    } else if (response.data != false) {
                        $(`.${response.type}Exist`).text(`${response.type} already exist`);
                    } else {
                        $(`.${response.type}Exist`).text('');
                    }
                });
            });
        })(jQuery);

        $(document).ready(function() {
            'use strict';
            $('.recap').each(function() {
                if ($(this).children().length === 0) {

                    $(this).addClass('d-none');
                } else {
                    $(this).removeClass('d-none');
                }
            });
        });
    </script>
@endpush
