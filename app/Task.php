<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public static $STATUSES = ['New', 'Planned', 'In Progress', 'Testing', 'Done'];

    protected $dates = ['created_at', 'updated_at'];

    /**
     * Get the user that's assigned to this task.
     */
    public function assignedUser()
    {
        return $this->belongsTo('App\User');
    }

    public function parents()
    {
        return $this->belongsToMany('App\Task', 'dependencies', 'child_id', 'parent_id');
    }

    public function children()
    {
        return $this->belongsToMany('App\Task', 'dependencies', 'parent_id', 'child_id');
    }

    public function getMetricsAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setMetricsAttribute($value)
    {
        $this->attributes['metrics'] = json_encode($value);
    }

    public function metric($id)
    {
        if (isset($this->metrics[$id])) {
            return $this->metrics[$id];
        } else {
            $metric = Metric::find($id);
            return $metric->default;
        }
    }
}
