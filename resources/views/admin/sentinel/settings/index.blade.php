@extends('admin.template')

{{-- Page content --}}
@section('body')

<div class="page-header">
	<h1>Settings <span class="pull-right"><a href="{{ route('admin.settings.create') }}" class="btn btn-warning">Create</a></span>{{$junked ? ' &raquo; Trashed' :''}}</h1>
</div>
@if($deleted)
<div class="pull-right">
	<a href="{{route('admin.settings','path=restored')}}" title="Restored Deleted"><span class="fa fa-trash"></span> {{ $deleted }} Deleted</a>
</div>
@endif
@if ($settings->count())
<small class="grey">@if ($settings->count()) Page {{ @$settings->currentPage() }} of {{ @$settings->lastPage() }} @endif</small>
<div class="pull-right">
	{!! $settings->render() !!}
</div>
<br><br>
<div class="row">
	<div class="col-xs-12">
		<table class="table table-bordered table-hover">
			<thead>
				<th class="col-lg-3">Name</th>
				<th class="col-lg-3">Description</th>
				<th class="col-lg-3">Value</th>
				<th class="col-lg-6">Actions</th>
			</thead>
			<tbody>
				@foreach ($settings as $setting)
				<tr class="{{ $setting->deleted_at ? ' bg-warning' :'' }}">
					<td>{{ $setting->name }}</td>					
					<td>{{ str_limit($setting->description, 30, '...') }}</td>					
					<td>{{ $setting->value }}</td>
					<td>
						<div class="btn-group">
							@if (!$setting->deleted_at)
							<a data-rel="tooltip" data-original-title="View" title="" href="{{ route('admin.settings.show', $setting->id) }}" class="btn btn-xs btn-success tooltip-default">
								<i class="ace-icon fa fa-check bigger-120"></i>
							</a>
							<a data-rel="tooltip" data-original-title="Edit"  href="{{ route('admin.settings.edit', $setting->id) }}" class="btn btn-xs btn-info tooltip-default">
								<i class="ace-icon fa fa-pencil bigger-120"></i>
							</a>
							<a data-rel="tooltip" data-original-title="Trashed"  href="{{ route('admin.settings.trash', $setting->id) }}" class="btn btn-xs btn-danger tooltip-default">
								<i class="ace-icon fa fa-trash-o bigger-120"></i>
							</a>
							<a data-rel="tooltip" data-original-title="Permanent Delete" href="" class="btn btn-xs btn-warning tooltip-default">
								<i class="ace-icon fa fa-flag bigger-120"></i>
							</a>
							@else 
							<a data-rel="tooltip" data-original-title="Restore!" href="{{route('admin.settings.restored', $setting->id)}}" class="btn btn-xs btn-primary tooltip-default">
								<i class="ace-icon fa fa-save bigger-120"></i>
							</a>
							<a data-rel="tooltip" data-original-title="Permanent Delete!" href="{{route('admin.settings.delete', $setting->id)}}" class="btn btn-xs btn-danger tooltip-default">
								<i class="ace-icon fa fa-trash bigger-120"></i>
							</a>
							@endif
						</div>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
<small class="grey">@if ($settings->count()) Page {{ @$settings->currentPage() }} of {{ @$settings->lastPage() }} @endif</small>
<div class="pull-right">
	{!! $settings->render() !!}
</div>
@else
<div class="well">
	Nothing to show here.
</div>
@endif

@stop
