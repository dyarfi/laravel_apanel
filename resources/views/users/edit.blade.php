@extends('layouts.master')

@section('content')

<h1>Edit User - {{ $user->name }} </h1>
<p class="lead">Edit this user below. <a href="{{ route('users.index') }}">Go back to all users.</a></p>
<hr>

{!! Form::model($user, [
    'method' => 'PATCH',
    'route' => ['users.update', $user->id]
]) !!}

<div class="form-group">
    {!! Form::label('username', 'Username:', ['class' => 'control-label']) !!}
    {!! Form::text('username', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('about', 'About:', ['class' => 'control-label']) !!}
    {!! Form::textarea('about', null, ['class' => 'form-control']) !!}
</div>

{!! Form::submit('Update user', ['class' => 'btn btn-primary btn-xs']) !!}

{!! Form::close() !!}

@stop