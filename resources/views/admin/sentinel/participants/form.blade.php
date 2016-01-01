@extends('admin.template')

{{-- Page content --}}
@section('body')

<div class="page-header">
	<h1>{{ $mode == 'create' ? 'Create Participant' : 'Update Participant' }} <small>{{ $mode === 'update' ? $participant->name : null }}</small></h1>
</div>
<!--form method="post" action="" autocomplete="off"-->
{!! Form::open([
    'route' => ($mode == 'create') ? 'admin.participants.create' : ['admin.participants.update', $participant->id]
]) !!}

	<div class="form-group{{ $errors->first('name', ' has-error') }}">
		<label for="name">Name</label>
		<input type="text" class="form-control" name="name" id="name" value="{{ Input::old('name', $participant->name) }}" placeholder="Enter the user name.">
		<span class="help-block">{{{ $errors->first('name', ':message') }}}</span>
	</div>

	<div class="form-group{{ $errors->first('email', ' has-error') }}">
		<label for="email">Email</label>
		<input type="text" class="form-control" name="email" id="email" value="{{ Input::old('email', $participant->email) }}" placeholder="Enter the user email.">
		<span class="help-block">{{{ $errors->first('email', ':message') }}}</span>
	</div>

	<div class="form-group{{ $errors->first('password', ' has-error') }}">
		<label for="password">Password</label>
		<input type="password" class="form-control" name="password" id="password" value="" placeholder="Enter the user password (only if you want to modify it).">
		<span class="help-block">{{{ $errors->first('password', ':message') }}}</span>
	</div>

	<button type="submit" class="btn btn-default">Submit</button>
{!! Form::close() !!}

@stop
