@php
    $contactSectionContent = getContent('contact_us.content', true);
    $socialIcons = getContent('social_icon.element', false);
    $user = auth()->user();
@endphp

@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <!-- ==================== Contact Section Start Here ==================== -->
    <div class="contact my-120">
        <div class="container">
            <div class="row gy-4 justify-content-center">
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="contact__card">
                        <span class="contact__icon">
                            <i class="fa-solid fa-phone-volume"></i>
                        </span>
                        <div class="contact__content">
                            <h4>@lang('Phone Number')</h4>
                            <a href="tel:{{ $contactSectionContent->data_values?->contact_number ?? '' }}">
                                {{ $contactSectionContent->data_values?->contact_number ?? '' }}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="contact__card">
                        <span class="contact__icon">
                            <i class="fa-solid fa-envelope"></i>
                        </span>
                        <div class="contact__content">
                            <h4>@lang('Email Address')</h4>
                            <a href="{{ $contactSectionContent->data_values?->email_address ?? '' }}">
                                {{ $contactSectionContent->data_values?->email_address ?? '' }}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="contact__card">
                        <span class="contact__icon"><i class="fa-solid fa-location-dot"></i></span>
                        <div class="contact__content">
                            <h4>@lang('Our Location')</h4>
                            <p>{{ $contactSectionContent->data_values?->contact_details }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="contact__card">
                        <span class="contact__icon"><i class="fa-solid fa-headset"></i></span>
                        <div class="contact__content">
                            <h4>@lang('Support') </h4>
                            <p>{{ $contactSectionContent->data_values?->support_number ?? '' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="contact__items mt-120">
                <div class="row gy-4 align-items-center">
                    <div class="col-lg-6">
                        <div class="contact__items__content">
                            <h3 class="contact__items__title">{{ $contactSectionContent->data_values?->heading ?? '' }}</h3>
                            <p class="contact__items__desc">
                                {{ __($contactSectionContent->data_values?->short_description) ?? '' }}</p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row gy-4">
                            <form method="post" action="#" class="row gy-4 verify-gcaptcha">
                                @csrf
                                <div class="col-lg-6">
                                    <div class="auth__form__single">
                                        <label for="userName" class="form-label">@lang('Username')</label>
                                        <input type="text" id="userName" class="form-control"
                                            name="name" value="@if(auth()->user()){{auth()->user()->fullname}}@else{{ old('name') }}@endif"
                                            @if (auth()->user()) readonly @endif required
                                            placeholder="@lang('Enter Username')">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="auth__form__single">
                                        <label for="email" class="form-label">@lang('Email Address')</label>
                                        <input id="email" type="email" class="form-control"
                                            placeholder="@lang('Enter Email Address')" name="email"
                                            value="@if (auth()->user()) {{ auth()->user()->email }}@else{{ old('email') }} @endif"
                                            @if (auth()->user()) readonly @endif required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="auth__form__single">
                                        <label for="subject" class="form-label">@lang('Subject')</label>
                                        <input id="subject" type="text" class="form-control" name="subject"
                                            placeholder="@lang('Subject')" value="{{ old('subject') }}" required>
                                    </div>
                                </div>
                                <div class="auth__form__single">
                                    <label for="message" class="form-label">@lang('Message')</label>
                                    <textarea class="form-control" name="message" 
                                    placeholder="@lang('Enter your message here')..." id="message" required>{{ old('message') }}</textarea>
                                </div>
                                <div class="col-lg-12 recap">
                                    <x-captcha></x-captcha>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn--base" id="recaptcha">
                                        {{ __($contactSectionContent->data_values?->button_text) }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ==================== Contact Section End Here ==================== -->
    @if ($sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif
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
