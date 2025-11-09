@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="dashboard__wrapper">
        <div class="row g-4 justify-content-center">
            <div class="col-lg-12">
                <div class="dashboard-table">
                    <div class="dashboard__table">
                        <div class="table__topbar">
                            <h5 class="mb-0">@lang('Support Ticket')</h5>
                            <div class="table__topbar__right">
                                <div class="search__box">
                                    <form action="">
                                        <div class="search__box">
                                            <a href="{{ route('ticket.open') }}" class="btn btn--md btn--base w-100">
                                                <i class="fa fa-plus"></i> @lang('New Ticket')
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <table class="table table--responsive--md">
                            <thead>
                                <tr>
                                    <th>@lang('Subject')</th>
                                    <th class="text-center">@lang('Status')</th>
                                    <th class="text-center">@lang('Priority')</th>
                                    <th class="text-center">@lang('Last Reply')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($supports as $support)
                                    <tr>
                                        <td> <a href="{{ route('ticket.view', $support->ticket) }}" class="fw--500">
                                                [@lang('Ticket')#{{ $support->ticket }}] {{ __($support->subject) }}
                                            </a></td>
                                        <td>
                                            @php echo $support->statusBadge; @endphp
                                        </td>
                                        <td>
                                            @if ($support->priority == 1)
                                                <span class="badge badge--secondary">@lang('Low')</span>
                                            @elseif($support->priority == 2)
                                                <span class="badge badge--success">@lang('Medium')</span>
                                            @elseif($support->priority == 3)
                                                <span class="badge badge--base">@lang('High')</span>
                                            @endif
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($support->last_reply)->diffForHumans() }} </td>
                                        <td>
                                            <a href="{{ route('ticket.view', $support->ticket) }}"
                                                class="btn btn--base btn--sm">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-center">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $supports->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
