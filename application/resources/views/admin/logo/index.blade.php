@extends('admin.layouts.app')
@section('panel')
    <form method="GET" id="statusForm">
        <div class="row gy-4 justify-content-between mb-3 pb-3">
            <div class="col-xl-4 col-lg-6">
                <div class="d-flex flex-wrap justify-content-start">
                    <div class="search-input--wrap position-relative">
                        <input type="text" name="search" class="form-control" placeholder="@lang('Search brand name')..."
                            value="{{ request()->search ?? '' }}">
                        <button class="search--btn position-absolute"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="row gy-4">
        <div class="col-md-12 mb-30">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two custom-data-table">
                            <thead>
                                <tr>
                                    <th>@lang('SI')</th>
                                    <th>@lang('Username')</th>
                                    <th>@lang('Brand Name')</th>
                                    <th>@lang('Category')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody id="items_table__body">
                                @forelse($logos as $logo)
                                    <tr>
                                        <td>#{{ $loop->iteration }}</td>
                                        <td data-label="Username">
                                            <a href="{{ route('admin.users.detail', $logo->user->id) }}">
                                                {{ $logo->user?->fullname }}
                                                <p>{{ '@' . $logo->user?->username }}</p>
                                            </a>
                                        </td>

                                        <td data-label="Brand Name">
                                            {{ __($logo->brand_name) }}
                                        </td>

                                        <td data-label="Brand Name">
                                            {{ __($logo->category->name) }}
                                        </td>

                                        <td>
                                            <div class="d-flex align-items-center justify-content-end gap-2">

                                                <button class="btn btn-sm viewLogoBtn" title="@lang('View')"
                                                    data-id="{{ $logo->id }}">
                                                    <i class="fa-solid fa-eye"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="pagination-wrapper" class="pagination__wrapper py-4 {{ $logos->hasPages() ? '' : 'd-none' }}">
                    @if ($logos->hasPages())
                        {{ paginateLinks($logos) }}
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- View MODAL --}}
    <div class="modal fade" id="viewLogoModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="viewModalLabel">@lang('Logo Details')</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row gy-3">
                        <div class="col-md-6">
                            <label class="fw-bold">@lang('Brand Name')</label>
                            <p class="text-muted" id="logoBrandName">—</p>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold">@lang('Category')</label>
                            <p class="text-muted" id="logoCategory">—</p>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold">@lang('Created By')</label>
                            <p class="text-muted" id="logoUser">—</p>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold">@lang('Font Style')</label>
                            <p class="text-muted" id="logoFont">—</p>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold">@lang('Created At')</label>
                            <p class="text-muted" id="logoCreatedAt">—</p>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold">@lang('Color')</label>
                            <div class="d-flex align-items-center gap-2">
                                <span id="logoColorCode" class="text-muted">—</span>
                                <span id="colorPreview"
                                    style="width:25px;height:25px;border-radius:50%;border:1px solid #ddd;"></span>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <h6 class="fw-bold mt-3">@lang('Generated Logos')</h6>
                    <div id="logoImages" class="row g-3 mt-2 text-center">
                        <p class="text-muted">@lang('No Images Found')</p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn--sm btn--base text--white" data-bs-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>



@endsection

@push('script')
    <script>
        $(document).on('click', '.viewLogoBtn', function() {
            let id = $(this).data('id');
            let modal = $('#viewLogoModal');
            let url = "{{ route('admin.logo.view', ':id') }}".replace(':id', id);

            $.ajax({
                url: url,
                method: "GET",
                beforeSend: function() {
                    modal.find('#logoBrandName').text('Loading...');
                    modal.find('#logoCategory').text('...');
                    modal.find('#logoUser').text('...');
                    modal.find('#logoFont').text('...');
                    modal.find('#logoColorCode').text('...');
                    modal.find('#logoCreatedAt').text('...');
                    modal.find('#logoImages').html('<p class="text-center text-muted">Loading...</p>');
                },
                success: function(res) {
                    if (res.status === 'success') {
                        let data = res.data;

                        modal.find('#logoBrandName').text(data.brand_name ?? '—');
                        modal.find('#logoCategory').text(data.category?.name ?? '—');
                        modal.find('#logoCategory').text(data.category?.name ?? '—');
                        modal.find('#logoUser').text("@" + data.user.username ?? '—');
                        modal.find('#logoFont').text(data.font_style ?? '—');
                        modal.find('#logoColorCode').text(data.color ?? '—');
                        modal.find('#colorPreview').css('background-color', '#'+data.color ?? '#fff');
                        let createdAt = data.created_at ? new Date(data.created_at) : null;

                        if (createdAt) {

                            let formattedDate = createdAt.toLocaleString('en-GB', {
                                day: '2-digit',
                                month: 'short',
                                year: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit',
                                hour12: true,
                            });
                            modal.find('#logoCreatedAt').text(formattedDate);
                        } else {
                            modal.find('#logoCreatedAt').text('—');
                        }

                        let imgHTML = '';
                        if (data.logo_images && data.logo_images.length > 0) {
                            imgHTML += `<div class="row">`;
                            data.logo_images.forEach(img => {
                                imgHTML += `
                            <div class="col-md-4">
                                <img src="${"{{ asset(getFilePath('generate_logo')) }}" + '/' + img.image}" 
                                     class="img-fluid rounded border shadow-sm mb-2" alt="logo">
                            </div>
                        `;
                            });
                            imgHTML += `</div>`;
                        } else {
                            imgHTML = `<p class="text-center text-muted">No images available</p>`;
                        }

                        modal.find('#logoImages').html(imgHTML);
                    }
                },
                error: function() {
                    notify('error', 'Failed to load logo details!');
                }
            });

            modal.modal('show');
        });
    </script>
@endpush
