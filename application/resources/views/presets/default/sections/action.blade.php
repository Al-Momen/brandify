@php
    $actionSectionContent = getContent('action.content', true);
    $actionSectionElements = getContent('action.element', false, false, true);
@endphp
<!--==========================  Sample Section Start  ==========================-->
<section class="sample__area my-120">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section__heading mb-60 text-center">
                    <h3>{{ __($actionSectionContent->data_values->heading) }}</h3>
                    <p>
                        {{ __($actionSectionContent->data_values->subheading) }}
                    </p>
                </div>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-3 col-sm-3">
                @foreach ($actionSectionElements->take(2) ?? [] as $item)
                    <div class="sample__card">
                        <img src="{{ getImage(getFilePath('action') . $item->data_values->image) }}"
                            alt="@lang('image')">
                    </div>
                @endforeach

            </div>
            <div class="col-md-4 col-sm-3">
                @foreach ($actionSectionElements->skip(2)->take(2) ?? [] as $item)
                    <div class="sample__card">
                        <img src="{{ getImage(getFilePath('action') . $item->data_values->image) }}"
                            alt="@lang('image')">
                    </div>
                @endforeach
            </div>
            <div class="col-md-5 col-sm-6">
                @foreach ($actionSectionElements->skip(4) ?? [] as $item)
                    <div class="sample__card">
                        <img src="{{ getImage(getFilePath('action') . $item->data_values->image) }}"
                            alt="@lang('image')">
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!--==========================  Sample Section End  ==========================-->
