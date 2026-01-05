@extends('layouts.admin')
@section('title', 'Events')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card-box p-2">

                <button type="button" class="btn btn-sm btn-dark waves-effect waves-light float-right" onclick="createNewEvent();">
                    <i class="mdi mdi-plus-circle mr-1"></i>Add Event
                </button>

                <div class="table-responsive">
                    <table class="table table-sm table-hover mt-3">

                        <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Event Name</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Default</th>
                            <th>Featured</th>
                            <th class="text-center" width="20%">Action</th>
                        </tr>
                        </thead>

                        <tbody id="event_table">

                        @foreach($all_events as $event)
                            <tr id="event_{{ $event->event_id }}">
                                <td>{{ $loop->index + 1 }}</td>
                                <td><a href="/event/{{ $event->event_id }}" target="_blank">{{ $event->event_name }}</a></td>
                                <td>{{ formatDate($event->event_date) }}</td>

                                <td>
                                    @if($event->status == '1')
                                        <span class="badge badge-success font-14">Active</span>
                                    @else
                                        <span class="badge badge-danger font-14">Inactive</span>
                                    @endif
                                </td>

                                <td>
                                    @if($event->default_event == '1')
                                        <span class="badge badge-success font-14">Yes</span>
                                    @else
                                        <span class="badge badge-warning font-14">No</span>
                                    @endif
                                </td>

                                <td>
                                    @if($event->featured_event == '1')
                                        <span class="badge badge-success font-14">Yes</span>
                                    @else
                                        <span class="badge badge-warning font-14">No</span>
                                    @endif
                                </td>

                                <td class="text-center">

                                    <button type="button" class="btn btn-blue btn-xs waves-effect waves-light"
                                            onclick="editEvent(this)"
                                            data-id="{{ $event->event_id }}"
                                            data-name="{{ $event->event_name }}"
                                            data-description="{!! htmlspecialchars($event->event_description, ENT_QUOTES, 'UTF-8') !!}"
                                            data-image="{{ $event->event_image }}"
                                            data-date="{{ date('m/d/Y', strtotime($event->event_date)) }}"
                                            data-status="{{ $event->status }}"
                                            data-default-event="{{ $event->default_event }}"
                                            data-featured-event="{{ $event->featured_event }}"
                                            title="Edit Event">
                                        <i class="fe-edit"></i>
                                    </button>

                                    <button type="button" class="btn btn-xs btn-danger waves-effect waves-light" onclick="destroyEvent({{ $event->event_id }})" title="Delete Section">
                                        <i class="fe-trash-2"></i>
                                    </button>

                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>

                </div>

            </div>
        </div>
    </div>

    <div id="add_event_modal" class="modal bounceInDown animated">
        <div class="modal-dialog modal-full">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Add New Event</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body p-4">

                    <input type="hidden" id="event_id" value="0">

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="event_name" class="control-label">Event Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="event_name" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="event_date" class="control-label">Event Date <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="event_date" data-provide="datepicker" data-date-autoclose="true" value="{{ date('m/d/Y') }}">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="summernote-editor" class="control-label">Event Description</label>
                                <textarea id="summernote-editor" name="message"></textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="event_image" class="control-label">Event Image</label>
                                <input type="file" class="form-control" id="event_image" name="event_image" onchange="viewSelectedImage(this, 'add_event_image');">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <img id="add_event_image" src="" alt="logo" class="img-fluid rounded float-right" style="width: 50%" onerror="this.onerror=null; this.src='/site/images/events/default_event.jpg'">
                        </div>

                        <div class="col-md-12">
                            <div class="form-group checkbox checkbox-primary mb-2">
                                <input id="event_status" type="checkbox" checked>
                                <label for="event_status">Active</label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group checkbox checkbox-primary mb-2">
                                <input id="default_event" type="checkbox">
                                <label for="default_event">Default Event</label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group checkbox checkbox-primary mb-2">
                                <input id="featured_event" type="checkbox">
                                <label for="featured_event">Featured Event</label>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-blue waves-effect waves-light" data-dismiss="modal" id="add_event_button">Save</button>
                </div>
            </div>
        </div>
    </div>

@endsection
