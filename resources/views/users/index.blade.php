@extends('layouts.master')

@section('content')

<h1>User List</h1>
<p class="lead">Here's a list of all your Users. <a href="{{ route('apanel.users.create') }}">Add a new one?</a></p>
<hr>

@foreach($users as $user)
    <h3>{{ $user->name }}</h3>
    <p>{{ str_limit($user->about,100,' [...]')}}</p>
    <p>
        <a href="{{ route('apanel.users.show', $user->id) }}" class="btn btn-info btn-xs">View user</a>
        <a href="{{ route('apanel.users.edit', $user->id) }}" class="btn btn-primary btn-xs">Edit user</a>
    </p>
    <hr>
@endforeach

{!! $users->render() !!}

@stop