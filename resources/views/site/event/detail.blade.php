@extends('layouts.site')
@section('title', $event->event_name)
@section('subtitle', 'Football Event Details')

@section('content')

    <section class="event-details-section py-5">
        <div class="container">

            <div class="row mb-4">
                <div class="col-12">
                    <a href="{{ route('event') }}" class="btn btn-outline-primary mb-3">
                        <i class="fas fa-arrow-left me-2"></i> Back to Events
                    </a>
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('event') }}">Events</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Event Details</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Left Column - Event Details -->
                <div class="col-lg-8">
                    <!-- Event Header -->
                    <div class="event-header card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <!-- Event Status Badge -->
                            @php
                                $eventDate = \Carbon\Carbon::parse($event->event_date);
                                $isUpcoming = $eventDate->isFuture();
                                $isToday = $eventDate->isToday();
                                $daysUntil = $eventDate->diffInDays(now());
                            @endphp

                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    @if($isToday)
                                        <span class="badge bg-danger px-3 py-2 mb-2">
                                        <i class="fas fa-bolt me-1"></i> HAPPENING TODAY
                                    </span>
                                    @elseif($isUpcoming)
                                        <span class="badge bg-success px-3 py-2 mb-2">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                            @if($daysUntil == 1)
                                                TOMORROW
                                            @else
                                                IN {{ $daysUntil }} DAYS
                                            @endif
                                    </span>
                                    @else
                                        <span class="badge bg-secondary px-3 py-2 mb-2">
                                        <i class="fas fa-history me-1"></i> PAST EVENT
                                    </span>
                                    @endif

                                    @if($event->featured_event == '1')
                                        <span class="badge bg-warning text-dark px-3 py-2 mb-2 ms-2">
                                        <i class="fas fa-star me-1"></i> FEATURED
                                    </span>
                                    @endif
                                </div>
                                <div class="text-muted">
                                    <small>
                                        <i class="far fa-eye me-1"></i>
                                        <span id="viewCount">{{ rand(150, 500) }}</span> views
                                    </small>
                                </div>
                            </div>

                            <!-- Event Title -->
                            <h1 class="display-5 fw-bold mb-3 text-primary">{{ $event->event_name }}</h1>

                            <!-- Event Date & Time -->
                            <div class="event-meta mb-4">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center">
                                            <div class="meta-icon bg-primary text-white rounded-circle p-3 me-3">
                                                <i class="far fa-calendar-alt fa-lg"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 text-muted">Event Date</h6>
                                                <p class="mb-0 fw-bold fs-5">
                                                    {{ \Carbon\Carbon::parse($event->event_date)->format('l, F jS, Y') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- If you add time field later -->
                                    @if(isset($event->event_time) && $event->event_time)
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center">
                                                <div class="meta-icon bg-success text-white rounded-circle p-3 me-3">
                                                    <i class="far fa-clock fa-lg"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 text-muted">Event Time</h6>
                                                    <p class="mb-0 fw-bold fs-5">
                                                        {{ \Carbon\Carbon::parse($event->event_time)->format('g:i A') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Event Image -->
                    <div class="event-image-card card border-0 shadow-sm mb-4 overflow-hidden">
                        <img src="{{ asset('site/images/events/' . $event->event_image) }}"
                             class="card-img-top"
                             alt="{{ $event->event_name }}"
                             style="max-height: 500px; object-fit: cover;"
                             onerror="this.onerror=null; this.src='{{ asset('site/images/events/default_event.jpg') }}';">
                        <div class="card-img-overlay d-flex align-items-end justify-content-center">
                            <div class="image-caption bg-dark bg-opacity-75 text-white p-3 rounded text-center">
                                <small>{{ $event->event_name }} - Football Event</small>
                            </div>
                        </div>
                    </div>

                    <!-- Event Description -->
                    <div class="event-description card border-0 shadow-sm mb-4">
                        <div class="">
                            <h3 class="card-title mb-4">
                                <i class="fas fa-info-circle text-primary me-2"></i>
                                Event Description
                            </h3>
                            <div class="event-content" style="background: #777777">
                                {!! $event->event_description !!}
                            </div>

                            @if(empty(strip_tags($event->event_description)))
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    No detailed description available for this event.
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Additional Information (if available) -->
                    @if(isset($event->venue) || isset($event->participating_teams))
                        <div class="additional-info card border-0 shadow-sm mb-4">
                            <div class="card-body">
                                <h3 class="card-title mb-4">
                                    <i class="fas fa-football-ball text-primary me-2"></i>
                                    Event Information
                                </h3>
                                <div class="row">
                                    @if(isset($event->venue))
                                        <div class="col-md-6 mb-3">
                                            <div class="info-item">
                                                <h6 class="text-muted mb-2">
                                                    <i class="fas fa-map-marker-alt me-2"></i>
                                                    Venue
                                                </h6>
                                                <p class="mb-0 fw-bold">{{ $event->venue }}</p>
                                            </div>
                                        </div>
                                    @endif

                                    @if(isset($event->participating_teams))
                                        <div class="col-md-6 mb-3">
                                            <div class="info-item">
                                                <h6 class="text-muted mb-2">
                                                    <i class="fas fa-users me-2"></i>
                                                    Participating Teams
                                                </h6>
                                                <p class="mb-0 fw-bold">{{ $event->participating_teams }} Teams</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right Column - Sidebar -->
                <div class="col-lg-4">
                    <!-- Event Quick Facts -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="fas fa-clipboard-list text-primary me-2"></i>
                                Quick Facts
                            </h5>
                            <ul class="list-unstyled">
                                <li class="mb-3">
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted">Status:</span>
                                        <span class="fw-bold">
                                        @if($isToday)
                                                <span class="text-success">Live Today</span>
                                            @elseif($isUpcoming)
                                                <span class="text-primary">Upcoming</span>
                                            @else
                                                <span class="text-secondary">Completed</span>
                                            @endif
                                    </span>
                                    </div>
                                </li>
                                <li class="mb-3">
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted">Published:</span>
                                        <span class="fw-bold">{{ $event->created_at->diffForHumans() }}</span>
                                    </div>
                                </li>
                                <li class="mb-3">
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted">Organizer:</span>
                                        <span class="fw-bold">Football Association</span>
                                    </div>
                                </li>
                                @if($event->created_by)
                                    <li class="mb-3">
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted">Posted By:</span>
                                            <span class="fw-bold">Admin</span>
                                        </div>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
