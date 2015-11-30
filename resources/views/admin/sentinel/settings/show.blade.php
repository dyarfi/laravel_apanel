@extends('admin.template')

@section('body')

<h1>{{ $setting->name }}</h1>

<p class="lead">
    Description : {{ $setting->description }}
</p>
<p>
    Help Text : {{ $setting->help_text }}
</p>
<hr>

<div class="row">
    <div class="col-md-6">
        <a href="{{ route('admin.settings.index') }}" class="btn btn-info btn-xs">Back to all settings</a>
        <a href="{{ route('admin.settings.edit', $setting->id) }}" class="btn btn-primary btn-xs">Edit setting</a>
    </div>
    <div class="col-md-6 text-right">
        {!! Form::open([
            'method' => 'DELETE',
            'route' => ['admin.settings.delete', $setting->id]
        ]) !!}
            {!! Form::submit('Delete this user?', ['class' => 'btn btn-danger btn-xs']) !!}
        {!! Form::close() !!}
    </div>
</div>

@stop