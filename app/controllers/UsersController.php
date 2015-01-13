<?php

class UsersController extends \BaseController {

	public function __construct(User $user) {
		$this->user = $user;
		$this->beforeFilter('auth', array('only' => array('create', 'store')));
	}

	public function index() {
		$users = $this->user->all();
		return View::make('users.index', ['users' => $users]);
	}

	public function show($username) {
		$user = $this->user->whereUsername($username)->first();
		return View::make('users.show', ['user' => $user]);
	}

	public function create() {
		return View::make('users.create');
	}

	public function store() {
		$input = Input::all();
		$this->user->fill($input);

		if ( ! $this->user->isValid()) {
			return Redirect::back()->withInput()->withErrors($this->user->messages);
		}

		$this->user->password = Hash::make(Input::get('password'));
		$this->user->save();

		return Redirect::route('users.index');
	}


}
