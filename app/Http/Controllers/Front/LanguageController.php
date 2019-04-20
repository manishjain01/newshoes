<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Redirect;

class LanguageController extends Controller {

    public function index() {

        if (!\Session::has('locale')) {

            \Session::put('locale', Input::get('locale'));
        } else {
            \Session::set('locale', Input::get('locale'));
        }
        return Redirect::back();
    }

}
