@extends('admin.template')

@section('body')

<h1 class="green">Profile <small>{{ $user->email }}</small></h1>
<hr>
<div class="row-fluid">
	<div class="row-fluid">
		{!! Form::open([
			'method' => 'POST',
	       	'route' => ['admin.users.edit', $user->id],
	       	'class' =>'form-horizontal'
		]) !!}

			{!! Form::hidden('_private', base64_encode(csrf_token() .'::'. $user->email .'::'. $user->roles()->first()->id) ) !!}	

			<div class="form-group">
				<div class="col-md-12">	
					<p class="lead"><span class="fa fa-pencil-square-o"></span> Joined : {{ $user->created_at }}</p>
					@if (count($user->email) === 1)
				    	<p class="lead"><span class="fa fa-envelope-o"></span> Email : {{ $user->email }}</p>
					@else
					    You don't have an email!
					@endif 

					@if (count($user->provider) === 1)
				    	<p class="lead"><span class="fa fa-check-square-o"></span> Register with : {{ $user->provider }}</p>
					@else
					    You don't have any providers!
					@endif 
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-12">		
				    {!! Form::label('username', 'Username:', ['class' => 'control-label']) !!}
				    {!! Form::text('username', $user->username, ['class' => 'form-control']) !!}
				</div>
				<div class="col-md-6">
				    {!! Form::label('first_name', 'First Name:', ['class' => 'control-label']) !!}
				    {!! Form::text('first_name', $user->first_name, ['class' => 'form-control']) !!}
				</div>
				<div class="col-md-6">
				{!! Form::label('last_name', 'Last Name:', ['class' => 'control-label']) !!}
			    {!! Form::text('last_name', $user->last_name, ['class' => 'form-control']) !!}			
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-12">
				    {!! Form::label('about', 'About:', ['class' => 'control-label']) !!}
				    {!! Form::textarea('about', $user->about, ['class' => 'form-control']) !!}
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-12">
				    {!! Form::label('avatar', 'Avatar:', ['class' => 'control-label']) !!}
				    {!! Form::text('avatar', $user->avatar, ['class' => 'form-control']) !!}		
				</div>
			</div>

			<div class="space-6"></div>

			<div class="form-group">
				<div class="col-md-12">
				<span class="clearfix">Skins :</span>
				@if(config('setting.attributes'))
					@foreach (config('setting.attributes') as $setting => $attribute)
						@if ($setting == 'skins')
							@foreach ($attribute as $attr => $val)	
								<div class="col-md-2">
									<div class="pull-left" style="background-color:{{ $attr }}">
										{!! Form::label('attributes[skins]', $attr, ['class' => 'control-label white']) !!}									
										{!! Form::radio('attributes[skins]', $attr, ($user->attributes->skins === $attr ? true : false)) !!}		
									</div>						
								</div>
							@endforeach
						@endif
					@endforeach
				@endif
				</div>
			</div>
			
			<div class="clearfix space-6"></div>

			<div class="form-group">
				<div class="col-md-12">
				<span class="clearfix">Skins :</span>
				@if(config('setting.attributes'))
					@foreach (config('setting.attributes') as $setting => $attribute)
						@if ($setting == 'skins')
							@foreach ($attribute as $attr => $val)	
								<div class="col-md-2">
									<div class="pull-left" style="background-color:{{ $attr }}">
										{!! Form::label('attributes[skins]', $attr, ['class' => 'control-label white']) !!}									
										{!! Form::radio('attributes[skins]', $attr, ($user->attributes->skins === $attr ? true : false)) !!}		
									</div>						
								</div>
							@endforeach
						@endif
					@endforeach
				@endif
				</div>
			</div>
			
			<div class="clearfix space-6"></div>

			<div class="form-group">
				<div class="col-md-12">
				{!! Form::submit('Update Profile', ['class' => 'btn btn-primary btn-xs']) !!}
				</div>
			</div>
			
		{!! Form::close() !!}
		
	</div>
</div>

@stop