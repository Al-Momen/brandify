@php
    $tutorialSectionContent = getContent('tutorial.content', true);
    $tutorialSectionElements = getContent('tutorial.element', false, false, true);
@endphp

<!--==========================  Tutorial Section Start  ==========================-->
<section class="tutorial__area my-120">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section__heading mb-60 text-center">
                    <h3>{{ __($tutorialSectionContent->data_values->heading) }}</h3>
                    <p>
                        {{ __($tutorialSectionContent->data_values->subheading) }}
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="tutorial__wrap">
                    @foreach ($tutorialSectionElements ?? [] as $index => $item)
                        <div class="tutorial__single">
                            <span>{{ sprintf('%02d', $index + 1) }}</span>
                            <h4>{{ __($item->data_values->heading) }}</h4>
                            <p>{{ __($item->data_values->subheading) }}</p>
                        </div>
                        @if ($index == 0)
                            <div class="tutorial__image">
                                <img src="{{ getImage(getFilePath('tutorial').'tutorial-arrow.png') }}" alt="@lang('image')">
                            </div>
                        @elseif ($index == 1)
                            <div class="tutorial__image">
                                <img src="{{ getImage(getFilePath('tutorial').'tutorial-arrow2.png') }}" alt="@lang('image')">
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!--==========================  Tutorial Section End  ==========================-->
