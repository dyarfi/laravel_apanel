@extends('admin.template')

{{-- Page content --}}
@section('body')

<div class="page-header">
	<h1>{{ $mode == 'create' ? 'Create Role' : 'Update Role' }} <small>{{ $mode === 'update' ? $role->name : null }}</small></h1>
</div>

{!! Form::open([
    'route' => ($mode == 'create') ? 'admin.roles.create' : ['admin.roles.update', $role->id]
]) !!}

	<div class="form-group{{ $errors->first('name', ' has-error') }}">
		{!! Form::label('name', 'Name'); !!}
		{!! Form::text('name',Input::old('name', $role->name),[
			'placeholder'=>'Enter the Role Name.',
			'name'=>'name',
			'id'=>'name',
			'class' => 'form-control']); !!}
		<span class="help-block">{{{ $errors->first('name', ':message') }}}</span>
	</div>

	<div class="form-group{{ $errors->first('slug', ' has-error') }}">
		{!! Form::label('slug', 'Slug'); !!}
		{!! Form::text('slug',Input::old('slug', $role->slug),[
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
					{!! Form::radio('permissions', 'true', ($mode == 'create') ? 'false' : (isset($role->permissions['admin']) && $role->permissions['admin'] === true ? true : false)); !!}
					{!! Form::label('', 'Admin Access',['class'=>'text-success']); !!}
				</span>
				<span class="col-md-2">
					{!! Form::radio('permissions', 'false', ($mode == 'create') ? true : (isset($role->permissions['admin']) && $role->permissions['admin'] === false ? true : false)); !!}
					{!! Form::label('', 'No Admin Access',['class'=>'text-danger']); !!}
				</span>
			</div>
		</div>	
		@foreach ($role->permissions as $permission => $val)
			@if(Auth::hasAccess('admin') && $permission == 'admin')
				{!! Form::checkbox('permission[]', $val, $val ? true : false, ['disabled']) !!}
			@else			
				{!! Form::checkbox('permission[]', $val, $val ? true : false) !!}	
			@endif
			{!! Form::label('permission[]', ucfirst($permission)) !!}
		@endforeach
		<span class="help-block">{{{ $errors->first('slug', ':message') }}}</span>
	</div>

	<button type="submit" class="btn btn-default">Submit</button>

{!! Form::close() !!}

@stop
