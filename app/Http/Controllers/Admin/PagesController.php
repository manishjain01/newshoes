<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Cms;
use App\Helpers\GlobalHelper;
use App\Helpers\BasicFunction;
class PagesController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $pageTitle = trans('admin.DASHBOARD');
        $title = trans('admin.DASHBOARD');

        $totalusers = User::where('role_id', 2)->get();
        $totalusers_count = count($totalusers);

        $todayusers = User::where('role_id', 2)->where('created_at','>=',date('Y-m-d').' 00:00:00')->get();
        $todayusers_count = count($todayusers);

        $weeklyusers = User::where('role_id', 2)->where('created_at','>=',date('Y-m-d 00:00:00', strtotime("-6 days")))->get();
        $weeklyusers_count = count($weeklyusers);

       $pages["<i class='fa fa-dashboard'></i>" . trans('admin.DASHBOARD')] = 'dashboard';
        
        $breadcrumb = array('pages' => $pages, 'active' =>'admin.dashboard.index');

        return view('admin.pages.index',compact('breadcrumb','pageTitle','title','totalusers_count','todayusers_count','weeklyusers_count'));
    }


     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
  
    public function create() {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

}
