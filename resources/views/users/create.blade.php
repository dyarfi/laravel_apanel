@extends('layouts.master')

@section('content')

<h1>Add a New User</h1>
<p class="lead">Add to your user below.</p>
<hr>

{!! Form::open([
    'route' => 'users.store'
]) !!}

<div class="form-group">
    {!! Form::label('name', 'Name:', ['class' => 'control-label']) !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('about', 'About:', ['class' => 'control-label']) !!}
    {!! Form::textarea('about', null, ['class' => 'form-control']) !!}
</div>

{!! Form::submit('Create New User', ['class' => 'btn btn-primary btn-xs']) !!}

{!! Form::close() !!}

@stop