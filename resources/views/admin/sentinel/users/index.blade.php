@extends('admin.template')

{{-- Page content --}}
@section('body')

<div class="page-header">
	<h1>Users <span class="pull-right"><a href="{{ route('admin.users.create') }}" class="btn btn-warning">Create</a></span></h1>
</div>

@if ($users->count())
<small class="grey">@if ($users->count()) Page {{ @$users->currentPage() }} of {{ @$users->lastPage() }} @endif</small>
<div class="pull-right">
	{!! $users->render() !!}
</div>
<br><br>
<div class="row">
	<div class="col-xs-12">
		<table class="table table-bordered table-hover">
			<thead>
				<th class="col-lg-3">Name</th>
				<th class="col-lg-3">Email</th>
				<th class="col-lg-3">Role</th>
				<th class="col-lg-6">Actions</th>
			</thead>
			<tbody>
				@foreach ($users as $user)
				<tr>
					<td>{{ $user->first_name }} {{ $user->last_name }}</td>
					<td>{{ $user->email }}</td>
					<td>
					@if ($user->roles->first())
						@if( $user->roles->first()->permissions['admin'] === true )
						<span class="label label-success arrowed-in arrowed-in-right">							
							<span class="fa fa-user fa-sm"></span> {{ $user->roles->first()->name }}
		                </span>
						@else
						<span class="label label-warning arrowed-in arrowed-in-right">														
							<span class="fa fa-users fa-sm"></span> {{ $user->roles->first()->name }}
						</span>
						@endif
		            @else
		                <div class="label label-danger arrowed-in arrowed-in-right"><span class="fa fa-ban fa-sm"></span> No Role</div>
		            @endif  
		        	</td>
					<td>
						<div class="btn-group">
							<a data-rel="tooltip" data-original-title="View" title="" href="{{ route('admin.users.show', $user->id) }}" class="btn btn-xs btn-success tooltip-default">
								<i class="ace-icon fa fa-check bigger-120"></i>
							</a>
							<a data-rel="tooltip" data-original-title="Edit"  href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-xs btn-info tooltip-default">
								<i class="ace-icon fa fa-pencil bigger-120"></i>
							</a>
							<a data-rel="tooltip" data-original-title="Delete"  href="{{ route('admin.users.delete', $user->id) }}" class="btn btn-xs btn-danger tooltip-default">
								<i class="ace-icon fa fa-trash-o bigger-120"></i>
							</a>
							<a data-rel="tooltip" data-original-title="Permanent Delete" href="" class="btn btn-xs btn-warning tooltip-default">
								<i class="ace-icon fa fa-flag bigger-120"></i>
							</a>
						</div>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
<small class="grey">@if ($users->count()) Page {{ @$users->currentPage() }} of {{ @$users->lastPage() }} @endif</div>
<div class="pull-right">
	{!! $users->render() !!}
</div>
@else
<div class="well">
	Nothing to show here.
</div>
@endif

@stop
