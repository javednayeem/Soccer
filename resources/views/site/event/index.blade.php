@extends('layouts.site')
@section('title', 'Football News')
@section('subtitle', 'Stay updated with the latest football events, tournaments, and competitions')

@section('content')

    <section class="events-section py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12">
                    <div class="page-header">
                        <h1 class="display-4 fw-bold text-primary mb-3">Football News</h1>
                        <p class="lead text-muted">Explore upcoming matches, tournaments, and football competitions from around the world.</p>
                        <div class="header-stats d-flex gap-4 mt-4">
                            <div class="stat-item">
                                <span class="stat-number text-primary fw-bold">{{ $events->count() }}</span>
                                <span class="stat-label text-muted">Total Events</span>
                            </div>
                            @if($upcomingEvents->count() > 0)
                                <div class="stat-item">
                                    <span class="stat-number text-success fw-bold">{{ $upcomingEvents->count() }}</span>
                                    <span class="stat-label text-muted">Upcoming</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" id="eventsGrid">
                @forelse($events as $event)
                    <div class="col-lg-4 col-md-6 mb-4 event-item"
                         data-type="{{ strtolower($event->event_type ?? 'general') }}"
                         data-date="{{ $event->event_date }}">
                        <div class="event-card card h-100 border-0 shadow-sm overflow-hidden transition-all">
                            <!-- Event Image with Status Badge -->
                            <div class="event-image position-relative">
                                <img src="{{ asset('site/images/events/' . $event->event_image) }}"
                                     class="card-img-top"
                                     alt="{{ $event->event_name }}"
                                     style="height: 200px; object-fit: cover;"
                                     onerror="this.onerror=null; this.src='{{ asset('site/images/events/default-event.jpg') }}';">

                                <!-- Event Status Badge -->
                                @php
                                    $eventDate = \Carbon\Carbon::parse($event->event_date);
                                    $isUpcoming = $eventDate->isFuture();
                                    $isToday = $eventDate->isToday();
                                @endphp
                                <div class="event-status position-absolute top-0 end-0 m-3">
                                    @if($isToday)
                                        <span class="badge bg-danger px-3 py-2">
                                            <i class="fas fa-bolt me-1"></i> LIVE TODAY
                                        </span>
                                    @elseif($isUpcoming)
                                        <span class="badge bg-success px-3 py-2">
                                            <i class="fas fa-calendar-alt me-1"></i> UPCOMING
                                        </span>
                                    @else
                                        <span class="badge bg-secondary px-3 py-2">
                                            <i class="fas fa-history me-1"></i> PAST EVENT
                                        </span>
                                    @endif
                                </div>

                                <!-- Event Type Badge -->
                                @if($event->event_type)
                                    <div class="event-type position-absolute top-0 start-0 m-3">
                                        <span class="badge bg-primary px-3 py-2">
                                            {{ strtoupper($event->event_type) }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <!-- Event Content -->
                            <div class="card-body d-flex flex-column">
                                <!-- Event Date -->
                                <div class="event-date mb-2">
                                    <small class="text-muted">
                                        <i class="far fa-calendar-alt me-1"></i>
                                        {{ \Carbon\Carbon::parse($event->event_date)->format('F j, Y') }}
                                    </small>
                                    @if($event->event_time)
                                        <small class="text-muted ms-2">
                                            <i class="far fa-clock me-1"></i>
                                            {{ $event->event_time }}
                                        </small>
                                    @endif
                                </div>

                                <!-- Event Title -->
                                <h5 class="card-title mb-3">
                                    <a href="/event/{{ $event->event_id }}" class="text-dark text-decoration-none">
                                        {{ $event->event_name }}
                                    </a>
                                </h5>

                                <!-- Event Description -->
                                <p class="card-text text-muted flex-grow-1 mb-4">
                                    {{ Str::of(strip_tags($event->event_description))->words(25, '...') }}
                                </p>

                                <!-- Event Meta Information -->
                                <div class="event-meta mt-auto">
                                    <div class="row g-2">
                                        @if($event->venue)
                                            <div class="col-12">
                                                <small class="text-muted">
                                                    <i class="fas fa-map-marker-alt me-1"></i>
                                                    {{ $event->venue }}
                                                </small>
                                            </div>
                                        @endif
                                        @if($event->participating_teams)
                                            <div class="col-12">
                                                <small class="text-muted">
                                                    <i class="fas fa-users me-1"></i>
                                                    {{ $event->participating_teams }} Teams
                                                </small>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="event-actions d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                                    <a href="/event/{{ $event->event_id }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye me-1"></i> View Details
                                    </a>
                                    @if($isUpcoming && $event->ticket_url)
                                        <a href="{{ $event->ticket_url }}" target="_blank" class="btn btn-outline-success btn-sm">
                                            <i class="fas fa-ticket-alt me-1"></i> Get Tickets
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <div class="empty-state-icon mb-4">
                                <i class="fas fa-calendar-times fa-4x text-muted"></i>
                            </div>
                            <h3 class="text-muted mb-3">No Events Available</h3>
                            <p class="text-muted mb-4">There are currently no events scheduled. Check back later for updates.</p>
                            <a href="/" class="btn btn-primary">
                                <i class="fas fa-home me-1"></i> Back to Home
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            @if($events->hasPages())
                <div class="row mt-5">
                    <div class="col-12">
                        <nav aria-label="Events pagination">
                            <ul class="pagination justify-content-center">
                                {{ $events->links() }}
                            </ul>
                        </nav>
                    </div>
                </div>
            @endif

            @if($featuredEvents->count() > 0)
                <div class="row mt-5">
                    <div class="col-12">
                        <div class="section-header mb-4">
                            <h2 class="section-title fw-bold">
                                <i class="fas fa-star text-warning me-2"></i> Featured Events
                            </h2>
                            <p class="text-muted">Don't miss these major football events</p>
                        </div>

                        <div class="row">
                            @foreach($featuredEvents as $featuredEvent)
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <div class="featured-event-card card border-warning border-2 shadow-lg">
                                        <div class="card-body">
                                            <div class="featured-badge mb-3">
                                                <span class="badge bg-warning text-dark px-3 py-2">
                                                    <i class="fas fa-crown me-1"></i> FEATURED
                                                </span>
                                            </div>
                                            <h5 class="card-title text-dark">{{ $featuredEvent->event_name }}</h5>
                                            <p class="card-text text-dark">
                                                {{ Str::of(strip_tags($featuredEvent->event_description))->words(20, '...') }}
                                            </p>
                                            <a href="/event/{{ $featuredEvent->event_id }}" class="btn btn-warning">
                                                Learn More <i class="fas fa-arrow-right ms-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <style>
        /* Fix invisible text from theme */
        .event-card,
        .featured-event-card,
        .event-card * ,
        .featured-event-card * {
            color: #222 !important;
        }

        /* Card hover animation */
        .event-card {
            transition: all .3s ease;
        }
        .event-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 1rem 2rem rgba(0,0,0,.15);
        }

        /* Featured section polish */
        .featured-event-card {
            background: linear-gradient(135deg, #fff8e1, #fff3cd);
            border-radius: 14px;
        }
        .featured-event-card .card-title {
            font-weight: 700;
        }
        .featured-event-card .btn {
            border-radius: 50px;
        }

        /* Section header styling */
        .section-title {
            font-size: 2rem;
        }

        /* Make event images elegant */
        .event-image img {
            transition: transform .4s ease;
        }
        .event-card:hover .event-image img {
            transform: scale(1.05);
        }
    </style>


@endsection