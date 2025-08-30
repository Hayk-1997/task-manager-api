<?php

namespace App\Http\Controllers;

use App\Events\TaskAssigned;
use App\Events\TaskRemoved;
use App\Events\TaskUpdated;
use App\Http\Requests\Task\CreateTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Models\Status;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::with(['assignedUser', 'creator']);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->search($request->search);
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->byStatus($request->status);
        }

        // Filter by assignee
        if ($request->has('assignee') && $request->assignee) {
            $query->byAssignee($request->assignee);
        }

        // Sort by due date
        $query->orderBy('due_date', 'asc');
        $perPage = $request->query('per_page', 10);

        return response()->json($query->paginate($perPage));
    }

    public function store(CreateTaskRequest $request)
    {
        $task = Task::create([
            ...$request->all(),
            'created_by' => auth()->id(),
            'status' => Status::where('label', $request['status'])->first()->id,
        ]);

        $task->load(['assignedUser', 'creator']);

        $assignedUser = $task->assignedUser;
        event(new TaskAssigned($task, $assignedUser));

        return response()->json($task, 201);
    }

    public function update(UpdateTaskRequest $request)
    {
        $task = Task::find($request['id']);

        $task->update($request->all());
        $task->load(['assignedUser', 'creator']);
        event(new TaskUpdated($task, $task->assignedUser));

        return response()->json($task);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        event(new TaskRemoved($task, $task->assignedUser));
        return response()->json(['message' => $task]);
    }
}
