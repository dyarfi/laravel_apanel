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

	<div class="form-group{{ $errors->first('phone_number', ' has-error') }}">
		{!! Form::label('phone_number', 'Phone Number'); !!}
		{!! Form::text('phone_number',Input::old('phone_number', $participant->phone_number),[
			'placeholder'=>'Enter the Participant Phone Number.',
			'name'=>'phone_number',
			'id'=>'phone_number',
			'class'=>'form-control']); !!}
		<span class="help-block">{{{ $errors->first('phone_number', ':message') }}}</span>
	</div>
	
	<div class="form-group{{ $errors->first('phone_home', ' has-error') }}">
		{!! Form::label('phone_home', 'Phone Home'); !!}
		{!! Form::text('phone_home',Input::old('phone_home', $participant->phone_home),[
			'placeholder'=>'Enter the Participant Phone Home.',
			'name'=>'phone_home',
			'id'=>'phone_home',
			'class'=>'form-control']); !!}
		<span class="help-block">{{{ $errors->first('phone_home', ':message') }}}</span>
	</div>

	<div class="form-group{{ $errors->first('phone_home', ' has-error') }}">
		{!! Form::label('phone_home', 'Phone Home'); !!}
		{!! Form::text('phone_home',Input::old('phone_home', $participant->phone_home),[
			'placeholder'=>'Enter the Participant Phone Home.',
			'name'=>'phone_home',
			'id'=>'phone_home',
			'class'=>'form-control']); !!}
		<span class="help-block">{{{ $errors->first('phone_home', ':message') }}}</span>
	</div>

	<div class="form-group{{ $errors->first('address', ' has-error') }}">
		{!! Form::label('address', 'Address'); !!}
		{!! Form::textarea('address',Input::old('address', $participant->address),[
			'placeholder'=>'Enter the Participant Address.',
			'name'=>'address',
			'id'=>'address',
			'class'=>'form-control']); !!}
		<span class="help-block">{{{ $errors->first('address', ':message') }}}</span>
	</div>

	<div class="form-group{{ $errors->first('about', ' has-error') }}">
		{!! Form::label('about', 'About'); !!}
		{!! Form::textarea('about',Input::old('about', $participant->about),[
			'placeholder'=>'Enter the Participant about.',
			'name'=>'about',
			'id'=>'about',
			'class'=>'form-control']); !!}
		<span class="help-block">{{{ $errors->first('about', ':message') }}}</span>
	</div>

	<div class="form-group{{ $errors->first('password', ' has-error') }}">
		<label for="password">Password</label>
		<input type="password" class="form-control" name="password" id="password" value="" placeholder="Enter the user password (only if you want to modify it).">
		<span class="help-block">{{{ $errors->first('password', ':message') }}}</span>
	</div>	

	<button type="submit" class="btn btn-default">Submit</button>
{!! Form::close() !!}

@stop
