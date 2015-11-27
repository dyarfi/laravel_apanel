@extends('layouts.master')

@section('content')

<h1>Task List</h1>
<p class="lead">Here's a list of all your tasks. <a href="{{ route('tasks.create') }}">Add a new one?</a></p>
<hr>

@foreach($tasks as $task)
    <h3>{{ $task->title }}</h3>
    <p>{{ str_limit($task->description,200,' [...]')}}</p>
    <p>
        <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-info btn-xs">View Task</a>
        <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-primary btn-xs">Edit Task</a>
    </p>
    <hr>
@endforeach

{!! $tasks->render() !!}

@stop