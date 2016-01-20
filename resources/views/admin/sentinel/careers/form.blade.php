@extends('admin.template')

@section('body')

<div class="page-header">
	<h1>{{ $mode == 'create' ? 'Create Career' : 'Update Career' }} <small>{{ $mode === 'update' ? $career->name : null }}</small></h1>
</div>

<!--form method="post" action="" autocomplete="off"-->
{!! Form::model($career, 
	[
		'route' => ($mode == 'create') ? 'admin.tasks.create' : ['admin.tasks.update', $career->id],
		'files' => true
	]) 
!!}

<div class="form-group{{ $errors->first('title', ' has-error') }}">
	{!! Form::label('title', 'Title'); !!}
	{!! Form::text('title',Input::old('title', $career->title),[
		'placeholder'=>'Enter the Career title.',
		'name'=>'title',
		'id'=>'title',
		'class' => 'form-control']); !!}
	<span class="help-block">{{{ $errors->first('title', ':message') }}}</span>
</div>

<div class="form-group{{ $errors->first('slug', ' has-error') }}">
	{!! Form::label('slug', 'Slug'); !!}
	{!! Form::text('slug',Input::old('slug', $career->slug),[
		'placeholder'=>'Enter the Career Slug.',
		'name'=>'slug',
		'id'=>'slug',
		'readonly'=>true,
		'class'=>'form-control']); !!}
	<span class="help-block">{{{ $errors->first('slug', ':message') }}}</span>
</div>

<div class="form-group{{ $errors->first('description', ' has-error') }}">
	{!! Form::label('description', 'Description'); !!}
	{!! Form::textarea('description',Input::old('description', $career->description),[
		'placeholder'=>'Enter the Career Description.',
		'name'=>'description',
		'id'=>'description',
		'class' => 'form-control',
		'rows' => '4'
	]); !!}
	<span class="help-block">{{{ $errors->first('description', ':message') }}}</span>
</div>

<div class="form-group">	
	{!! Form::label('image', ($career->image) ? 'Replace Image:' : 'Image:', ['class' => 'control-label']) !!}
	@if ($career->image)
		{{$career->image}}
	@endif
	{!! Form::file('image','',['class'=>'form-controls']) !!}
</div>

{!! Form::submit(ucfirst($mode).' New Career', ['class' => 'btn btn-primary btn-xs']) !!}

{!! Form::close() !!}

@stop