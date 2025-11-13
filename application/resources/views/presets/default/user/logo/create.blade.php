@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="dashboard__wrapper">
        <div class="row gy-4">
            <div class="col-xl-4 col-lg-4">
                <div class="create__logo__wrapper">
                    <div class="d-flex justify-content-between">
                        <h3 class="create__logo__title">@lang('Create Logo')</h3>
                        <p>@lang('Your current credit is'): <span class="text--base">{{ auth()->user()->credit }}</span></p>
                    </div>
                    <div class="create__logo__item mb-3">
                        <input class="form-control" type="text" id="brand-name" placeholder="@lang('Enter Your Brand Name')">
                    </div>
                    <div class="create__logo__item">
                        <select class="form-select custom-select-with-icon" name="font_name">
                            <option value="0" selected>@lang('Select Font Style')</option>
                            @foreach ($fonts ?? [] as $item)
                                <option value="{{ __($item['family']) }}">{{ $item['family'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="create__logo__item">
                        <select class="form-select custom-select-with-category-icon" name="category_id">
                            <option value="0" selected>@lang('Select Category')</option>
                            @foreach ($categories ?? [] as $item)
                                <option value="{{ $item->id }}">{{ __($item->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="create__logo__item">
                        <div class="dropdown">
                            <div class="col-md-6 col-xs-12">
                                <div class="form-group color--select position-relative">
                                    <div class="colorInputWrapper">
                                        <input class="form-control colorPicker" type='text'
                                            value="{{ gs('base_color') }}">
                                        <input class="form-control colorCode" name="base_color" type="text"
                                            value="{{ gs('base_color') }}">
                                    </div>
                                </div>
                            </div>
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
                            <input id="logo-count" type="number" class="form-control" value="1" min="1"
                                step="1" placeholder="@lang('Number of your logo')">
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
                        <button type="button" id="generate-logo-btn"
                            class="btn btn--lg btn--base mt-3">@lang('Generate Logo')</button>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 col-lg-8">
                <div class="card">
                    <div class="create__logo__thumb text-center">
                        <img class="w--100" src="{{ getImage(getFilePath('shape') . 'logo_view.png') }}"
                            alt="@lang('logo view')">
                    </div>
                </div>
            </div>
        </div>
    </div>

        <div id="adsGenerateModal" class="modal custom--modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="view-details-card">
                            <div class="view-details-card-preview">
                                <div class="gallary-details-card-loader">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="sparkle">
                                        <defs>
                                            <linearGradient id="starGradient">
                                                <stop offset="0%" stop-color="hsl(var(--base))" />
                                                <stop offset="29.81%" stop-color="hsl(var(--base-two))" />
                                                <stop offset="64.42%" stop-color="hsl(var(--base-three))" />
                                                <stop offset="100%" stop-color="hsl(var(--base-four))" />
                                            </linearGradient>
                                        </defs>
                                        <path class="path" stroke-linejoin="round" stroke-linecap="round"
                                            stroke="currentColor" fill="currentColor"
                                            d="M14.187 8.096L15 5.25L15.813 8.096C16.0231 8.83114 16.4171 9.50062 16.9577 10.0413C17.4984 10.5819 18.1679 10.9759 18.903 11.186L21.75 12L18.904 12.813C18.1689 13.0231 17.4994 13.4171 16.9587 13.9577C16.4181 14.4984 16.0241 15.1679 15.814 15.903L15 18.75L14.187 15.904C13.9769 15.1689 13.5829 14.4994 13.0423 13.9587C12.5016 13.4181 11.8321 13.0241 11.097 12.814L8.25 12L11.096 11.187C11.8311 10.9769 12.5006 10.5829 13.0413 10.0423C13.5819 9.50162 13.9759 8.83214 14.186 8.097L14.187 8.096Z">
                                        </path>
                                        <path class="path" stroke-linejoin="round" stroke-linecap="round"
                                            stroke="currentColor" fill="currentColor"
                                            d="M6 14.25L5.741 15.285C5.59267 15.8785 5.28579 16.4206 4.85319 16.8532C4.42059 17.2858 3.87853 17.5927 3.285 17.741L2.25 18L3.285 18.259C3.87853 18.4073 4.42059 18.7142 4.85319 19.1468C5.28579 19.5794 5.59267 20.1215 5.741 20.715L6 21.75L6.259 20.715C6.40725 20.1216 6.71398 19.5796 7.14639 19.147C7.5788 18.7144 8.12065 18.4075 8.714 18.259L9.75 18L8.714 17.741C8.12065 17.5925 7.5788 17.2856 7.14639 16.853C6.71398 16.4204 6.40725 15.8784 6.259 15.285L6 14.25Z">
                                        </path>
                                        <path class="path" stroke-linejoin="round" stroke-linecap="round"
                                            stroke="currentColor" fill="currentColor"
                                            d="M6.5 4L6.303 4.5915C6.24777 4.75718 6.15472 4.90774 6.03123 5.03123C5.90774 5.15472 5.75718 5.24777 5.5915 5.303L5 5.5L5.5915 5.697C5.75718 5.75223 5.90774 5.84528 6.03123 5.96877C6.15472 6.09226 6.24777 6.24282 6.303 6.4085L6.5 7L6.697 6.4085C6.75223 6.24282 6.84528 6.09226 6.96877 5.96877C7.09226 5.84528 7.24282 5.75223 7.4085 5.697L8 5.5L7.4085 5.303C7.24282 5.24777 7.09226 5.15472 6.96877 5.03123C6.84528 4.90774 6.75223 4.75718 6.697 4.5915L6.5 4Z">
                                        </path>
                                    </svg>
                                    <p class="gallary-details-card-loader__text">@lang('Processing Your Image...')</p>
                                </div>
                            </div>
                            <div class="view-details-card-content">
                                <div class="view-details-card-content__body">
                                    <h5 class="view-details-card__title">@lang('Prompt')</h5>
                                    <div class="toggle-content">
                                        <p class="view-details-card__prompt toggle-content__text ai-prompt-text"></p>
                                        <button class="toggle-content__btn seeBtn" type="button">
                                            @lang('See More')
                                        </button>
                                    </div>

                                    <div class="view-details-card__block">
                                        <div class="view-details-card-engine">
                                            <span class="label">@lang('AI Engine')</span>
                                            <span class="value ai-engine-name">@lang('Google Imagen 4')</span>
                                        </div>
                                    </div>

                                    <div class="view-details-card__block">
                                        <div class="view-details-card__action">
                                            <a class="view-details-card__btn download-link" href="javascript:void(0)">
                                                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                class="sparkle">
                                <defs>
                                    <linearGradient id="starGradient">
                                        <stop offset="0%" stop-color="hsl(var(--base))" />
                                        <stop offset="29.81%" stop-color="hsl(var(--base-two))" />
                                        <stop offset="64.42%" stop-color="hsl(var(--base-three))" />
                                        <stop offset="100%" stop-color="hsl(var(--base-four))" />
                                    </linearGradient>
                                </defs>
                                <path class="path" stroke-linejoin="round" stroke-linecap="round"
                                    stroke="url(#starGradient)" fill="url(#starGradient)"
                                    d="M14.187 8.096L15 5.25L15.813 8.096C16.0231 8.83114 16.4171 9.50062 16.9577 10.0413C17.4984 10.5819 18.1679 10.9759 18.903 11.186L21.75 12L18.904 12.813C18.1689 13.0231 17.4994 13.4171 16.9587 13.9577C16.4181 14.4984 16.0241 15.1679 15.814 15.903L15 18.75L14.187 15.904C13.9769 15.1689 13.5829 14.4994 13.0423 13.9587C12.5016 13.4181 11.8321 13.0241 11.097 12.814L8.25 12L11.096 11.187C11.8311 10.9769 12.5006 10.5829 13.0413 10.0423C13.5819 9.50162 13.9759 8.83214 14.186 8.097L14.187 8.096Z">
                                </path>
                                <path class="path" stroke-linejoin="round" stroke-linecap="round"
                                    stroke="url(#starGradient)" fill="url(#starGradient)"
                                    d="M6 14.25L5.741 15.285C5.59267 15.8785 5.28579 16.4206 4.85319 16.8532C4.42059 17.2858 3.87853 17.5927 3.285 17.741L2.25 18L3.285 18.259C3.87853 18.4073 4.42059 18.7142 4.85319 19.1468C5.28579 19.5794 5.59267 20.1215 5.741 20.715L6 21.75L6.259 20.715C6.40725 20.1216 6.71398 19.5796 7.14639 19.147C7.5788 18.7144 8.12065 18.4075 8.714 18.259L9.75 18L8.714 17.741C8.12065 17.5925 7.5788 17.2856 7.14639 16.853C6.71398 16.4204 6.40725 15.8784 6.259 15.285L6 14.25Z">
                                </path>
                                <path class="path" stroke-linejoin="round" stroke-linecap="round"
                                    stroke="url(#starGradient)" fill="url(#starGradient)"
                                    d="M6.5 4L6.303 4.5915C6.24777 4.75718 6.15472 4.90774 6.03123 5.03123C5.90774 5.15472 5.75718 5.24777 5.5915 5.303L5 5.5L5.5915 5.697C5.75718 5.75223 5.90774 5.84528 6.03123 5.96877C6.15472 6.09226 6.24777 6.24282 6.303 6.4085L6.5 7L6.697 6.4085C6.75223 6.24282 6.84528 6.09226 6.96877 5.96877C7.09226 5.84528 7.24282 5.75223 7.4085 5.697L8 5.5L7.4085 5.303C7.24282 5.24777 7.09226 5.15472 6.96877 5.03123C6.84528 4.90774 6.75223 4.75718 6.697 4.5915L6.5 4Z">
                                </path>
                            </svg>
                                                <span class="download-text">@lang('Wait Few Moments...')</span>
                                            </a>
                                        </div>

                                    </div>
                                </div>
                                <div class="view-details-card-content__footer justify-content-end">
                                    <button type="button" class="btn btn--sm btn--base text-end" data-bs-dismiss="modal">
                                        @lang('Close')
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection


@push('script-lib')
    <script src="{{ asset('assets/admin/js/spectrum.js') }}"></script>
@endpush

@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/spectrum.css') }}">
@endpush


@push('script')
    <script>
        $(document).ready(function() {
            $('#generate-logo-btn').on('click', function() {
                let brandName = $('#brand-name').val();
                let removeBackground = $('#remove-background').is(':checked') ? true : false;
                let logoCount = parseInt($('#logo-count').val()) || 1;
                let fontName = $('select[name=font_name]').val();
                let categoryId = $('select[name=category_id]').val();
                let colorCode = $('.colorCode').val();
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
                    },
                    {
                        value: categoryId,
                        message: "Category is required!"
                    }
                ];

                for (const {
                        value,
                        message
                    }
                    of validations) {
                    if (!value || value == 0) {
                        notify("error", message);
                        return;
                    }
                }

                $.ajax({
                    url: "{{ route('user.logo.generate') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        brandName,
                        removeBackground,
                        logoCount,
                        fontName,
                        categoryId,
                        colorCode,
                        prompt
                    },
                    beforeSend: function() {
                        let modalEl = document.getElementById('adsGenerateModal');
                        window.adsModal = new bootstrap.Modal(modalEl);
                        let modal = $("#adsGenerateModal");
                        modal.find('.ai-prompt-text').text(prompt);
                        modal.find('.ai-engine-name').text('Google Gemini');
                        modal.find('.gen-loader').removeClass('d-none');
                        window.adsModal.show();
                        $('#generate-logo-btn').prop('disabled', true).text('Generating...');
                    },
                    success: function(res) {
                        if (window.adsModal) {
                            window.adsModal.hide();
                        }
                        $('#generate-logo-btn').prop('disabled', false).text('Generate Logo');
                        if (res.status === 'success' && res.data) {
                            let html = `
                                <div class="row g-3 justify-content-center">
                            `;
                            res.data.forEach(function(item) {
                                html += `
                                    <div class="col-md-4 col-sm-6 col-12 text-center">
                                        <div class="card border-0 shadow-sm p-2">
                                            <img src="${res.path}/${item}" alt="@lang('Generated Logo')" class="mb-2">
                                            <a href="${res.path}/${item}" download class="btn btn--sm btn--base w-100">
                                                <i class="las la-download"></i>@lang('Download')
                                            </a>
                                        </div>
                                    </div>
                                `;
                            });
                            html += `</div>`;
                            $('.create__logo__thumb').html(html);
                        } else {
                            notify('error', res.message || 'No logos generated.');
                        }
                    },
                    error: function(xhr) {
                        if (window.adsModal) {
                            window.adsModal.hide();
                        }
                        $('#generate-logo-btn').prop('disabled', false).text('Generate Logo');
                        notify('error', 'Something went wrong!');
                    }
                });
            });
        });
    </script>

    <script>
        (function($) {
            "use strict";
            $('.colorPicker').each(function() {
                let colorInput = $(this).siblings('.colorCode');
                let currentColor = colorInput.val();
                $(this).spectrum({
                    color: `#${currentColor}`,
                    showInput: true,
                    preferredFormat: "hex",
                    change: function(color) {
                        colorInput.val(color.toHex().replace(/^#/, ''));
                    }
                });
            });

            $('.colorCode').on('input', function() {
                let clr = $(this).val().trim();
                let colorPicker = $(this).siblings('.colorPicker');
                if (/^[0-9A-Fa-f]{6}$/.test(clr)) {
                    colorPicker.spectrum("set", `#${clr}`);
                }
            });

        })(jQuery);
    </script>
@endpush

@push('style')
    <style>
        .custom-select-with-icon {
            background: url('{{ getImage(getFilePath('shape') . 'dropdown1.svg') }}') no-repeat 8px center / 18px auto;
            padding-left: 35px;
        }

        .custom-select-with-category-icon {
            background: url('{{ getImage(getFilePath('shape') . 'dropdown3.svg') }}') no-repeat 8px center / 18px auto;
            padding-left: 35px;
        }

        .create__logo__thumb img {
            transition: transform 0.3s ease;
        }

        .create__logo__thumb img:hover {
            transform: scale(1.05);
        }

        .card {
            border: 1px solid hsl(var(--black) / 0.03) !important;
        }

        .create__logo__thumb {
            padding: 0%;
        }
    </style>
@endpush
