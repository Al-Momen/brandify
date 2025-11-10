@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="dashboard__wrapper">
        <div class="row g-4 justify-content-center">
            <div class="col-lg-12">
                <div class="dashboard-table">
                    <div class="dashboard__table">
                        <div class="table__topbar">
                            <h5>{{__($pageTitle)}}</h5>
                            <div class="table__topbar__right">
                                <div class="search__box">
                                    <form action="">
                                        <div class="search__box">
                                            <input type="text" class="form-control" name="search"
                                                value="{{ request()->search }}" placeholder="@lang('Search TRX')">
                                            <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <table class="table table--responsive--md">
                            <thead>
                                <tr>
                                    <th>@lang('TRX No')</th>
                                    <th class="text-center">@lang('Gateway')</th>
                                    <th class="text-center">@lang('Date')</th>
                                    <th class="text-center">@lang('Amount')</th>
                                    <th class="text-center">@lang('Conversion')</th>
                                    <th class="text-center">@lang('Status')</th>
                                    <th>@lang('Details')</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @forelse($deposits as $deposit)
                                    <tr>
                                        <td data-label="@lang('TRX No')">{{ __($deposit->trx) }}</td>
                                        <td data-label="@lang('Gateway')">{{ __($deposit->gateway?->name) }}</td>
                                        <td data-label="@lang('Date')" class="text-center">
                                            {{ showDateTime($deposit->created_at) }}</td>
                                        <td data-label="@lang('Amount')" class="text-center">
                                            {{ __($general->cur_sym) . showAmount($deposit->amount) }}</td>
                                        <td data-label="@lang('Conversion')" class="text-center">
                                            {{ __($deposit->method_currency) . showAmount($deposit->final_amo) }}</td>
                                        <td data-label="@lang('Status')" class="text-center">@php echo $deposit->statusBadge @endphp</td>

                                        @php
                                            $details = $deposit->detail != null ? json_encode($deposit->detail) : null;
                                        @endphp

                                        <td data-label="@lang('Details')">
                                            <a href="javascript:void(0)"
                                                class="btn btn--base btn--sm action--btn @if ($deposit->method_code >= 1000) detailBtn @else disabled @endif"
                                                @if ($deposit->method_code >= 1000) data-info="{{ $details }}" @endif
                                                @if ($deposit->status == 3) data-admin_feedback="{{ $deposit->admin_feedback }}" @endif>
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-center">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse --}}
                            </tbody>
                        </table>
                    </div>
                    {{-- {{ $deposits->links() }} --}}
                </div>
            </div>
        </div>
    </div>
@endsection
