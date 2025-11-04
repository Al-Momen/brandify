@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="dashboard__wrapper">
        <div class="row g-4 justify-content-center">
            <div class="col-xl-12">
                <div class="profile__wrap card p-4">
                    <div class="dashboard__table">
                        <div class="row g-4 justify-content-center">
                            <div class="col-lg-12">
                                <form id="formBuilder" action="{{ route('user.form.submit') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="form_builder_id" value="{{ $formBuilder->id }}">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <h4>{{ __($formBuilder->title) }}</h4>
                                        <a href="{{ route('user.form.all.form') }}" class="btn btn--base">@lang('Back')</a>
                                    </div>
                                    @foreach ($formBuilder->form_data['form'] as $index=> $field)
                                        <div class="mb-3 form-group">
                                            <label for="{{ $field['id'] }}" class="form--label"><span class="text--base fw--600">@lang("Question") {{$index+1 < 10 ? '0'.$index+1 : $index+1  }}:</span> {{ __($field['label']) }}
                                            </label>

                                            @if ($field['tag'] === 'input')
                                                <input type="{{ $field['type'] ?? 'text' }}" id="{{ $field['id'] }}"
                                                    name="{{ $field['id'] }}" class="form--control"
                                                    @if ($field['required']) required @endif>
                                            @elseif($field['tag'] === 'textarea')
                                                <textarea id="{{ $field['id'] }}" name="{{ $field['id'] }}" class="form--control"
                                                    @if ($field['required']) required @endif></textarea>
                                            @elseif($field['tag'] === 'select')
                                                <select id="{{ $field['id'] }}" name="{{ $field['id'] }}"
                                                    class="select2"
                                                    @if ($field['required']) required @endif>
                                                    @foreach ($field['options'] as $option)
                                                        <option value="{{ $option }}">{{ $option }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @elseif($field['tag'] === 'radio')
                                                @foreach ($field['options'] as $option)
                                                    <div class="form--radio mb-2">
                                                        <input class="form-check-input" type="radio"
                                                            name="{{ $field['id'] }}"
                                                            id="{{ $field['id'] . '_' . $loop->index }}"
                                                            value="{{ $option }}">
                                                        <label class="form-check-label"
                                                            for="{{ $field['id'] . '_' . $loop->index }}">{{ $option }}</label>
                                                    </div>
                                                @endforeach
                                            @elseif($field['tag'] === 'checkbox')
                                                @foreach ($field['options'] as $option)
                                                    <div class="form--check mb-2">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="{{ $field['id'] }}[]"
                                                            id="{{ $field['id'] . '_' . $loop->index }}"
                                                            value="{{ $option }}">
                                                        <label class="form-check-label"
                                                            for="{{ $field['id'] . '_' . $loop->index }}">{{ $option }}</label>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    @endforeach
                                    <div class=" text-end">
                                        <button type="submit" class="btn btn--base text-end">@lang('Submit')</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.getElementById('formBuilder').addEventListener('submit', function(e) {
            e.preventDefault();

            const form = this;
            const formData = [];
            const inputs = form.querySelectorAll('.form--control, .form-check-input');

            const addedNames = new Set();

            inputs.forEach((input) => {
                const name = input.name?.replace('[]', '');
                if (!name || addedNames.has(name)) return;
                addedNames.add(name);
                const sameInputs = form.querySelectorAll(`[name="${name}"], [name="${name}[]"]`);

                let answer = null;

                if (input.type === 'checkbox') {
                    const checkedValues = Array.from(sameInputs)
                        .filter((chk) => chk.checked)
                        .map((chk) => chk.value);
                    answer = checkedValues.length ? checkedValues : [];
                } else if (input.type === 'radio') {
                    const checked = Array.from(sameInputs).find((r) => r.checked);
                    answer = checked ? checked.value : null;
                } else {
                    answer = input.value.trim() || null;
                }
                const field = {
                    id: name,
                    label: input.dataset.label || input.labels?.[0]?.innerText?.trim() || "",
                    tag: input.dataset.tag || input.tagName.toLowerCase(),
                    type: input.type || null,
                    required: input.required || false,
                    answer: answer
                };

                if (['radio', 'checkbox'].includes(field.tag) && input.options) {
                    field.options = Array.from(input.options).map((opt) => opt.value);
                }
                formData.push(field);
            });

            const jsonPayload = {
                template: "Default Template",
                form: formData
            };

            let hidden = form.querySelector('input[name="form_json"]');
            if (!hidden) {
                hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = 'form_json';
                form.appendChild(hidden);
            }
            hidden.value = JSON.stringify(jsonPayload);

            // এবার submit করো
            form.submit();
        });
    </script>
@endpush
