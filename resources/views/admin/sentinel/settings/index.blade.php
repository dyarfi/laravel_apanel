@extends('admin.template')

{{-- Page content --}}
@section('body')
<div class="page-header">
	<h1>Settings 
		@if(Auth::getUser()->roles[0]->slug == 'admin')
		<span class="pull-right"><a href="{{ route('admin.settings.create') }}" class="btn btn-warning"><span class="glyphicon glyphicon-pencil"></span> Create</a></span>{{$junked ? ' &raquo; Trashed' :''}}
		@endif
	</h1>
</div>
<?php /*
<div class="page-header">
	<h1>Settings <span class="pull-right"><a href="{{ route('admin.settings.create') }}" class="btn btn-warning"><span class="glyphicon glyphicon-pencil"></span> Create</a></span>{{$junked ? ' &raquo; Trashed' :''}}</h1>
</div>
@if($deleted)
<div class="pull-right">
	<a href="{{route('admin.settings.index','path=trashed')}}" title="Restored Deleted"><span class="fa fa-trash"></span> {{ $deleted }} Deleted</a>
</div>
@endif
@if ($settings->count())
<div class="row">
	<div class="col-xs-12">		
		<div class="clearfix">
			<div class="pull-right tableTools-container"></div>
		</div>
		{!! Form::open(['route'=>'admin.settings.index']) !!}		
		<table id="dynamic-table" class="table table-bordered table-hover">
			<thead>
				<tr>
					<th class="center"><label class="pos-rel"><input type="checkbox" class="ace" /><span class="lbl"></span></label></th>
					<th class="col-lg-2">Name</th>
					<th class="col-lg-3">Description</th>
					<th class="col-lg-3">Value</th>
					<th class="col-lg-2">Created At</th>				
					<th class="col-lg-6 col-xs-3">Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($settings as $setting)
				<tr class="{{ $setting->deleted_at ? ' bg-warning' :'' }}">
					<td class="center">
						<label class="pos-rel">
							<input type="checkbox" class="ace" />
							<span class="lbl"></span>
						</label>
					</td>
					<td>{{ $setting->name }}</td>					
					<td>{{ str_limit($setting->description, 30, '...') }}</td>					
					<td>{{ $setting->value }}</td>
					<td>{{ $setting->created_at }}</td>					
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
							<!--a data-rel="tooltip" data-original-title="Permanent Delete" href="" class="btn btn-xs btn-warning tooltip-default">
								<i class="ace-icon fa fa-flag bigger-120"></i>
							</a-->
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
<div class="well">Nothing to show here.</div>
@endif
*/
?>
<!-- PAGE CONTENT BEGINS -->
<div class="row">
	<div class="col-sm-12">
		{!! Form::open(['route'=>'admin.settings.change','files' => true]) !!}
		{!! Form::hidden('setting_form',base64_encode(Session::getId())) !!}
		<div class="tabbable">
			<ul class="nav nav-tabs" id="myTab">
				<?php
				$i = 0; 
				foreach ($config_settings as $key => $val) { ?>
					<li <?php if ($i == 0) echo 'class="active"';?>>
						<a data-toggle="tab" href="#{{$key}}">
							<!-- <i class="green ace-icon fa fa-home bigger-120"></i> -->
							{{ucfirst($key)}}
						</a>
					</li>
					<?php
				$i++;
				}
				?>
			</ul>
			<div class="tab-content">
				<?php
				$j = 0;
				foreach ($config_settings as $key => $val) { ?>					
					<div id="{{$key}}" class="tab-pane fade <?php if($j == 0) { echo 'in active'; } ?>">
						<?php
						foreach ($val as $setting) {
							if($key == $key) { ?>
								<div class="form-group{{ $errors->first($setting->slug, 'has-error') }}">
									{!! Form::label($setting->slug, $setting->name); !!}
									@if ($setting->description)
										<small class="text-warning"><span class="fa fa-cog"></span>&nbsp;{{$setting->description}}</small>
									@endif
									@if ($setting['input_type'] == 'text')
									{!! Form::text($setting->slug,Input::old($setting->value, $setting->value),[
										'placeholder'=>'Enter the '.$setting->name,
										'name'=> $setting->slug,
										'id'=> $setting->slug,										
										'class'=>'form-control'
										]); !!}
									@endif	
									@if ($setting['input_type'] == 'textarea')
									{!! Form::textarea($setting->slug,Input::old($setting->value, $setting->value),[
										'placeholder'=>'Enter the '.$setting->name,
										'name'=> $setting->slug,
										'id'=> $setting->slug,										
										'class'=>'form-control'
										]); !!}
									@endif
									@if ($setting['input_type'] == 'file')
										@if ($setting->value)
											<span class="help-block">Replace File ? {!! $setting->value !!}</span>
										@endif
										{!! Form::file('image',[
										'placeholder'=>'Enter the '.$setting->name,
										'name'=> $setting->slug,
										'id'=> $setting->slug,										
										'class'=>'form-control input-sm'
										]) !!}
									@endif
									<span class="help-block">{{{ $errors->first($setting->slug, ':message') }}}</span>
								</div>
							<?php
							}
						}
						?>					
					</div>
				<?php 
				$j++;
				}
				?>	
			</div>
		</div>
		<?php /*
		<div class="tabbable">
			<ul class="nav nav-tabs" id="myTab">
				<li class="active">
					<a data-toggle="tab" href="#home">
						<!-- <i class="green ace-icon fa fa-home bigger-120"></i> -->
						Home
					</a>
				</li>
				<li>
					<a data-toggle="tab" href="#messages">
						Messages
						<!-- <span class="badge badge-danger">4</span> -->
					</a>
				</li>
				<li class="dropdown">
					<a data-toggle="dropdown" class="dropdown-toggle" href="#">
						Dropdown &nbsp;
						<!-- <i class="ace-icon fa fa-caret-down bigger-110 width-auto"></i> -->
					</a>
					<!--
					<ul class="dropdown-menu dropdown-info">
						<li>
							<a data-toggle="tab" href="#dropdown1">@fat</a>
						</li>
						<li>
							<a data-toggle="tab" href="#dropdown2">@mdo</a>
						</li>
					</ul>
					-->
				</li>
			</ul>
			<div class="tab-content">
				<div id="home" class="tab-pane fade in active">
					<p>Raw denim you probably haven't heard of them jean shorts Austin.</p>
				</div>
				<div id="messages" class="tab-pane fade">
					<p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid.</p>
				</div>
				<div id="dropdown1" class="tab-pane fade">
					<p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade.</p>
				</div>
				<div id="dropdown2" class="tab-pane fade">
					<p>Trust fund seitan letterpress, keytar raw denim keffiyeh etsy art party before they sold out master cleanse gluten-free squid scenester freegan cosby sweater. Fanny pack portland seitan DIY, art party locavore wolf cliche high life echo park Austin.</p>
				</div>
			</div>
		</div>
		*/
		?>
		<div class="form-group">
			{!! Form::submit('Save Setting', ['class' => 'btn btn-primary btn-xs']) !!}
		</div>
		{!! Form::close() !!}
	</div><!-- /.col -->
</div>


@stop
