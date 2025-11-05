@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <!--==========================  privacy-policy Section Start  ==========================-->
    <div class="policy__area my-120">
        <img class="policy__sp" src="{{ asset($activeTemplateTrue . 'images/shape/policy-page.png') }}"
            alt="@lang('image')">
        <img class="policy__sp sp-2" src="{{ asset($activeTemplateTrue . 'images/shape/policy-page.png') }}"
            alt="@lang('image')">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="policy__content wyg">
                        @php
                            echo $policy->data_values->details;
                        @endphp
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--==========================  privacy-policy Section End  ==========================-->
@endsection
