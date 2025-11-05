@php
    $counterSectionElements = getContent('counter.element', false, false, true);
@endphp
<!--==========================  Counter Section Start  ==========================-->
<section class="counter__area my-120">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="counter__wrap">
                    @foreach ($counterSectionElements ??[] as $item)
                    <div class="counter__single">
                        <div class="counter__icons">
                            @php
                                echo $item->data_values->icon;
                            @endphp
                        </div>
                        <h3 class="odometer" data-odometer-final="{{$item->data_values->counter}}">0</h3>
                        <p>{{__($item->data_values->title) }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!--==========================  Counter Section End  ==========================-->
