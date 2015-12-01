@extends('admin.template')

{{-- Page content --}}
@section('body')

<div class="page-header">
	<h1>{{ $mode == 'create' ? 'Create Role' : 'Update Role' }} <small>{{ $mode === 'update' ? $page->name : null }}</small></h1>
</div>

{!! Form::open([
    'route' => ($mode == 'create') ? 'admin.pages.create' : ['admin.pages.update', $page->id]
]) !!}

	<div class="form-group{{ $errors->first('name', ' has-error') }}">
		{!! Form::label('name', 'Name'); !!}
		{!! Form::text('name',Input::old('name', $page->name),[
			'placeholder'=>'Enter the Role Name.',
			'name'=>'name',
			'id'=>'name',
			'class' => 'form-control']); !!}
		<span class="help-block">{{{ $errors->first('name', ':message') }}}</span>
	</div>

	<div class="form-group{{ $errors->first('slug', ' has-error') }}">
		{!! Form::label('slug', 'Slug'); !!}
		{!! Form::text('slug',Input::old('slug', $page->slug),[
		'placeholder'=>'Enter the Role Slug.',
		'name'=>'slug',	
		'id'=>'slug',
		'readonly'=>true,
		'class'=>'form-control']); !!}
		<span class="help-block">{{{ $errors->first('slug', ':message') }}}</span>
	</div>

	<div class="form-group{{ $errors->first('permissions', ' has-error') }}">
		{!! Form::label('', 'Permissions'); !!}
		<div class="form-group">
			<div class="clearfix">
				<span class="col-md-2">
					{!! Form::radio('permissions', 'true', ($mode == 'create') ? 'false' : ($page->permissions['admin'] === true ? true : false)); !!}
					{!! Form::label('', 'Admin Access',['class'=>'text-success']); !!}
				</span>
				<span class="col-md-2">
					{!! Form::radio('permissions', 'false', ($mode == 'create') ? true : ($page->permissions['admin'] === false ? true : false)); !!}
					{!! Form::label('', 'No Admin Access',['class'=>'text-danger']); !!}
				</span>
			</div>
		</div>			
		<span class="help-block">{{{ $errors->first('slug', ':message') }}}</span>
	</div>

	<button type="submit" class="btn btn-default">Submit</button>

{!! Form::close() !!}

@stop
