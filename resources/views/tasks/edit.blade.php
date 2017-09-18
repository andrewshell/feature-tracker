@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>Edit Task</h1>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('tasks.update', $task) }}">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $task->name }}">
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="5">{{ $task->description }}</textarea>
        </div>

        <div class="form-group">
        <label for="assigned_user_id">Assigned User</label>
        <select class="form-control" id="assigned_user_id" name="assigned_user_id">
            <option value="">-- None --</option>
            @foreach ($users as $user)
            <option value="{{ $user->id }}"@if ($task->assigned_user_id === $user->id) selected @endif>{{ $user->name }}</option>
            @endforeach
        </select>
        </div>

        <div class="form-group">
        <label for="status">Status</label>
        <select class="form-control" id="status" name="status">
            @foreach (\App\Task::$STATUSES as $status)
            <option value="{{ $status }}"@if ($task->status === $status) selected @endif>{{ $status }}</option>
            @endforeach
        </select>
        </div>

        @foreach ($metrics as $metric)
        <div class="form-group">
            <label for="metric{{ $metric->id }}">
                {{ $metric->name }}
                <span
                    class="glyphicon glyphicon-info-sign"
                    aria-hidden="true"
                    data-toggle="popover"
                    data-trigger="hover"
                    data-content="{{ $metric->description }}"
                ></span>
            </label>
            <div class="input-group">
            <input
                type="text"
                id="metric{{ $metric->id }}"
                name="metric[{{ $metric->id }}]"
                data-provide="slider"
                data-slider-min="{{ $metric->min }}"
                data-slider-max="{{ $metric->max }}"
                data-slider-step="1"
                data-slider-value="{{ $task->metric($metric->id) }}"
            >
            </div>
        </div>
        @endforeach

        <div class="form-group">
            <label for="dependencies">Depends On</label>
        </div>

        <ul class="list-inline" id="dependencies">
        @foreach ($task->parents as $parent)
            <li class="dependency" id="dependency-{{ $parent->id }}"><input type="hidden" name="depends_on[{{ $parent->id }}]" value="{{ $parent->id }}"><button class="btn btn-link"><span class="glyphicon glyphicon-remove"></span></button>{{ $parent->name }}</span></button></li>
        @endforeach
        </ul>

        <div class="form-group">
            <div class="input-group">
                <input type="text" class="form-control" id="dependency">
                <span class="input-group-btn">
                    <button
                        id="add-dependency"
                        class="btn btn-primary"
                        data-toggle="tooltip"
                        data-placement="top"
                        title="Add Dependency"><span class="glyphicon glyphicon-plus" ></span></button>
                </span>
            </div>
        </div>

        <div class="form-group text-right">
            <button type="submit" class="btn btn-primary">Update Task</button>
        </div>
    </form>

</div>
@endsection

@section('scripts')
    @include('scripts.dependencies');
@endsection
