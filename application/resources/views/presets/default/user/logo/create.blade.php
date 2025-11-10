@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="dashboard__wrapper">
        <div class="row gy-4">
            <div class="col-xl-4 col-lg-4">
                <div class="create__logo__wrapper">
                    <h3 class="create__logo__title">@lang('Create Logo')</h3>
                    <div class="create__logo__item mb-3">
                        <input class="form-control" type="text" id="brand-name" placeholder="@lang('Enter Your Brand Name')">
                    </div>
                    <div class="create__logo__item">
                        <div class="dropdown">
                            <button class=" create__dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <img src="{{ getImage(getFilePath('shape') . 'dropdown1.svg') }}" alt="@lang('image')">
                                Select
                                Style
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="create__logo__item">
                        <div class="dropdown">
                            <button class=" create__dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <img src="{{ getImage(getFilePath('shape') . 'dropdown2.svg') }}" alt="@lang('image')">@lang('Color')
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="create__logo__item">
                        <div class="dropdown">
                            <button class="create__dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <img src="{{ getImage(getFilePath('banner') . 'dropdown3.svg') }}"
                                    alt="@lang('image')">@lang('Category')
                            </button>
                            <ul class="dropdown-menu">
                                @foreach ($categories ?? [] as $item)
                                    <li>
                                        <a class="dropdown-item" href="#">{{ __($item->name) }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="create__logo__item">
                        <div class="create__dropdown d-flex flex-wrap gap-2 justify-content-between" type="button">
                            <div>
                                <img src="{{ getImage(getFilePath('shape') . 'dropdown3.svg') }}" alt="@lang('image')">
                                @lang('Is Remove Background')
                            </div>
                            <div class="form-group mb-0">
                                <label class="switch m-0" title="@lang('Remove background image')">
                                    <input type="checkbox" class="toggle-switch" id="remove-background">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="create__logo__item">
                        <div class="create__dropdown" type="button">
                            <label for="logo-count" class="form-label">@lang('Logo Count')</label>
                            <input id="logo-count" type="text" class="form-control" placeholder="@lang('Number of your logo')">
                        </div>
                    </div>

                    <div class="create__logo__item">
                        <div class="create__dropdown" type="button">
                            <label for="ai-prompt" class="form-label">@lang('AI Prompt')</label>
                            <textarea name="ai-prompt" class="form-control" id="ai-prompt" cols="30" rows="10"
                                placeholder="@lang('Enter your prompt')"></textarea>
                        </div>
                    </div>
                    <div class="create__logo__item">
                        <button type="button" id="generate-logo-btn" class="btn btn--base mt-3">@lang('Generate Logo')</button>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 col-lg-8">
                <div class="card">
                    <div class="create__logo__thumb">
                        <img class="w--100" src="{{ getImage(getFilePath('shape') . 'logo_view.png') }}"
                            alt="@lang('logo view')">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#generate-logo-btn').on('click', function() {
                let brandName = $('#brand-name').val();
                let removeBackground = $('#remove-background').is(':checked') ? true : false;
                let logoCount = parseInt($('#logo-count').val()) || 1;
                let prompt = $('#ai-prompt').val();

                const validations = [{
                        value: brandName,
                        message: "Brand name is required!"
                    },
                    {
                        value: prompt,
                        message: "AI prompt is required!"
                    },
                    {
                        value: logoCount,
                        message: "Logo Count is required!"
                    }
                ];

                for (const {
                        value,
                        message
                    }
                    of validations) {
                    if (!value) {
                        notify("error", message);
                        return;
                    }
                }

                $.ajax({
                    url: "{{ route('user.logo.generate') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        brand_name: brandName,
                        remove_background: removeBackground,
                        logo_count: logoCount,
                        prompt: prompt
                    },
                    beforeSend: function() {
                        $('#generate-logo-btn').prop('disabled', true).text('Generating...');
                    },
                    success: function(res) {
                        $('#generate-logo-btn').prop('disabled', false).text('Generate Logo');

                        if (res.status === 'success' && res.data && res.data.logo) {
                            let html = '';
                            res.data.logo.forEach(function(item) {
                                html += `<div class="mb-3">
                                    <img src="${item.url}" alt="${item.brand_name}" class="w-100">
                                 </div>`;
                            });
                            $('.create__logo__thumb').html(html);
                        } else {
                            alert(res.message || 'No logos generated.');
                        }
                    },
                    error: function(xhr) {
                        $('#generate-logo-btn').prop('disabled', false).text('Generate Logo');
                        alert('Something went wrong!');
                    }
                });
            });

        });
    </script>
@endpush
