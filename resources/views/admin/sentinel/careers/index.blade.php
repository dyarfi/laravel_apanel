@extends('admin.template')

{{-- Page content --}}
@section('body')

<div class="page-header">
	<h1>Careers <span class="pull-right"><a href="{{ route('admin.careers.create') }}" class="btn btn-warning"><span class="glyphicon glyphicon-pencil"></span> Create</a></span>{{$junked ? ' &raquo; Trashed' :''}}</h1>
</div>
@if($deleted)
<div class="pull-right">
	<a href="{{route('admin.careers.index','path=trashed')}}" title="Restored Deleted"><span class="fa fa-trash"></span> {{ $deleted }} Deleted</a>
</div>
@endif
@if ($careers->count())
<div class="row">
	<div class="col-xs-12">		
		<div class="clearfix">
			<div class="pull-right tableTools-container"></div>
		</div>
		{!! Form::open(['route'=>'admin.careers.index']) !!}		
		<table id="dynamic-table" class="table table-bordered table-hover">
			<thead>
				<tr>
					<th class="center"><label class="pos-rel"><input type="checkbox" class="ace" /><span class="lbl"></span></label></th>
					<th class="col-lg-3">Title</th>
					<th class="col-lg-3">Description</th>
					<th class="col-lg-2">Updated At</th>
					<th class="col-lg-2">Created At</th>				
					<th class="col-lg-6 col-xs-3">Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($careers as $career)
				<tr class="{{ $career->deleted_at ? ' bg-warning' :'' }}">
					<td class="center">
						<label class="pos-rel">
							<input type="checkbox" class="ace" />
							<span class="lbl"></span>
						</label>
					</td>
					<td>{{ str_limit($career->title,30) }}</td>					
					<td>{{ str_limit($career->description, 30, '...') }}</td>					
					<td>{{ $career->updated_at }}</td>
					<td>{{ $career->created_at }}</td>					
					<td>
						<div class="btn-group">
							@if (!$career->deleted_at)
							<a data-rel="tooltip" data-original-title="View" title="" href="{{ route('admin.careers.show', $career->id) }}" class="btn btn-xs btn-success tooltip-default">
								<i class="ace-icon fa fa-check bigger-120"></i>
							</a>
							<a data-rel="tooltip" data-original-title="Edit"  href="{{ route('admin.careers.edit', $career->id) }}" class="btn btn-xs btn-info tooltip-default">
								<i class="ace-icon fa fa-pencil bigger-120"></i>
							</a>
							<a data-rel="tooltip" data-original-title="Trashed"  href="{{ route('admin.careers.trash', $career->id) }}" class="btn btn-xs btn-danger tooltip-default">
								<i class="ace-icon fa fa-trash-o bigger-120"></i>
							</a>
							<!--a data-rel="tooltip" data-original-title="Permanent Delete" href="" class="btn btn-xs btn-warning tooltip-default">
								<i class="ace-icon fa fa-flag bigger-120"></i>
							</a-->
							@else 
							<a data-rel="tooltip" data-original-title="Restore!" href="{{route('admin.careers.restored', $career->id)}}" class="btn btn-xs btn-primary tooltip-default">
								<i class="ace-icon fa fa-save bigger-120"></i>
							</a>
							<a data-rel="tooltip" data-original-title="Permanent Delete!" href="{{route('admin.careers.delete', $career->id)}}" class="btn btn-xs btn-danger tooltip-default">
								<i class="ace-icon fa fa-trash bigger-120"></i>
							</a>
							@endif
						</div>
					</td>
				</tr>
				@endforeach
			</tbody>
			<tr>
			    <td id="corner"><span class="glyphicon glyphicon-minus"></span></td>
			    <td colspan="8">
				<div id="selection" class="input-group">
				    <div class="form-group form-group-sm">
						<label class="col-xs-6 control-label small grey" for="select_action">Change status :</label>
						<div class="col-xs-6" id="select_action">
						<select id="select_action" class="form-control input-sm" name="select_action">
							<option value=""></option>
							@foreach (config('setting.status') as $config => $val)
								<option value="{{$val}}">{{$config}}</option>
							@endforeach
						</select>
						</div>
				      </div>
				 </div>   
			    </td>
			</tr>
		</table>		
		{!! Form::close() !!}
	</div>
</div>

@else
<br><br>
<div class="well">
	Nothing to show here.
</div>
@endif

@stop
