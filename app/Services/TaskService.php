<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Support\Facades\Validator;

class TaskService
{
    public function getAllTasks()
    {
        return Task::all();
    }

    public function createTask(array $data)
    {
        // Validate task data
        $validator = Validator::make($data, [
            'title' => 'required|string|max:255',
            'status' => 'required|in:pending,in-progress,completed',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        return Task::create($data);
    }

    public function updateTask(Task $task, array $data)
    {
        $validator = Validator::make($data, [
            'title' => 'nullable|string|max:255',
            'status' => 'nullable|in:pending,in-progress,completed',
            'user_id' => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $task->update($data);
        return $task;
    }

    public function deleteTask(Task $task)
    {
        $task->delete();
        return ['message' => 'Task deleted successfully'];
    }
}
