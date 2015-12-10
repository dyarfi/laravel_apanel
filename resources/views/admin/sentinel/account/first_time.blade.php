@extends('admin.template_login')

@section('title')
First Setup
@stop

@section('body')

	<div class="page-header">
		<h1>My Account</h1>
	</div>

	<div class="row bg-info">
		<div class="col-md-12">
			<div class="clearfix">
				<h3>
					First setup
					<small>Select for migrate</small>
				</h3>
				<div class="list-group">
					{!! Form::open() !!}	
						<div class="col-md-6">
						{!! Form::label('email','Email') !!}
						{!! Form::text('email') !!}
						</div>
						<div class="col-md-6">	
						{!! Form::label('password','Password') !!}
						{!! Form::password('password') !!}
						</div>					
						<div class="col-md-12">	
							{!! Form::label('migrate','Migrate ?') !!}
							{!! Form::checkbox('migrate',1) !!}						
						</div>
						<div class="col-md-12">	
							{!! Form::submit('Setup !',['class'=>'btn btn-default btn-lg']) !!}
						</div>						
					{!! Form::close() !!}
				</div>
			</div>
			<hr/>
			@if(isset($user))
			<div class="clearfix">
				<h3>
					My Logged In Sessions
					<small>Click to Kill</small>
				</h3>
				<div class="list-group">
					<a href="{{ URL::to('account/kill') }}" class="list-group-item">Kill all <small>(including my session)</small></a>
					<a href="{{ URL::to('account/kill-all') }}" class="list-group-item">Kill all <small>(excluding my session)</small></a>
				</div>
				<div class="list-group">				
					@foreach ($user->persistences as $index => $p)
						@if ($p->code === $persistence->check())
							<a href="{{ URL::to("account/kill/{$p->code}") }}" class="list-group-item active">
								{{ $p->created_at->format('F d, Y - h:ia') }}
								<span class="label label-info">{{ $p->browser }}</span>
								<span class="badge">{{ $p->last_used }}</span>
								<span class="badge">You</span>
							</a>
						@else
							<a href="{{ URL::to("account/kill/{$p->code}") }}" class="list-group-item">
								{{ $p->created_at->format('F d, Y - h:ia') }}
								<span class="label label-info">{{ $p->browser }}</span>
								<span class="badge">{{ $p->last_used }}</span>
							</a>
						@endif
					@endforeach			
				</div>
			</div>
			@endif
		</div>
		
		@if (isset($user))
		<div class="col-md-12">
			<h3>Activation</h3>
			@if (Activation::completed($user))
				<a class="btn btn-danger" href="{{ URL::to('deactivate') }}">Deactivate</a>
			@else
				<a class="btn btn-default" href="{{ URL::to('reactivate') }}">Activate</a>
			@endif		
		</div>
		@endif

@stop
