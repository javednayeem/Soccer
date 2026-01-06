<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use DB;


class Event extends Model {

    protected $table = 'events';
    protected $primaryKey = 'event_id';


    public function updateEventStatus() {

        $default_event = $this->default_event;
        $featured_event = $this->featured_event;

        if ($default_event == '1') {
            DB::table('events')->where('event_id', '<>', $this->event_id)->update(['default_event' => '0']);
        }

        if ($featured_event == '1') {
            #DB::table('events')->where('event_id', '<>', $this->event_id)->update(['featured_event' => '0']);
        }

    }

}
