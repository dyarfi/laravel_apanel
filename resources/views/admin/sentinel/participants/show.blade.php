@extends('admin.template')

@section('body')
<div class="container-fluid">
    <h3>{{ $participant->name }}</h3>
    <h4 class="red">Email</h4>
    <ul class="list-unstyled"><li>{{ $participant->email }}</li></ul>
    @if($participant->phone_number)
    <h4 class="red">Phone Number</h4>    
    <div class="row-fluid">
        {{ $participant->phone_number }}
    </div>
    @endif
    @if($participant->phone_home)
    <h4 class="red">Phone Home</h4>    
    <div class="row-fluid">
        {{ $participant->phone_home }}
    </div>
    @endif
    @if($participant->address)
    <h4 class="red">Address</h4>    
    <div class="row-fluid">
        {{ $participant->address }}
    </div>
    @endif
    <h4 class="red">About</h4>    
    <div class="row-fluid">
        {{ $participant->about }}
    </div>
    <hr/>
    <div class="row">
        <div class="col-md-5 col-xs-6">
            <a href="{{ route('admin.participants.index') }}" class="btn btn-info btn-xs">Back to all participants</a>
            <a href="{{ route('admin.participants.edit', $participant->id) }}" class="btn btn-primary btn-xs">Edit participant</a>
        </div>
        <div class="col-md-5 col-xs-6 text-right">
            {!! Form::open([
                'method' => 'DELETE',
                'route' => ['admin.participants.trash', $participant->id]
            ]) !!}
                {!! Form::submit('Delete this participant?', ['class' => 'btn btn-danger btn-xs']) !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>

@stop