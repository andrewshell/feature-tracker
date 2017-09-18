@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>Delete Task</h1>
    </div>

    <div class="well text-center">
        <h2>Are you sure you want to delete &quot;{{ $task->name }}&quot;?</h2>
        <form method="POST" action="{{ route('tasks.destroy', $task) }}">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <a href="{{ route('tasks.index') }}" class="btn btn-warning">Cancel</a>
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </div>
</div>
@endsection
