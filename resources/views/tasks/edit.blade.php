@extends('layouts.master')

@section('content')

<h1>Edit Task - {{ $task->title }} </h1>
<p class="lead">Edit this task below. <a href="{{ route('tasks.index') }}">Go back to all tasks.</a></p>
<hr>

{!! Form::model($task, [
    'method' => 'PATCH',
    'files' => true,
    'route' => ['tasks.update', $task->id]
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
	<div class="row-fluid">
		@if ($task->image !== '')
		{!! Form::label('image', 'Replace Image:', ['class' => 'control-label']) !!}
			<a href="{{ asset('uploads/'.$task->image) }}" target="_blank" title="{{ $task->image }}"/><img src="{{ asset('uploads/'.$task->image) }}" class=""/></a>
		@else
			{!! Form::label('image', 'Image:', ['class' => 'control-label']) !!}
		@endif	
		{!! Form::file('image') !!}	
	</div>
</div>

{!! Form::submit('Update Task', ['class' => 'btn btn-primary btn-xs']) !!}

{!! Form::close() !!}

@stop