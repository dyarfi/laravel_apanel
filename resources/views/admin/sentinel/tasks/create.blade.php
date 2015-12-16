@extends('layouts.master')

@section('content')

<h1>Add a New Task</h1>
<p class="lead">Add to your task list below.</p>
<hr>

{!! Form::open([
    'route' => 'tasks.store',
    'files' => true
]) !!}

<div class="form-group">
    {!! Form::label('title', 'Title:', ['class' => 'control-label']) !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('description', 'Description:', ['class' => 'control-label']) !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
	{!! Form::label('image', 'Image:', ['class' => 'control-label']) !!}
	{!! Form::file('image') !!}
</div>

{!! Form::submit('Create New Task', ['class' => 'btn btn-primary btn-xs']) !!}

{!! Form::close() !!}

@stop