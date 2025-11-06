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
                <div class="auth__logo">
                    <a href="{{ route('home') }}">
                        <img src="{{ getImage(getFilePath('logoIcon') . '/logo.png', '?' . time()) }}"
                            alt="@lang('logo')">
                    </a>
                </div>
                <div class="auth__title">
                    <h3 class="mb-0">@lang('Profile Update')</h3>
                </div>
                <form method="POST" action="{{ route('user.data.submit') }}" class="verify-gcaptcha">
                    @csrf
                    <div class="auth__form">
                        <div class="row g-4">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="auth__form__single">
                                    <input id="first-name" class="form-control" name="firstname" id="firstname"
                                        value="{{ old('firstname') }}" placeholder="@lang('First Name')" required>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="auth__form__single">
                                    <input id="last-name" class="form-control" name="lastname" id="lastname"
                                        value="{{ old('lastname') }}" placeholder="@lang('Last Name')" required>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="auth__form__single">
                                    <input id="address" class="form-control" name="address" id="address"
                                        value="{{ old('address') }}" placeholder="@lang('Address')">
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="auth__form__single">
                                    <input id="state" class="form-control" name="state" id="state" value="{{ old('state') }}"
                                        placeholder="@lang('State')">
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="auth__form__single">
                                    <input name="zip" class="form-control" id="zip" value="{{ old('zip') }}"
                                        placeholder="@lang('Zip')">
                                </div>
                            </div>


                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="auth__form__single">
                                    <input name="city" class="form-control" id="city" value="{{ old('city') }}"
                                        placeholder="@lang('City')">
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 text-end">
                                <button type="submit" class="btn btn--base">@lang('Save')</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
