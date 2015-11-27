@extends('layouts.master')

@section('content')

<h1>{{ $user->name }}</h1>

<p class="lead">
    {{ $user->about }}
</p>
<hr>

<div class="row">
    <div class="col-md-6">
        <a href="{{ route('users.index') }}" class="btn btn-info btn-xs">Back to all users</a>
        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-xs">Edit user</a>
    </div>
    <div class="col-md-6 text-right">
        {!! Form::open([
            'method' => 'DELETE',
            'route' => ['users.destroy', $user->id]
        ]) !!}
            {!! Form::submit('Delete this user?', ['class' => 'btn btn-danger btn-xs']) !!}
        {!! Form::close() !!}
    </div>
</div>

@stop