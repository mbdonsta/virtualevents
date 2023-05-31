@extends('backend.events.parts.wrapper')

@section('event_wrapper_content')
    @include('global.notices')
    <div class="card card-flush pt-20">
        <!--begin::Card body-->
        <div class="card-body py-0">
            <div class="row">
                <div class="col-md-4">
                    <div class="bg-primary text-white text-center p-5 rounded mb-3">
                        <div class="number mb-3">
                            <div class="fs-2hx">{{ $totalVisitors }}</div>
                        </div>
                        <p class="fs-3">{{ __('Total participants visits') }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="bg-info text-white text-center p-5 rounded mb-3">
                        <div class="number mb-3">
                            <div class="fs-2hx">~0</div>
                        </div>
                        <p class="fs-3">{{ __('Total participants online') }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="bg-primary text-white text-center p-5 rounded mb-3">
                        <div class="number mb-3">
                            <div class="fs-2hx">{{ $totalInvited }}</div>
                        </div>
                        <p class="fs-3">{{ __('Total participants invited') }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="bg-info text-white text-center p-5 rounded mb-3">
                        <div class="number mb-3">
                            <div class="fs-2hx">{{ $totalProgramVisits }}</div>
                        </div>
                        <p class="fs-3">{{ __('Total program visits') }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="bg-primary text-white text-center p-5 rounded mb-3">
                        <div class="number mb-3">
                            <div class="fs-2hx">{{ $totalExhibitionVisits }}</div>
                        </div>
                        <p class="fs-3">{{ __('Total exhibition visits') }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="bg-info text-white text-center p-5 rounded mb-3">
                        <div class="number mb-3">
                            <div class="fs-2hx">{{ $totalPostersVisits }}</div>
                        </div>
                        <p class="fs-3">{{ __('Total poster visits') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Card body-->
    </div>
@stop
