@extends('admin.template')

{{-- Page content --}}
@section('body')

<div class="page-header">
	<h1>Permissions <span class="pull-right"><a href="{{ URL::to('apanel/permissions/create') }}" class="btn btn-warning">Create</a></span></h1>
</div>

@if ($permissions->count())
<div class="pull-right"></div>

<br><br>

<table class="table table-bordered table-hover">
	<thead>
		<th class="col-lg-6">Name</th>
		<!-- <th class="col-lg-6">Users</th>-->
		<th class="col-lg-4">Permission</th>
		<th class="col-lg-2">Users</th>
	</thead>
	<tbody>
		@foreach ($permissions as $role) 
		<tr>			
			<td>{{ $role->name }}</td>
			<!--td>
				@if($role->users()->count()) 
					<a href="{{route('admin.permissions.edit', $role->id)}}">Add Users ({{ $role->users()->count() }})</a>
				@else

				@endif
			</td-->
			<td>
				@if(is_array($role->permissions))
					@foreach ($role->permissions as $permission => $val)
						<?php 
						/*
						@if ($val)
							{{ ucfirst($permission) }}
						@else
							<span class="label label-danger label-sm">No Access</span>
						@endif
						*/
						?>
					@endforeach
				@else
					<span class="label label-danger label-sm">No Access</span>
				@endif
				{!! 				
					link_to_route('admin.permissions.edit', '[See Roles]', ['id'=>$role->id,'access=role'], ['class'=>'btn btn-link'])
				!!}
			</td>
			<td>
				{!! Form::open() !!}
				@if($role->users()->count()) 
					
					<a href="{{route('admin.permissions.edit', $role->id)}}">Add User ({{ $role->users()->count() }})</a>
					<?php
						$users = $role->users()->get();
						
						foreach ($users as $user) {
							print_r($user->email);
						}	
					?>

				@else
					<a href="{{route('admin.users.create','role_id='.$role->id)}}">Add User</a>
				@endif
				{!! Form::close() !!}
			</td>
			<!--td>
				<a class="btn btn-warning btn-xs" href="{{ URL::to("apanel/permissions/{$role->id}") }}">Edit</a>
				<a class="btn btn-danger btn-xs" href="{{ URL::to("apanel/permissions/{$role->id}/delete") }}">Delete</a>
			</td-->
		</tr>
		@endforeach
	</tbody>
</table>


<div class="pull-right">

</div>
@else
<div class="well">

	Nothing to show here.

</div>
@endif

@stop
