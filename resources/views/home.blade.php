@extends('layouts.master')

@section('content')

<h1>Welcome Home</h1>
<p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maiores, possimus, ullam? Deleniti dicta eaque facere, facilis in inventore mollitia officiis porro totam voluptatibus! Adipisci autem cumque enim explicabo, iusto sequi.</p>
<hr>

<a href="{{ route('tasks.index') }}" class="btn btn-info btn-xs">View Tasks</a>
<a href="{{ route('tasks.create') }}" class="btn btn-primary btn-xs">Add New Task</a>

@stop