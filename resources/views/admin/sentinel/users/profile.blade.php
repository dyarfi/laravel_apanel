@extends('admin.template')

@section('body')

<h1>{{ $user->name }}</h1>
<hr>
<div class="row-fluid">
	<p class="lead">Joined : {{ $user->created_at }}</p>
	<div class="row-fluid">
		{!! Form::open([
			'method' => 'PATCH',
	       	'route' => ['users.edit', $user->id]
		]) !!}

		@if (count($user->email) === 1)
	    	<p class="lead">Email : {{ $user->email }}</p>
		@else
		    You don't have an email!
		@endif 

		@if (count($user->provider) === 1)
	    	<p class="lead">Register with : {{ $user->provider }}</p>
		@else
		    You don't have any providers!
		@endif 

		<div class="form-group">
		    {!! Form::label('username', 'Username:', ['class' => 'control-label']) !!}
		    {!! Form::text('username', $user->username, ['class' => 'form-control']) !!}
		</div>
		
		<div class="form-group">
		    {!! Form::label('about', 'About:', ['class' => 'control-label']) !!}
		    {!! Form::textarea('about', $user->about, ['class' => 'form-control']) !!}
		</div>

		{!! Form::submit('Update Profile', ['class' => 'btn btn-primary btn-xs']) !!}

		{!! Form::close() !!}
	</div>
</div>

@stop