<?php

class SessionsController extends BaseController {

	public function create() {
		if (Auth::check()) return Redirect::to('/admin');
		return View::make('sessions.create');
	}

	public function store(){
		if(Auth::attempt(Input::only('email', 'password'))) {
			return Redirect::to('/portfolio'); 
		}
		return Redirect::back()->withInput();
	}

	public function destroy() {
		Auth::logout();

		return Redirect::to('/portfolio'); 
	}
}