@extends('layouts.master')

@section('content')

<h1>Welcome Home</h1>
<p class="lead">
Self Task Manager Application V.1.0
</p>
<hr>

<a href="{{ route('tasks.index') }}" class="btn btn-info btn-xs">View Tasks</a>
<a href="{{ route('tasks.create') }}" class="btn btn-primary btn-xs">Add New Task</a>

@stop