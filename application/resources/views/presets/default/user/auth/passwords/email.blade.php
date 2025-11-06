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
                <form class="account__form" method="POST" action="{{ route('user.password.email') }}">
                    @csrf
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
                    <div class="row gx-3 gy-4 mt-2">
                        <div class="col-lg-12 col-md-6 col-sm-6">
                            <input type="text" class="form-control" name="value" value="{{ old('value') }}"
                                id="usernameInput" placeholder="@lang('Email or Username')" required autofocus="off">
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
