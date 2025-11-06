@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="auth__area">
        <div class="auth__main position-relative">
            <div class="auth__bg bg--img" data-background-image="{{ asset($activeTemplateTrue . 'images/shape/line.png') }}">
            </div>
            <div class="auth__thumb">
                <img class="w--100" src="{{ asset($activeTemplateTrue . 'images/shape/sign-in.png') }}"
                    alt="@lang('image')">
            </div>
            <div class="auth__wrapper">
                <form class="account__form" method="POST" action="{{ route('user.password.update') }}">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="row">
                        <div class="col-12">
                            <div class="account__header">
                                <h2 class="account__title">@lang('Reset Password')</h2>
                                <p class="account__desc">
                                    @lang("Your account is verified successfully. Now you can change your password. Please enter a strong password and don't share it with anyone.")
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row gx-3 gy-4 mt-1">
                        <div class="col-lg-12 col-md-6 col-sm-6">
                            <input type="password" class="form-control" name="password" required id="usernameInput"
                                required placeholder="@lang('Password')">
                        </div>
                        @if ($general->secure_password)
                            <div class="input-popup">
                                <p class="error lower">@lang('1 small letter minimum')</p>
                                <p class="error capital">@lang('1 capital letter minimum')</p>
                                <p class="error number">@lang('1 number minimum')</p>
                                <p class="error special">@lang('1 special character minimum')</p>
                                <p class="error minimum">@lang('6 character password')</p>
                            </div>
                        @endif
                        <div class="col-lg-12 col-md-6 col-sm-6">
                            <input type="password" class="form-control" name="password_confirmation" required
                                id="passwordInput" required placeholder="@lang('Confirm Password')">

                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn--base w-100">
                                @lang('Submit')
                            </button>
                        </div>
                    </div>
                </form>
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
            @if ($general->secure_password)
                $('input[name=password]').on('input', function() {
                    secure_password($(this));
                });

                $('[name=password]').on('focus', function() {
                    $(this).closest('.form-group').addClass('hover-input-popup');
                });

                $('[name=password]').on('focusout', function() {
                    $(this).closest('.form-group').removeClass('hover-input-popup');
                });
            @endif
        })(jQuery);
    </script>
@endpush
