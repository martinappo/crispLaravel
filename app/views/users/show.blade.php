@extends('layouts.default')

@section('header')

	<h1>This is header</h1>

@stop 

@section('content') 

	<div class="welcome">
		<h1>Hello {{$user->username}}</h1>
	</div>

@stop