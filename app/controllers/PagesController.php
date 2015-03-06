<?php

class PagesController extends BaseController {

	public function index() {
		return View::make('index');
	}

	public function about() {
		return View::make('about');
	}

	public function contact() {
		return View::make('contact');
	}

}