<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::latest()->get();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'task_name' => 'required|max:255',
            'description' => 'nullable',
            'due_date' => 'nullable|date',
        ]);

        Task::create([
            'task_name' => $request->task_name,
            'description' => $request->description,
            'status' => 'Pending',
            'due_date' => $request->due_date,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task added!');
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'task_name' => 'required|max:255',
            'description' => 'nullable',
            'due_date' => 'nullable|date',
            'status' => 'required|in:Pending,Completed',
        ]);

        $task->update($request->all());

        return redirect()->route('tasks.index')->with('success', 'Task updated!');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted!');
    }

    public function updateStatus(Task $task)
    {
        $task->update([
            'status' => $task->status === 'Pending' ? 'Completed' : 'Pending'
        ]);
        return redirect()->route('tasks.index')->with('success', 'Status updated!');
    }
}