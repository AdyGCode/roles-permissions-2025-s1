<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticPageController extends Controller
{

    function index(){
        return view('static.welcome');

    }

    function dashboard(){
        return view('static.dashboard');

    }

    function admin(){
            return view('admin.index');
    }

}
