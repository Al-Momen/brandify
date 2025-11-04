@php
    $bannerSectionContent = getContent('banner.content', true);
    $bannerSectionElements = getContent('banner.element', false, false, true);
@endphp

{{-- <!--========================== Banner Section Start ==========================-->
<section class="banner">
    <div class="banner__shape">
        <img src="{{ getFilePath('shape') . 'shape.png' }}" alt="@lang('shape image')">
    </div>
    <div class="banner__shape">
        <img src="{{ getFilePath('shape') . 'shape.png' }}" alt="@lang('shape image')">
    </div>
    <div class="glove--base"></div>
    <div class="container">
        <div class="row g-4 g-md-5">
            <div class="col-lg-6">
                <div class="banner__content">
                    <div class="banner__subtitle">
                        <div class="banner__subtitle-icon">
                            <img src="{{ getImage(getFilePath('banner') . 'icon.png') }}" class="img-fluid"
                                alt="@lang('banner-image')">
                        </div>
                        <span>{{ __($bannerSectionContent->data_values->title) }}</span>
                    </div>
                    <h1 class="banner__title">{{ __($bannerSectionContent->data_values->heading) }}</h1>
                    <p class="banner__desc">{{ __($bannerSectionContent->data_values->subheading) }}</p>
                    <div class="banner__btns mt-40">
                        <a href="{{ route('user.login') }}"
                            class="btn btn--base">{{ __($bannerSectionContent->data_values->button_one) }}</a>
                        <a href="{{ route('user.form.create') }}"
                            class="btn btn--white">{{ __($bannerSectionContent->data_values->button_two) }}</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="banner__thumb-wrap">
                    <div class="banner__thumb">
                        <img src="{{ getImage(getFilePath('banner') . $bannerSectionContent->data_values->image_one) }}"
                            alt="@lang('banner-image')">
                    </div>
                    <div class="banner__thumb-2-wrap">
                        <div class="banner__thumb-2">
                            <img src="{{ getImage(getFilePath('banner') . $bannerSectionContent->data_values->image_two) }}"
                                alt="@lang('banner-image')">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--========================== Banner Section End ==========================--> --}}



<!--==========================  Hero Section Start  ==========================-->
<section class="hero__area">
    <img class="hero__watermark" src="{{ getImage(getFilePath('banner') . 'leaf.png') }}" alt="@lang('Banner Image')">
    <div class="container">
        <div class="row gy-4 align-items-center">
            <div class="col-lg-6">
                <div class="hero__content">
                    <h1>{{ __($bannerSectionContent->data_values->heading) }}</h1>
                    <p>
                        {{ __($bannerSectionContent->data_values->subheading) }}
                    </p>
                    <div class="hero__generate__wrapper">
                        <div class="hero__generate">
                            <input type="text" class="form-control" name="company_name"
                                placeholder="@lang('Enter Company Name')">
                            <div class="hero__generate__wrap">
                                <div class="hero__generate__line"></div>
                                <div class="dropdown line__dropdown">
                                    <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        @lang('Setting')
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">Action</a></li>
                                        <li>
                                            <a class="dropdown-item" href="#">Another action</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </li>
                                    </ul>
                                </div>
                                <button class="hero__btn btn btn--base">
                                    <img src="{{getImage(getFilePath('banner').'sparkle.svg')}}" alt="@lang('image')">
                                    @lang('Generate')
                                </button>
                            </div>
                        </div>
                        <div class="text-end">
                            <button class="hero__button fs--16 fw--500 btn btn--base">
                                <img src="{{getImage(getFilePath('banner').'sparkle.svg')}}" alt="@lang('image')">
                                @lang('Generate')
                            </button>
                        </div>
                        <div class="hero__generate-dropdown">
                            <div class="dropdown">
                                <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <img src="{{getImage(getFilePath('banner').'dropdown1.svg')}}" alt="@lang('image')">
                                    @lang('Select Style')
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Action</a></li>
                                    <li>
                                        <a class="dropdown-item" href="#">Another action</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="dropdown">
                                <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <img src="{{getImage(getFilePath('banner').'dropdown2.svg')}}" alt="@lang('image')">
                                    @lang('Color')
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Action</a></li>
                                    <li>
                                        <a class="dropdown-item" href="#">Another action</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="dropdown">
                                <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <img src="{{getImage(getFilePath('banner').'dropdown3.svg')}}" alt="@lang('image')">
                                    @lang('Shape')
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Action</a></li>
                                    <li>
                                        <a class="dropdown-item" href="#">Another action</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="dropdown">
                                <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <img src="{{getImage(getFilePath('banner').'dropdown3.svg')}}" alt="@lang('image')">
                                    @lang('Background')
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Action</a></li>
                                    <li>
                                        <a class="dropdown-item" href="#">Another action</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="row gy-4 align-items-center">
                    <div class="col-lg-4 col-sm-4 col-4">
                        <div class="hero__area__thumb">
                            @foreach ($bannerSectionElements->take(2) as $item)
                                <img class="image{{ $loop->index + 1 }}"
                                    src="{{ getImage(getFilePath('banner') . $item->data_values->image) }}"
                                    alt="@lang('image')">
                            @endforeach
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-4 col-4">
                        <div class="hero__area__thumb">
                            @foreach ($bannerSectionElements->skip(2)->take(3) as $item)
                                <img class="image{{ $loop->index + 1 }}"
                                    src="{{ getImage(getFilePath('banner') . $item->data_values->image) }}"
                                    alt="@lang('image')">
                            @endforeach
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-4 col-4">
                        <div class="hero__area__thumb">
                            @foreach ($bannerSectionElements->skip(5)->take(2) as $item)
                                <img class="image{{ $loop->index + 1 }}"
                                    src="{{ getImage(getFilePath('banner') . $item->data_values->image) }}"
                                    alt="@lang('image')">
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--==========================  Hero Section End  ==========================-->
