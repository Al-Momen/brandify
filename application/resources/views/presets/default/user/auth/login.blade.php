@php
    $credentials = $general->socialite_credentials;
@endphp
@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <!--==========================  Auth Section Start  ==========================-->
    <div class="auth__area">
        <div class="auth__main position-relative">
            <div class="auth__bg bg--img" data-background-image="{{ asset($activeTemplateTrue . 'images/shape/line.png') }}"></div>
            <div class="auth__thumb">
                <img class="w--100" src="{{ asset($activeTemplateTrue . 'images/shape/sign-in.png') }}"
                    alt="@lang('image')">
            </div>
            <div class="auth__wrapper">
                <div class="auth__logo">
                    <a href="{{ route('home') }}">
                        <img src="{{ getImage(getFilePath('logoIcon') . '/logo.png', '?' . time()) }}"
                            alt="@lang('logo')">
                    </a>
                </div>
                <div class="auth__title">
                    <h3 class="mb-0">@lang('Sign in your account')</h3>
                </div>
                
                <form method="POST" action="{{ route('user.login') }}" class="verify-gcaptcha">
                    @csrf
                    <div class="auth__form">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="auth__form__single">
                                    <input id="usernameInput" class="form-control" name="username"
                                        value="{{ old('username') }}" placeholder="@lang('Enter your username')">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="auth__form__single">
                                    <div class="password__input">
                                        <input id="loginPassword" type="password" class="form-control" name="password"
                                            placeholder="@lang('Enter your password')">
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

                            <div class="col-lg-12">
                                <div class="auth__form__single">
                                    <button type="submit" class="btn btn--base w-100" id="recaptcha" >@lang('SIGN IN')</button>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="auth__widgets">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" name="remember"
                                                id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="rememberCheck">
                                            @lang('Remember Me')
                                        </label>
                                    </div>
                                    <a href="{{ route('user.password.request') }}">
                                        @lang('Forgot Password?')
                                    </a>
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
                                    <p>@lang('Don’t have an account? ') <a href="{{ route('user.register') }}">@lang('Sign Up')</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--==========================  Auth Section End  ==========================-->
@endsection

@push('script')
    <script>
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
