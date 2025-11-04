@extends('admin.layouts.app')
@section('panel')
<form method="GET" id="statusForm">
    <div class="row gy-4 justify-content-between mb-3 pb-3">
        <div class="col-xl-4 col-lg-6">
            <div class="d-flex flex-wrap justify-content-start">
               
                    <div class="search-input--wrap position-relative">
                        <input type="text" name="search" class="form-control" placeholder="@lang('Search name')..."
                            value="{{ request()->search ?? '' }}">
                        <button class="search--btn position-absolute"><i class="fa fa-search"></i></button>
                    </div>
              
            </div>
        </div>

        <div class="col-xl-2 col-lg-6">
            <div class="d-flex justify-content-end">
                <select id="status-filter" name="status" class="form-control form-select bg--transparent outline">
                    <option value="all" {{ request()->status == 'all' ? 'selected' : '' }}>@lang('All')</option>
                    <option value="enable" {{ request()->status == 'enable' ? 'selected' : '' }}>@lang('Enable')</option>
                    <option value="disable" {{ request()->status == 'disable' ? 'selected' : '' }}>@lang('Disable')
                    </option>
                </select>
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
                                    <th>@lang('Name')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody id="items_table__body">
                                @forelse($categories as $category)
                                    <tr>
                                        <td>#{{ $loop->iteration }}</td>

                                        <td>{{ $category->name }}</td>

                                        <td>
                                            @php
                                                echo $category->statusBadge($category->status);
                                            @endphp
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-end gap-2">
                                                <button type="button" class="btn btn-sm editCatBtn"
                                                    title="@lang('Edit')"
                                                    data-action="{{ route('admin.category.update', $category->id) }}"
                                                    data-name="{{ $category->name }}" data-status="{{ $category->status }}">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </button>

                                                <div class="form-group mb-0">
                                                    <label class="switch m-0" title="@lang($category->status ? 'Disable' : 'Enable')">
                                                        <input type="checkbox" class="toggle-switch confirmationBtn"
                                                            data-question="@lang('Are you sure to change this category status?')"
                                                            data-action="{{ route('admin.category.status', $category->id) }}"
                                                            @checked($category->status)>
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
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

                <div id="pagination-wrapper"
                    class="pagination__wrapper py-4 {{ $categories->hasPages() ? '' : 'd-none' }}">
                    @if ($categories->hasPages())
                        {{ paginateLinks($categories) }}
                    @endif
                </div>
            </div>
        </div>
    </div>


    @push('breadcrumb-plugins')
        <a href="javascript:void(0)" class="btn btn-sm btn--primary addCategory">@lang('Add New')</a>
    @endpush

    {{-- Add METHOD MODAL --}}
    <div id="addCityModel" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> @lang('Add Category')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.category.store') }}" class="edit-route" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>@lang('Category Name')</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="name" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mt-3">
                                    <label class="fw-bold">@lang('Status')</label>
                                    <label class="switch m-0">
                                        <input type="checkbox" class="toggle-switch" name="status">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary btn-global w-100">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- EDIT MODAL --}}
    <div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="editModalLabel">@lang('Update Category')</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>@lang('Name')</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" value="{{ old('name') }}"
                                            name="name" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mt-3">
                                    <label class="fw-bold">@lang('Status')</label>
                                    <label class="switch m-0">
                                        <input type="checkbox" class="toggle-switch" name="catstatus">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary w-100">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-confirmation-modal></x-confirmation-modal>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";

            $('.addCategory').on('click', function() {
                $('#addCityModel').modal('show');
            });

            $(document).on('click', '.editCatBtn', function() {
                var modal = $('#editCategoryModal');
                let url = $(this).data('action');
                let base = "{{ url('/') }}";


                $('#editForm').attr('action', url);
                modal.find('input[name="name"]').val($(this).data('name'));

                if ($(this).data('status') == 1) {
                    modal.find('input[name="catstatus"]').prop('checked', true);
                }

                if ($(this).data('status') == 0) {
                    modal.find('input[name="catstatus"]').prop('checked', false);
                }
                modal.modal('show');
            });


            $('#status-filter').on('change', function() {
                $('#statusForm').submit();
            });



        })(jQuery);
    </script>
@endpush
