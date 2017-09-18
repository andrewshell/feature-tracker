@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>Create Metric</h1>
    </div>

    <form method="POST" action="{{ route('metrics.store') }}">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="5"></textarea>
        </div>

        <div class="checkbox">
            <label><input type="checkbox" name="decrement" value="1"> Decrement Value</label>
        </div>

        <div class="row">
        <div class="col-sm-4">

        <div class="form-group">
            <label for="min">Min</label>
            <input type="number" class="form-control" step="1" pattern="\d+" id="min" name="min" value="0">
        </div>

        </div>
        <div class="col-sm-4">

        <div class="form-group">
            <label for="max">Max</label>
            <input type="number" class="form-control" step="1" pattern="\d+" id="max" name="max" value="10">
        </div>

        </div>
        <div class="col-sm-4">

        <div class="form-group">
            <label for="default">Default</label>
            <input type="number" class="form-control" step="1" pattern="\d+" id="default" name="default" value="0">
        </div>

        </div>
        </div>

        <div class="form-group text-right">
            <button type="submit" class="btn btn-primary">Store Metric</button>
        </div>
    </form>

</div>
@endsection
