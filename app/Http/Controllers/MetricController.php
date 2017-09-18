<?php

namespace App\Http\Controllers;

use App\Metric;
use Illuminate\Http\Request;

class MetricController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $metrics = Metric::get();

        return view('metrics.index', compact('metrics'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('metrics.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $min = intval($request->get('min'));
        $max = intval($request->get('max'));

        if ($min > $max) {
            $tmp = $max;
            $max = $min;
            $min = $tmp;
            unset($tmp);
        }

        $metric = new Metric();
        $metric->name = $request->get('name');
        $metric->description = $request->get('description');
        $metric->min = $min;
        $metric->max = $max;
        $metric->default = $request->get('default');
        $metric->decrement = $request->get('decrement', 0);
        $metric->save();

        return redirect()->route('metrics.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Metric  $metric
     * @return \Illuminate\Http\Response
     */
    public function show(Metric $metric)
    {
        return view('metrics.show', compact('metric'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Metric  $metric
     * @return \Illuminate\Http\Response
     */
    public function edit(Metric $metric)
    {
        return view('metrics.edit', compact('metric'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Metric  $metric
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Metric $metric)
    {
        $min = intval($request->get('min'));
        $max = intval($request->get('max'));

        if ($min > $max) {
            $tmp = $max;
            $max = $min;
            $min = $tmp;
            unset($tmp);
        }

        $metric->name = $request->get('name');
        $metric->description = $request->get('description');
        $metric->min = $min;
        $metric->max = $max;
        $metric->default = $request->get('default');
        $metric->decrement = $request->get('decrement', 0);
        $metric->save();

        return redirect()->route('metrics.index');
    }

    /**
     * Show the form for deleting the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function delete(Metric $metric)
    {
        return view('metrics.delete', compact('metric'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Metric  $metric
     * @return \Illuminate\Http\Response
     */
    public function destroy(Metric $metric)
    {
        $metric->delete();

        return redirect()->route('metrics.index');
    }
}
