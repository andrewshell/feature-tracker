@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>Delete Metric</h1>
    </div>

    <form method="POST" action="{{ route('metrics.update', $metric) }}">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}

        <div class="well text-center">
            <h2>Are you sure you want to destroy the metric &quot;{{ $metric->name }}&quot;?</h2>
            <h3>This action cannot be undone.</h3>

            <a href="{{ route('metrics.index') }}" class="btn btn-warning">Cancel</a>
            <button type="submit" class="btn btn-danger">Destroy Metric</button>
        </div>
    </form>

</div>
@endsection
