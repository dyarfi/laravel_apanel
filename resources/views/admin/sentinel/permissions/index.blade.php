@extends('admin.template')

{{-- Page content --}}
@section('body')

<div class="page-header">
	<h1>Permissions <span class="pull-right"><a href="{{ URL::to('apanel/permissions/create') }}" class="btn btn-warning">Create</a></span></h1>
</div>

@if ($permissions->count())

<div class="pull-right">

</div>

<br><br>

<table class="table table-bordered table-hover">
	<thead>
		<th class="col-lg-6">Name</th>
		<th class="col-lg-6">Email</th>
		<th class="col-lg-6">Role</th>		
		<th class="col-lg-4">Permission</th>
		<th class="col-lg-2">Actions</th>
	</thead>
	<tbody>
		@foreach ($permissions as $user) 
		<tr>			
			<td>{{ $user->first_name }}</td>
			<td>{{ $user->email }}</td>
			<td>
				@if ($user->roles->first())
					{{ $user->roles->first()->name }}
				@else 
					<span class="label label-danger label-sm">No Role</span>
				@endif	
			</td>
			<td>
				@if(is_array($user->permissions))
					@foreach ($user->permissions as $permission => $val)
						{{ $permission }}
					@endforeach
				@else
					<span class="label label-danger label-sm">No Access</span>
				@endif
			</td>
			<td>
				<a class="btn btn-warning btn-xs" href="{{ URL::to("apanel/permissions/{$user->id}") }}">Edit</a>
				<a class="btn btn-danger btn-xs" href="{{ URL::to("apanel/permissions/{$user->id}/delete") }}">Delete</a>
			</td>
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
