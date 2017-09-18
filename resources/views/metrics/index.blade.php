@extends('layouts.app')

@section('content')
<div class="container">

    <div class="page-header">
        <div class="btn-group pull-right">
            <a href="{{ route('metrics.create') }}" class="btn btn-primary btn-sm">Add Metric</a>
        </div>
        <h1>Metrics</h1>
    </div>

    <table class="table table-striped table-hover">
        <tr>
            <th>Name</th>
            <th class="text-right" width="100">Min</th>
            <th class="text-right" width="100">Max</th>
            <th class="text-right" width="100">Default</th>
            <th class="text-right" width="100">Controls</th>
        </tr>
    @forelse ($metrics as $metric)
        <tr>
            <td>
                {{ $metric->name }}
                @if (true == $metric->decrement)
                (decrement)
                @endif
                <span
                    class="glyphicon glyphicon-info-sign"
                    aria-hidden="true"
                    data-toggle="popover"
                    data-trigger="hover"
                    data-content="{{ $metric->description }}"
                ></span>
            </td>
            <td align="right">{{ $metric->min }}</td>
            <td align="right">{{ $metric->max }}</td>
            <td align="right">{{ $metric->default }}</td>
            <td align="right"><div class="btn-group" role="group" aria-label="Controls">
                <a href="{{ route('metrics.edit', $metric) }}" class="btn btn-warning btn-xs">Edit</a>
                <a href="{{ route('metrics.delete', $metric) }}" class="btn btn-danger btn-xs">Delete</a>
            </div></td>
        </tr>
    @empty
        <tr>
            <td>No Metrics Defined</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    @endforelse
    </table>
@endsection
