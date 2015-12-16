@extends('admin.template')

{{-- Page content --}}
@section('body')

<div class="page-header">
	<h1>Permissions</h1>
</div>

@if ($permissions->count())
<div class="pull-right"></div>
<br><br>
<table class="table table-bordered table-hover">
	<thead>
		<th class="col-lg-3">Name</th>
		<!-- <th class="col-lg-6">Users</th>-->
		<th class="col-lg-4">Access Permission</th>
		<th class="col-lg-5">Users Permissions</th>
	</thead>
	<tbody>
		@foreach ($permissions as $role) 
		<tr>			
			<td>{{ $role->name }}</td>
			<!--td>
				@if($role->users()->count()) <a href="{{route('admin.permissions.edit', $role->id)}}">Add Users ({{ $role->users()->count() }})</a>
				@else
				@endif
			</td-->
			<td>
				@if(is_array($role->permissions))
					@foreach ($role->permissions as $permission => $val)
						<?php 
						/*
						@if ($val) {{ ucfirst($permission) }}
						@else <span class="label label-danger label-sm">No Access</span>
						@endif
						*/
						?>
					@endforeach
				@else
					<span class="label label-danger label-sm">No Access</span>
				@endif
				<span class="label label-info"><span class="fa fa-key"></span> {!! link_to_route('admin.permissions.edit', 'Access Permission', ['id'=>$role->id,'access=role'], ['class'=>'white']) !!}</span>
			</td>
			<td>
				{!! Form::open() !!}
				@if($role->users()->count()) 
					<select name="access_user" data-placement="top" data-rel="tooltip" data-original-title="Select to View">
					<?php
						$users = $role->users()->get();						
						foreach ($users as $user) { 
						?>
							<option value="{{$user->id}}" onclick="location.href = base_url + '/{{ $admin_url }}/permissions/'+this.value+'?access=user'">
								{{ $user->first_name, $user->last_name }}
							</option>
						<?php
						}	
					?>
					</select>
					<!-- {!! link_to_route('admin.users.create', '[Add User]', ['id'=>$role->id,'access=user'], ['class'=>'btn btn-link']) !!} -->
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
<br><br>
<div class="well">
	Nothing to show here.
</div>
@endif

@stop
