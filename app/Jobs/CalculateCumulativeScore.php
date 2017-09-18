<?php

namespace App\Jobs;

use App\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CalculateCumulativeScore implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $task;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $childIds = [];
        $cumulativeScore = $this->task->local_score;

        foreach ($this->task->children as $child) {
            $cumulativeScore += $child->cumulative_score;
            $childIds = array_merge($childIds, explode(',', $child->child_id_list));
        }

        $this->task->cumulative_score = $cumulativeScore;
        $this->task->child_id_list = implode(',', array_unique($childIds));
        $this->task->save();

        foreach ($this->task->parents as $parent) {
            CalculateCumulativeScore::dispatch($parent);
        }
    }
}
