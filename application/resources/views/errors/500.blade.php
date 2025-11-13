<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> {{ $general->siteName(__('404')) }}</title>
    <link href="{{ asset('assets/common/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="shortcut icon" href="{{ siteFavicon() }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/main.css') }}">
</head>

<body>
    <!--==========================  404 Section Start  ==========================-->
<div class="error">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="error__main">
                        <div class="error__ripple">
                            <div class="ripple__inner">
                                <div class="error__sp"></div>
                                <div class="error__sp"></div>
                                <div class="error__sp"></div>
                                <div class="error__sp"></div>
                                <div class="error__sp"></div>
                                <div class="error__content">
                                    <div class="error__image">
                                        <img src="{{ getImage(getFilePath('error') . '500.png') }}"
                                            alt="@lang('image')">
                                    </div>
                                    <h2>404</h2>
                                    <p>@lang('Whoops! Something Went Wrong')</p>

                                    <a href="{{ route('home') }}"
                                        class="btn btn--base white-space">@lang('Back to Home')</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--==========================  404 Section End  ==========================-->
</body>

</html>
