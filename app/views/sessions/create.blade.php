@extends('layouts.default')

@section('header')

	<h1>This is header</h1>

@stop 

@section('content') 
	<div class="container">
		[[ Form::open(['route' => 'sessions.store']) ]]

			[[ Form::label('email', 'Email') ]]
			[[ Form::email('email') ]]

			[[ Form::label('password', 'Password') ]]
			[[ Form::password('password') ]]

			[[ Form::submit('Login') ]]

		[[ Form::close() ]]
	</div>

@stop