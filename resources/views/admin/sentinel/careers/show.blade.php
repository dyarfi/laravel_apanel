@extends('admin.template')

@section('body')

<h1>{{ $task->title }}</h1>
<p class="lead">
@if ($task->image !== '')
    <a href="{{ asset('uploads/'.$task->image) }}" target="_blank" title="{{ $task->image }}"/>
        <img src="{{ asset('uploads/'.$task->image) }}" class="pull-left img-responsive"/>
    </a>
@endif
{{ $task->description }}
</p>
<hr>

<div class="row">
    <div class="col-md-6">
        <a href="{{ route('admin.tasks.index') }}" class="btn btn-info btn-xs">Back to all tasks</a>
        <a href="{{ route('admin.tasks.edit', $task->id) }}" class="btn btn-primary btn-xs">Edit Task</a>
    </div>
    <div class="col-md-6 text-right">
        {!! Form::open([
            'method' => 'DELETE',
            'route' => ['admin.tasks.trash', $task->id]
        ]) !!}
            {!! Form::submit('Delete this task?', ['class' => 'btn btn-danger btn-xs']) !!}
        {!! Form::close() !!}
    </div>
</div>

@stop