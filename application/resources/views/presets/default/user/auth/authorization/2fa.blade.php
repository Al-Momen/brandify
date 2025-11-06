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
                            <h2 class="account__title">@lang('2FA Verification')</h2>
                            <p class="account__desc">
                                @lang('A 6 digit verification code sent to your mobile number') : +{{ showMobileNumber(auth()->user()->mobile) }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row gx-3 gy-4">
                    <div class="verification-area ">
                        <form action="{{ route('user.go2fa.verify') }}" method="POST" class="submit-form">
                            @csrf
                            <div class="mt-1">
                                @include($activeTemplate . 'components.verification_code')
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('style')
    <style>
        .auth__area .form-control {
            padding: 21px !important;
        }

        @media screen and (max-width: 2560px) {
            .auth__area .form-control {
                padding: 6px !important;
            }

            .verification-code input {
                        letter-spacing: 49px !important;
        text-indent: 18px !important;
            }
        }

        @media screen and (max-width: 1440px) {
            .auth__area .form-control {
                padding: 10px !important;
            }

            .verification-code input {
                letter-spacing: 38px !important;
                text-indent: 10px !important;
            }
        }

        @media screen and (max-width: 1025px) {
            .auth__area .form-control {
                padding: 8px !important;
            }

            .verification-code input {
                letter-spacing: 54px !important;
                text-indent: 17px !important;
            }
        }

        @media screen and (max-width: 991px) {
            .verification-code input {
                letter-spacing: 74px !important;
                text-indent: 6px !important;
            }
        }

        @media screen and (max-width: 769px) {
            .verification-code input {
                letter-spacing: 73px !important;
                text-indent: 10px !important;
            }
        }

        @media screen and (max-width: 426px) {
            .verification-code input {
                letter-spacing: 46px !important;
                text-indent: 7px !important;
            }
        }

        @media screen and (max-width: 376px) {
            .verification-code input {
                letter-spacing: 41px !important;
                text-indent: 5px !important;
            }
        }

        @media screen and (max-width: 321px) {
            .auth__area .form-control {
                padding: 15px !important;
            }

            .verification-code input {
                letter-spacing: 32px !important;
                text-indent: 0px !important;
            }
        }

        .verification-code::after {
            background-color: transparent;
        }

        .verification-code span {
            background: transparent !important;
            border: solid 1px hsl(var(--base) / 0.2);
        }
    </style>
@endpush
