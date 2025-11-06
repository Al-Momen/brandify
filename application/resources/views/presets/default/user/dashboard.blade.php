@php
    $user = auth()->user();
@endphp
@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="dashboard__wrapper">
        <div class="row g-4">
            <div class="col-xxl-3 col-sm-6">
                <div class="d-block w-100">
                    <div class="dashboard__card card">
                        <div class="dashboard__card__item">
                            <span class="dashboard__card__icon"><i class="fas fa-coins"></i></span>
                            <p>Balance</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h3 class="dashboard__card__price">$140.00</h3>
                            <a class="dashboard__card__btn-text" href="#">View All<span><i
                                        class="fa-solid fa-arrow-right"></i></span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-sm-6">
                <div class="d-block w-100">
                    <div class="dashboard__card card">
                        <div class="dashboard__card__item">
                            <span class="dashboard__card__icon"><i class="fas fa-coins"></i></span>
                            <p>Total Logo</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h3 class="dashboard__card__price">$140.00</h3>
                            <a class="dashboard__card__btn-text" href="#">View All<span><i
                                        class="fa-solid fa-arrow-right"></i></span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-sm-6">
                <div class="d-block w-100">
                    <div class="dashboard__card card">
                        <div class="dashboard__card__item">
                            <span class="dashboard__card__icon"><i class="fas fa-coins"></i></span>
                            <p>Total Brand Kit</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h3 class="dashboard__card__price">$140.00</h3>
                            <a class="dashboard__card__btn-text" href="#">View All<span><i
                                        class="fa-solid fa-arrow-right"></i></span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-sm-6">
                <div class="d-block w-100">
                    <div class="dashboard__card card">
                        <div class="dashboard__card__item">
                            <span class="dashboard__card__icon"><i class="fas fa-coins"></i></span>
                            <p> Subscription</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h3 class="dashboard__card__price">$140.00</h3>
                            <a class="dashboard__card__btn-text" href="#">View All<span><i
                                        class="fa-solid fa-arrow-right"></i></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="dashboard-table">
                    <div class="table__topbar">
                        <h5>@lang('Latest Transactions')</h5>
                        <div class="table__topbar__right">
                            <div class="search__box">
                                <input type="text" class="form-control" placeholder="Search">
                                <button type="submit">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="dashboard__table">
                        <table class="table table--responsive--md">
                            <thead>
                                <tr>
                                    <th>@lang('Trx')</th>
                                    <th class="text-center">@lang('Transacted')</th>
                                    <th class="text-center">@lang('Amount')</th>
                                    <th class="text-center">@lang('Post Credit')</th>
                                    <th class="text-center">@lang('Post Balance')</th>
                                    <th>@lang('Detail')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $trx)
                                    <tr>
                                        <td>{{ $trx->trx }}</td>

                                        <td class="text-center">
                                            {{ showDateTime($trx->created_at) }}
                                        </td>

                                        <td class="text-center">
                                            <span
                                                class="@if ($trx->trx_type == '+') text-success @else text-danger @endif">
                                                {{ $trx->trx_type }} {{ showAmount($trx->amount) }}
                                                {{ $general->cur_text }}
                                            </span>
                                        </td>

                                        <td class="text-center">
                                            {{ $trx->post_credit }}
                                        </td>

                                        <td class="text-center">
                                            {{ showAmount($trx->post_balance) }}
                                            {{ __($general->cur_text) }}
                                        </td>

                                        <td>{{ __($trx->details) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="100%">
                                            {{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
