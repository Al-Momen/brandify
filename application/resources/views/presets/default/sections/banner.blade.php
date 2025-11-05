@php
    $bannerSectionContent = getContent('banner.content', true);
    $bannerSectionElements = getContent('banner.element', false, false, true);
@endphp

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
                                    <img src="{{ getImage(getFilePath('banner') . 'sparkle.svg') }}"
                                        alt="@lang('image')">
                                    @lang('Generate')
                                </button>
                            </div>
                        </div>
                        <div class="text-end">
                            <button class="hero__button fs--16 fw--500 btn btn--base">
                                <img src="{{ getImage(getFilePath('banner') . 'sparkle.svg') }}" alt="@lang('image')">
                                @lang('Generate')
                            </button>
                        </div>
                        <div class="hero__generate-dropdown">
                            <div class="dropdown">
                                <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <img src="{{ getImage(getFilePath('banner') . 'dropdown1.svg') }}"
                                        alt="@lang('image')">
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
                                    <img src="{{ getImage(getFilePath('banner') . 'dropdown2.svg') }}"
                                        alt="@lang('image')">
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
                                    <img src="{{ getImage(getFilePath('banner') . 'dropdown3.svg') }}"
                                        alt="@lang('image')">
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
                                    <img src="{{ getImage(getFilePath('banner') . 'dropdown3.svg') }}"
                                        alt="@lang('image')">
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
                        <div class="hero__area__thumb middle-banner-section">
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
@push('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const container = document.querySelector('.middle-banner-section');
            const images = container.querySelectorAll('img');
            const lastImage = images[images.length - 1];

            if (lastImage) {
                // নতুন div তৈরি
                const wrapper = document.createElement('div');
                wrapper.classList.add('last-banner-image');

                
                lastImage.parentNode.insertBefore(wrapper, lastImage);
                wrapper.appendChild(lastImage);
            }
        });
    </script>
@endpush
