<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Todo;
use App\TodoMirror;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Todo::orderBy('id')
            ->orderByDesc('created_at')
            ->paginate(5);
        // print_r($tasks);die;
        return view('tasks', ['tasks' => $tasks]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate the given request
        $data = $this->validate($request, [
            'name' => 'required|string|max:255',
            'description' => '',
        ]);
        // create a new incomplete task with the given title
        if($request->get('mainTableOn')){
            Todo::create([
                'name' => $data['name'],
                'description' => $data['description'],
            ]);            
        } else {
            TodoMirror::create([
                'name' => $data['name'],
                'description' => $data['description'],
            ]);                        
        }

        // flash a success message to the session
        session()->flash('status', 'Task Created!');

        // redirect to tasks index
        return redirect('/tasks');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $task = Todo::findOrFail($id);
        dd($request);
        // $task->id = $id;
        $task->name = $request['name'];
        $task->description = $request['description'];
        $task->save();

        // flash a success message to the session
        session()->flash('status', 'Task Updated!');

        // redirect to tasks index
        return redirect('/tasks');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
