@extends('admin.template')

@section('body')

<div class="page-header">
	<h1>{{ $mode == 'create' ? 'Create Task' : 'Update Task' }} <small>{{ $mode === 'update' ? $task->name : null }}</small></h1>
</div>

<!--form method="post" action="" autocomplete="off"-->
{!! Form::model($task, 
	[
		'route' => ($mode == 'create') ? 'admin.tasks.create' : ['admin.tasks.update', $task->id],
		'files' => true
	]) 
!!}

<div class="form-group{{ $errors->first('title', ' has-error') }}">
	{!! Form::label('title', 'Title'); !!}
	{!! Form::text('title',Input::old('title', $task->title),[
		'placeholder'=>'Enter the Task title.',
		'name'=>'title',
		'id'=>'title',
		'class' => 'form-control']); !!}
	<span class="help-block">{{{ $errors->first('title', ':message') }}}</span>
</div>

<div class="form-group{{ $errors->first('slug', ' has-error') }}">
	{!! Form::label('slug', 'Slug'); !!}
	{!! Form::text('slug',Input::old('slug', $task->slug),[
		'placeholder'=>'Enter the Task Slug.',
		'name'=>'slug',
		'id'=>'slug',
		'readonly'=>true,
		'class'=>'form-control']); !!}
	<span class="help-block">{{{ $errors->first('slug', ':message') }}}</span>
</div>

<div class="form-group{{ $errors->first('description', ' has-error') }}">
	{!! Form::label('description', 'Description'); !!}
	{!! Form::textarea('description',Input::old('description', $task->description),[
		'placeholder'=>'Enter the Task Description.',
		'name'=>'description',
		'id'=>'description',
		'class' => 'form-control',
		'rows' => '4'
	]); !!}
	<span class="help-block">{{{ $errors->first('description', ':message') }}}</span>
</div>

<div class="form-group">	
	{!! Form::label('image', ($task->image) ? 'Replace Image:' : 'Image:', ['class' => 'control-label']) !!}
	@if ($task->image)
		{{$task->image}}
	@endif
	{!! Form::file('image') !!}
</div>

{!! Form::submit(ucfirst($mode).' New Task', ['class' => 'btn btn-primary btn-xs']) !!}

{!! Form::close() !!}

@stop