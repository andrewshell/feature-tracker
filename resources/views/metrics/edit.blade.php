@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>Edit Metric</h1>
    </div>

    <form method="POST" action="{{ route('metrics.update', $metric) }}">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $metric->name }}">
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="5">{{ $metric->description }}</textarea>
        </div>

        <div class="checkbox">
            <label><input type="checkbox" name="decrement" value="1"
            @if (true == $metric->decrement)
            checked
            @endif
            > Decrement Value</label>
        </div>

        <div class="row">
        <div class="col-sm-4">

        <div class="form-group">
            <label for="min">Min</label>
            <input type="number" class="form-control" step="1" pattern="\d+" id="min" name="min" value="{{ $metric->min }}">
        </div>

        </div>
        <div class="col-sm-4">

        <div class="form-group">
            <label for="max">Max</label>
            <input type="number" class="form-control" step="1" pattern="\d+" id="max" name="max" value="{{ $metric->max }}">
        </div>

        </div>
        <div class="col-sm-4">

        <div class="form-group">
            <label for="default">Default</label>
            <input type="number" class="form-control" step="1" pattern="\d+" id="default" name="default" value="{{ $metric->default }}">
        </div>

        </div>
        </div>

        <div class="form-group text-right">
            <button type="submit" class="btn btn-primary">Update Metric</button>
        </div>
    </form>

</div>
@endsection
