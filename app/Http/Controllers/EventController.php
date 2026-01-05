<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;

use App\Models\Event;

class EventController extends Controller {


    public function index () {

        $all_events = Event::all();

        return view('admin.event.index', [
            'all_events' => $all_events,
        ]);

    }


    public function addEvent(Request $request) {

        $created_by = Auth::user()->id;
        $event_id = $request->input('event_id');

        if ($event_id == 0) $event = new Event();
        else $event = Event::find($event_id);

        $event->event_name = $request->input('event_name');
        $event->event_description = $request->input('event_description');
        $event->event_date = date("Y-m-d", strtotime($request->input('event_date')));;
        $event->status = $request->input('status');
        $event->default_event = $request->input('default_event');
        $event->featured_event = $request->input('featured_event');
        $event->created_by = $created_by;

        $event->save();
        $event_id = $event->event_id;

        $event->updateEventStatus();

        if ($request->hasFile('event_image')) {

            $destinationPath = 'site/images/events';
            $event_image = $request->file('event_image');
            $imageName = 'event_' . $event_id . '.' . $event_image->getClientOriginalExtension();
            $event_image->move($destinationPath, $imageName);

            $event->event_image = $imageName;
            $event->save();

        }

        return json_encode($event_id);
    }


    public function editEvent(Request $request) {

        $event_id = $request->input('event_id');
        $event = Event::find($event_id);

        $event->event_name = $request->input('event_name');
        $event->event_description = $request->input('event_description');
        $event->event_date = date("Y-m-d", strtotime($request->input('event_date')));;
        $event->status = $request->input('status');

        $event->save();

        if ($request->hasFile('event_image')) {

            $destinationPath = 'site/images/events';
            $event_image = $request->file('event_image');
            $imageName = 'event_' . $event_id . '.' . $event_image->getClientOriginalExtension();
            $event_image->move($destinationPath, $imageName);

            $event->event_image = $imageName;
            $event->save();

        }

        return json_encode('success');
    }


    public function deleteEvent(Request $request) {

        $data = $request->input('params');

        $event = Event::find($data['event_id']);
        $event->delete();

        return json_encode("success");
    }

}
