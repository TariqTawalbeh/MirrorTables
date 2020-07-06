<?php

namespace Tests\TodoTasks;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Todo;
use App\TodoMirror;

class TasksTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** @test */
    public function can_see_tasks_create_form()
    {
        $this->get(route('tasks.index'))
            ->assertViewIs('tasks');
    }

        /** @test */
    public function can_create_a_new_task_and_reflect_on_mirror()
    {
        Todo::truncate();
        TodoMirror::truncate();

        $request_data = [
            'name' => 'category',
            'description' => 'slug name',            
        ];

        $response = $this->json('post', route('tasks.store'), $request_data );

        $response->assertRedirect(route('tasks.index'));
        $response->assertSessionHas('success');
        tap(Todo::first(), function ($todo) {
            $this->assertNotNull($todo);
            $this->assertEquals('category', $todo->name);
            $this->assertEquals('slug name', $todo->description);
        });

        tap(TodoMirror::first(), function ($todoMirror) {
            $this->assertNotNull($todoMirror);
            $this->assertEquals('category', $todoMirror->name);
            $this->assertEquals('slug name', $todoMirror->description);
        });

    }

        /** @test */
    public function can_update_a_task_and_reflect_on_mirror()
    {
        Todo::truncate();
        TodoMirror::truncate();
        $todo = factory(Todo::class)->create();
        $data = [
            'name'   => 'name',
            'value' => 'category_2',
            'mirror' => 0,
            'pk' => $todo->id
        ];

        $response = $this->post(route('task.updated'), $data, array('HTTP_X-Requested-With' => 'XMLHttpRequest'));

        $response->assertStatus(200);
        tap(Todo::first(), function ($todo) {
            $this->assertEquals('category_2', $todo->name);
        });

        tap(TodoMirror::first(), function ($todoMirror) {
            $this->assertEquals('category_2', $todoMirror->name);
        });

    }

    /** @test */
    public function can_delete_a_tasks_and_reflect_on_mirror()
    {
        Todo::truncate();
        TodoMirror::truncate();

        $todo = factory(Todo::class)->create();

        $response = $this->delete(route('task.destroy', ['id' => $todo->id]));

        $response->assertStatus(200);

        $this->assertCount(0, Todo::all());
        $this->assertCount(0, TodoMirror::all());
    }

}
