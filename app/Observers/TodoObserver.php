<?php

namespace App\Observers;

use App\Todo;
use App\TodoMirror;
class TodoObserver
{
    /**
     * Handle the todo "created" event.
     *
     * @param  \App\Todo  $todo
     * @return void
     */
    public function created(Todo $todo)
    {
        if (!TodoMirror::where('id', $todo->id)->exists()) {
            $todoMirror = new TodoMirror();
            $todoMirror->id = $todo->id;
            $todoMirror->name = $todo->name;
            $todoMirror->description = $todo->description;
            $todoMirror->created_at = $todo->created_at;
            $todoMirror->updated_at = $todo->updated_at;
            $todoMirror->save();            
        }        
    }

    /**
     * Handle the todo "updated" event.
     *
     * @param  \App\Todo  $todo
     * @return void
     */
    public function updated(Todo $todo)
    {
        //
    }


    public function updating(Todo $todo)
    {
        if($todo->isDirty('name')){
            TodoMirror::find($todo->id)->saveQuietly(['name' => $todo->name]);
        }

        if($todo->isDirty('description')){
            TodoMirror::find($todo->id)->saveQuietly(['description' => $todo->description]);
        }

            

    }

    /**
     * Handle the todo "deleted" event.
     *
     * @param  \App\Todo  $todo
     * @return void
     */
    public function deleted(Todo $todo)
    {
        // if($todo->isDirty('name')){
            TodoMirror::find($todo->id)->deleteQuietly();
        // }

        // if($todo->isDirty('description')){
            // TodoMirror::find($todo->id)->saveQuietly(['description' => $todo->description]);
        // }
        
    }

    /**
     * Handle the todo "restored" event.
     *
     * @param  \App\Todo  $todo
     * @return void
     */
    public function restored(Todo $todo)
    {
        //
    }

    /**
     * Handle the todo "force deleted" event.
     *
     * @param  \App\Todo  $todo
     * @return void
     */
    public function forceDeleted(Todo $todo)
    {
        //
    }
}
