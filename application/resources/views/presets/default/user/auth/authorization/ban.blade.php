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

                <div class="row">
                    <div class="col-12">
                        <div class="account__header">
                            <h2 class="account__title">{{ __($pageTitle) }}</h2>
                            <p class="account__desc">
                                @lang('To recover your account please provide your email or username to find your account.')
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row gx-3 gy-4">
                    <div class="verification-area">
                        <h3 class="text-center text-danger">@lang('You are banned')</h3>
                        <p class="fw--500 mb-1">@lang('Reason'):</p>
                        <p>{{ $user->ban_reason }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
