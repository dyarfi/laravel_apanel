@extends('admin.template')

{{-- Page content --}}
@section('body')
<div class="page-header">
	<h1>Pages <span class="pull-right"><a href="{{ URL::to('apanel/pages/create') }}" class="btn btn-warning"><span class="glyphicon glyphicon-pencil"></span> Create</a></span>{{$junked ? ' &raquo; Trashed' :''}}</h1>
</div>
@if($deleted)
<div class="pull-right">
	<a href="{{route('admin.pages.index','path=trashed')}}" title="Restored Deleted"><span class="fa fa-trash"></span> {{ $deleted }} Deleted</a>
</div>
@endif
@if ($pages->count())
<small class="grey">@if ($pages->count()) Page {{ @$pages->currentPage() }} of {{ @$pages->lastPage() }} @endif</small>
<div class="pull-right">
	{!! $pages->render() !!}
</div>
<table class="table table-bordered table-hover">
	<thead>
		<th class="col-lg-3">Name</th>
		<th class="col-lg-3">Slug</th>
		<th class="col-lg-3">Permission</th>
		<th class="col-lg-4">Actions</th>
	</thead>
	<tbody>
		@foreach ($pages as $page)
		<tr class="{{ $page->deleted_at ? ' bg-warning' :'' }}">
			<td>{{ $page->name }}</td>
			<td>{{ $page->slug }}</td>			
			<td>{!! str_contains($page->permissions,'"admin":true') 
				? '<span class="label label-success arrowed-in arrowed-in-right"><span class="fa fa-user fa-sm"></span> Superadmin</span>' 
				: '<span class="label label-danger arrowed-in arrowed-in-right"><span class="fa fa-ban fa-sm"></span> General</span>' !!}</td>
			<td>
				<div class="btn-group">
					@if (!$page->deleted_at)
					<a data-rel="tooltip" data-original-title="View" title="" href="{{ route('admin.pages.show', $page->id) }}" class="btn btn-xs btn-success tooltip-default">
						<i class="ace-icon fa fa-check bigger-120"></i>
					</a>
					<a data-rel="tooltip" data-original-title="Edit"  href="{{ route('admin.pages.edit', $page->id) }}" class="btn btn-xs btn-info tooltip-default">
						<i class="ace-icon fa fa-pencil bigger-120"></i>
					</a>
					<a data-rel="tooltip" data-original-title="Trashed"  href="{{ route('admin.pages.trash', $page->id) }}" class="btn btn-xs btn-danger tooltip-default">
						<i class="ace-icon fa fa-trash-o bigger-120"></i>
					</a>
					<!--a data-rel="tooltip" data-original-title="Permanent Delete" href="" class="btn btn-xs btn-warning tooltip-default">
						<i class="ace-icon fa fa-flag bigger-120"></i>
					</a-->
					@else 
						<a data-rel="tooltip" data-original-title="Restore!" href="{{route('admin.pages.restored', $page->id)}}" class="btn btn-xs btn-primary tooltip-default">
							<i class="ace-icon fa fa-save bigger-120"></i>
						</a>
						<a data-rel="tooltip" data-original-title="Permanent Delete!" href="{{route('admin.pages.delete', $page->id)}}" class="btn btn-xs btn-danger tooltip-default">
							<i class="ace-icon fa fa-trash bigger-120"></i>
						</a>
					@endif
				</div>
					
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
<small class="grey">@if ($pages->count()) Page {{ @$pages->currentPage() }} of {{ @$pages->lastPage() }} @endif</small>
<div class="pull-right">
	{!! $pages->render() !!}
</div>
@else
<br><br>
<div class="well">
	Nothing to show here.
</div>
@endif

@stop
