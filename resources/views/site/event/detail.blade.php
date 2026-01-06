@extends('layouts.site')

@section('title', $event->event_name)
@section('subtitle', 'Football Event Details')

@section('content')

    <section class="event-details-section py-5">
        <div class="container">

            <!-- Back + Breadcrumb -->
            <div class="row mb-4">
                <div class="col-12">
                    <a href="{{ route('event') }}" class="btn btn-outline-primary mb-3">
                        <i class="fas fa-arrow-left me-2"></i> Back to Events
                    </a>

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('event') }}">Events</a></li>
                            <li class="breadcrumb-item active">Event Details</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row">

                <!-- LEFT -->
                <div class="col-lg-8">

                @php
                    $eventDate = \Carbon\Carbon::parse($event->event_date);
                    $isUpcoming = $eventDate->isFuture();
                    $isToday = $eventDate->isToday();
                    $daysUntil = $eventDate->diffInDays(now());
                @endphp

                <!-- Header -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    @if($isToday)
                                        <span class="badge bg-danger px-3 py-2 me-2">Happening Today</span>
                                    @elseif($isUpcoming)
                                        <span class="badge bg-success px-3 py-2 me-2">
                                        {{ $daysUntil == 1 ? 'Tomorrow' : 'In '.$daysUntil.' Days' }}
                                    </span>
                                    @else
                                        <span class="badge bg-secondary px-3 py-2 me-2">Past Event</span>
                                    @endif

                                    @if($event->featured_event == '1')
                                        <span class="badge bg-warning text-dark px-3 py-2">Featured</span>
                                    @endif
                                </div>
                            </div>

                            <h1 class="display-6 fw-bold text-primary mb-3">{{ $event->event_name }}</h1>

                            <div class="d-flex align-items-center">
                                <div class="bg-primary text-white rounded-circle p-3 me-3">
                                    <i class="far fa-calendar-alt"></i>
                                </div>
                                <div>
                                    <small class="text-muted">Event Date</small>
                                    <div class="fw-bold fs-5">
                                        {{ $eventDate->format('l, F jS, Y') }}
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Image -->
                    <div class="card border-0 shadow-sm mb-4 overflow-hidden">
                        <img src="{{ asset('site/images/events/'.$event->event_image) }}"
                             class="img-fluid"
                             style="max-height: 450px; object-fit: cover;"
                             onerror="this.src='{{ asset('site/images/events/default_event.jpg') }}'">
                    </div>

                    <!-- Description -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">

                            <h3 class="mb-3">
                                <i class="fas fa-info-circle text-primary me-2"></i>
                                Event Description
                            </h3>

                            @if(!empty(trim(strip_tags($event->event_description))))
                                <div class="event-content p-4 rounded-3">
                                    {!! $event->event_description !!}
                                </div>
                            @else
                                <div class="alert alert-light border text-muted">
                                    No description available for this event.
                                </div>
                            @endif

                        </div>
                    </div>

                </div>

                <!-- RIGHT -->
                <div class="col-lg-4">

                    <div class="card border-0 shadow-sm">
                        <div class="card-body">

                            <h5 class="mb-3">
                                <i class="fas fa-clipboard-list text-primary me-2"></i>
                                Quick Facts
                            </h5>

                            <ul class="list-unstyled">
                                <li class="mb-3 d-flex justify-content-between">
                                    <span class="text-muted">Status</span>
                                    <strong>
                                        {{ $isToday ? 'Live Today' : ($isUpcoming ? 'Upcoming' : 'Completed') }}
                                    </strong>
                                </li>

                                <li class="mb-3 d-flex justify-content-between">
                                    <span class="text-muted">Published</span>
                                    <strong>{{ $event->created_at->diffForHumans() }}</strong>
                                </li>

                                <li class="mb-3 d-flex justify-content-between">
                                    <span class="text-muted">Organizer</span>
                                    <strong>Football Association</strong>
                                </li>

                                <li class="mb-3 d-flex justify-content-between">
                                    <span class="text-muted">Posted By</span>
                                    <strong>Admin</strong>
                                </li>
                            </ul>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>

    <style>
        .event-content,
        .event-content * {
            color: #222 !important;
        }

        .event-content {
            background: linear-gradient(135deg, #f8fafc, #eef2f7);
            border-left: 5px solid #0d6efd;
            font-size: 1.05rem;
            line-height: 1.8;
        }
    </style>

@endsection
