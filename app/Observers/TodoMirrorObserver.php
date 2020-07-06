<?php

namespace App\Observers;

use App\TodoMirror;
use App\Todo;
class TodoMirrorObserver
{
    /**
     * Handle the todo mirror "created" event.
     *
     * @param  \App\TodoMirror  $todoMirror
     * @return void
     */
    public function created(TodoMirror $todoMirror)
    {
        if(!Todo::where('id', $todoMirror->id)->exists()){
            $todo = new Todo();
            $todo->id = $todoMirror->id;
            $todo->name = $todoMirror->name;
            $todo->description = $todoMirror->description;
            $todo->created_at = $todoMirror->created_at;
            $todo->updated_at = $todoMirror->updated_at;
            $todo->save();

        }        
    }

    /**
     * Handle the todo mirror "updated" event.
     *
     * @param  \App\TodoMirror  $todoMirror
     * @return void
     */
    public function updated(TodoMirror $todoMirror)
    {
        //
    }

    public function updating(TodoMirror $todoMirror)
    {
        if($todoMirror->isDirty('name')){
            Todo::find($todoMirror->id)->saveQuietly(['name' => $todoMirror->name]);
        }

        if($todoMirror->isDirty('description')){
            Todo::find($todoMirror->id)->saveQuietly(['description' => $todoMirror->description]);
        }

    }
    /**
     * Handle the todo mirror "deleted" event.
     *
     * @param  \App\TodoMirror  $todoMirror
     * @return void
     */
    public function deleted(TodoMirror $todoMirror)
    {
        Todo::find($todoMirror->id)->deleteQuietly();
    }

    /**
     * Handle the todo mirror "restored" event.
     *
     * @param  \App\TodoMirror  $todoMirror
     * @return void
     */
    public function restored(TodoMirror $todoMirror)
    {
        //
    }

    /**
     * Handle the todo mirror "force deleted" event.
     *
     * @param  \App\TodoMirror  $todoMirror
     * @return void
     */
    public function forceDeleted(TodoMirror $todoMirror)
    {
        //
    }
}
