@extends('layouts.master')

@section('content')

<h1>User List</h1>
<p class="lead">Here's a list of all your Users. <a href="{{ route('users.create') }}">Add a new one?</a></p>
<hr>

@foreach($users as $user)
	<h3>{{ $user->email }}
	@if($user->username)
		<small><span class="fa fa-user"></span> {{$user->username}}</small>
    @endif
    </h3>
    <p>{{ str_limit($user->about,100,' [...]')}}</p>
    <p>
        <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-xs">View user</a>
        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-xs">Edit user</a>
    </p>
    <hr>
@endforeach

{!! $users->render() !!}

@stop