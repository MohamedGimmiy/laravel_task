<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskCreationRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Http\Services\ITaskService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TasksController extends Controller
{
    protected ITaskService $taskService;

    public function __construct(ITaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * getting all tasks of all users needs authentication token
     */
    public function getAll(Request $request)
    {
        $tasks = $this->taskService->getAll($request);

        return response()->json([
            'message' => 'tasks returned successfully',
            'data' => $tasks
        ]);
    }

    /**
     * creating a task needs authentication token
     */
    public function store(TaskCreationRequest $request)
    {
        $data = [
            'title'       => $request->title,
            'description' => $request->description,
            'due_date'    => $request->due_date,
            'user_id'     => Auth::id(), // ✅ assign user_id here
            'priority' => $request->priority ?? 'Low'
        ];

        $task = $this->taskService->createTask($data);

        return response()->json([
            'data' => $task,
            'message' => 'Task created successfully',
        ]);
    }

    /**
     * updating a task needs authentication token
     */
    public function update(TaskUpdateRequest $request, $id)
    {

        $data = [
            'title'       => $request->title,
            'description' => $request->description,
            'due_date'    => $request->due_date,
            'status' => $request->status,
            'priority' => $request->priority
        ];

        $this->taskService->updateTask($id, $data, Auth::id());

        return response()->json([
            'message' => 'task updated successfully!'
        ]);
    }

    /**
     * update status needs authentication token
     */
    public function updateStatus(Request $request, $id)
    {

        $request->validate([
            'status' => 'required'
        ]);

        $data = [
            'status' => $request->status,
        ];
        $this->taskService->updateTaskStatus($id, $data, Auth::id());

        return response()->json([
            'message' => 'task updated successfully!'
        ]);
    }

    /**
     * display a task needs authentication token
     */
    public function show($id)
    {
        $task = $this->taskService->getTask($id);

        return response()->json([
            'message' => 'task returned successfully',
            'data' => $task
        ]);
    }

    /**
     * soft deleting a task needs authentication token
     */
    public function deleteTask($id)
    {
        $isdeleted = $this->taskService->deleteTask($id, Auth::id());
        if ($isdeleted) {
            return response()->json([
                'message' => 'Task deleted successfully',
            ]);
        }

        abort(404, 'Task not found');
    }
}
