@extends('layouts.app')

@section('content')
<div class="container">

    <div class="page-header">
        <div class="btn-group pull-right">
            <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-sm">Add Task</a>
        </div>
        <h1>Tasks</h1>
    </div>

    <p>
        <ul class="nav nav-tabs">
            <li role="presentation"@if ($active == 'index') class="active"@endif><a href="{{ route('tasks.index') }}">Active</a></li>
            <li role="presentation"@if ($active == 'completed') class="active"@endif><a href="{{ route('tasks.completed') }}">Completed</a></li>
        </ul>
    </p>

    <table class="table table-striped table-hover">
        <tr>
            <th>Name</th>
            <th class="text-center" width="150">Assigned User</th>
            <th class="text-center" width="100">Status</th>
            <th class="text-right" width="100">Score</th>
            <th class="text-center" width="100">Controls</th>
        </tr>
    @forelse ($tasks as $task)
        <tr>
            <td align="left">
                {{ $task->name }}
                @if (!empty($task->description))
                <span
                    class="glyphicon glyphicon-info-sign"
                    aria-hidden="true"
                    data-toggle="popover"
                    data-trigger="hover"
                    data-html=true
                    data-content="@markdown($task->description)"
                ></span>
                @endif
            </td>
            @if (empty($task->assignedUser))
            <td align="center">&mdash;</td>
            @else
            <td align="center">{{ $task->assignedUser->name }}</td>
            @endif
            <td align="center">{{ $task->status }}</td>
            <td align="right">{{ $task->cumulative_score }}</td>
            <td align="center"><div class="btn-group" role="group" aria-label="Controls">
                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning btn-xs">Edit</a>
                <a href="{{ route('tasks.delete', $task) }}" class="btn btn-danger btn-xs">Delete</a>
            </div></td>
        </tr>
    @empty
        <tr>
            <td>No Tasks Defined</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    @endforelse
    </table>
@endsection
