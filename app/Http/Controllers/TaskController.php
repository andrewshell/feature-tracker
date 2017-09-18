<?php

namespace App\Http\Controllers;

use App\Metric;
use App\Task;
use App\User;
use App\Jobs\CalculateCumulativeScore;
use Illuminate\Http\Request;

class TaskController extends Controller
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
        $active = __FUNCTION__;
        $tasks = Task::orderBy('cumulative_score', 'DESC')
            ->where('status', '<>', 'Done')
            ->with('assignedUser')
            ->get();

        return view('tasks.index', compact('active', 'tasks'));
    }

    public function completed()
    {
        $active = __FUNCTION__;
        $tasks = Task::orderBy('cumulative_score', 'DESC')
            ->where('status', 'Done')
            ->with('assignedUser')
            ->get();

        return view('tasks.index', compact('active', 'tasks'));
    }

    /**
     * Return a json listing of the matched resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function autocomplete(Request $request)
    {
        $query = $request->get('query', '');
        $tasks = Task::select('id', 'name')->where("name","LIKE","%{$query}%")->get();

        return response()->json($tasks);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $metrics = Metric::orderBy('id')->get();
        $users = User::orderBy('name')->get();

        return view('tasks.create', compact('metrics', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        $metrics = $request->get('metric');
        $parents = array_values($request->get('depends_on', []));

        $task = new Task;
        $task->name = $request->get('name');
        $task->description = preg_replace('~\R~u', "\n", $request->get('description', ''));
        $task->assigned_user_id = $request->get('assigned_user_id');
        $task->status = $request->get('status');
        $task->metrics = $metrics;
        $task->local_score = array_sum($metrics);
        $task->cumulative_score = array_sum($metrics);
        $task->parent_count = count($parents);
        $task->child_id_list = '';
        $task->save();

        $task->parents()->sync($parents);

        CalculateCumulativeScore::dispatch($task);

        return redirect()->route('tasks.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        $metrics = Metric::orderBy('id')->get();
        $users = User::orderBy('name')->get();

        return view('tasks.edit', compact('task', 'metrics', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        $metrics = $request->get('metric');
        $parents = array_values($request->get('depends_on', []));

        // @todo Handle decrementing metrics correctly

        $task->name = $request->get('name');
        $task->description = preg_replace('~\R~u', "\n", $request->get('description', ''));
        $task->assigned_user_id = $request->get('assigned_user_id');
        $task->status = $request->get('status');
        $task->metrics = $metrics;
        $task->local_score = array_sum($metrics);
        $task->cumulative_score = array_sum($metrics);
        $task->parent_count = count($parents);

        $task->save();

        $task->parents()->sync($parents);

        dispatch(new CalculateCumulativeScore($task));

        return redirect()->route('tasks.index');
    }

    /**
     * Show the form for deleting the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function delete(Task $task)
    {
        return view('tasks.delete', compact('task'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index');
    }
}
