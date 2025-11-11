<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller {


    public function index() {

        return view('site.home.index', [

        ]);

    }


    public function match() {

        return view('site.match.index', [

        ]);

    }


    public function player() {

        return view('site.player.index', [

        ]);

    }


    public function blog() {

        return view('site.blog.index', [

        ]);

    }


    public function contact() {

        return view('site.contact.index', [

        ]);

    }

}
