@php
    $featureSectionContent = getContent('feature.content', true);
    $featureSectionElements = getContent('feature.element', false, false, true);
@endphp
<!--==========================   Features Start  ==========================-->
<section class="feature__area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="feature__wrap">
                    @foreach ($featureSectionElements as $index => $item)
                        <div class="feature__single my-120">
                            <div class="row g-4 align-items-center">
                                @if ($index == 1)
                                    <div class="col-lg-6 col-md-6">
                                        <div class="feature__content ms-auto">
                                            <h3>{{ __($item->data_values->heading) }}</h3>
                                            <div class="wyg">
                                                @php
                                                    echo $item->data_values->description;
                                                @endphp
                                            </div>
                                            <a href="" class="btn btn--base">
                                                {{ __($item->data_values->button) }}
                                            </a>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="feature__img">
                                            <img src="{{ getImage(getFilePath('feature') . $item->data_values->image) }}"
                                                alt="@lang('image')">
                                        </div>
                                    </div>
                                @else
                                    <div class="col-lg-6 col-md-6">
                                        <div class="feature__img">
                                            <img src="{{ getImage(getFilePath('feature') . $item->data_values->image) }}"
                                                alt="@lang('image')">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="feature__content">
                                            <h3>{{ __($item->data_values->heading) }}</h3>
                                            <div class="wyg">
                                                @php
                                                    echo $item->data_values->description;
                                                @endphp
                                            </div>
                                            <a href="" class="btn btn--base">
                                                {{ __($item->data_values->button) }}
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!--==========================  Feature Section End  ==========================-->
