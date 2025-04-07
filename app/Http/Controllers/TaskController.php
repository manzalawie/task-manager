<?php

namespace App\Http\Controllers;

use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    // Fetch all tasks
    public function index()
    {
        $tasks = $this->taskService->getAllTasks();
        return response()->json($tasks);
    }

    // Add new task
    public function store(Request $request)
    {
        $task = $this->taskService->createTask($request->all());
        return response()->json($task, 201);
    }

    // Update task
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $task = $this->taskService->updateTask($task, $request->all());
        return response()->json($task);
    }

    // Delete task
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $message = $this->taskService->deleteTask($task);
        return response()->json($message);
    }
}
