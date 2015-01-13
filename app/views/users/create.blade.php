@extends('layouts.default')

@section('content')
	<h1> Create user </h1>

	{{ Form::open(['route' => 'users.store']) }}
		<div>
			{{ Form::label('username', 'Name: ') }}
			{{ Form::text('username') }}
			{{ $errors->first('username') }}
		</div>

		<div>
			{{ Form::label('password', 'Password: ') }}
			{{ Form::password('password') }}
			{{ $errors->first('password') }}
		</div> 

		<div>
			{{ Form::label('email', 'Email: ') }}
			{{ Form::email('email') }}
			{{ $errors->first('email') }}
		</div> 

		<div>
			{{ Form::submit('Lähtesta') }}
		</div>
	{{ Form::close() }}
@stop