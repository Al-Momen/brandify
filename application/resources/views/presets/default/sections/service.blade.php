@php
    $serviceSectionContent = getContent('service.content', true);
    $serviceSectionElements = getContent('service.element', false, false, true);
@endphp

<!--==========================  Services Section Start  ==========================-->
<section class="services my-120">
    <div class="services__bg bg--img" data-background-image="{{ getImage(getFilePath('service') . 'services-bg.png') }}">
        <img src="{{ getImage(getFilePath('service') . 'services-bg.png') }}" alt="@lang('image')">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section__heading pt-100 mb-60 text-center">
                    <h3>{{ __($serviceSectionContent->data_values->heading) }}</h3>
                    <p>
                        {{ __($serviceSectionContent->data_values->subheading) }}
                    </p>
                </div>
            </div>
        </div>
        <div class="row gy-4 justify-content-center">
            @foreach ($serviceSectionElements ?? [] as $item)
                <div class="col-lg-4 col-sm-6">
                    <div class="services__items">
                        <a href="javascript:void(0)" class="services__thumb">
                            <img class="w--100" src="{{ getImage(getFilePath('service') . $item->data_values->image) }}" alt="@lang('image')">
                        </a>
                        <div class="services__content">
                            <h4><a href="javascript:void(0)">{{ __($item->data_values->heading) }}</a></h4>
                            <p>
                                {{ __($item->data_values->subheading) }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<!--==========================  Services Section End  ==========================-->
