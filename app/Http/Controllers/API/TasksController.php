<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskCreationRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Http\Services\ITaskService;
use Illuminate\Support\Facades\Auth;

class TasksController extends Controller
{
    protected ITaskService $taskService;

    public function __construct(ITaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function store(TaskCreationRequest $request)
    {
        $data = [
            'title'       => $request->title,
            'description' => $request->description,
            'due_date'    => $request->due_date,
            'user_id'     => Auth::id(), // ✅ assign user_id here
        ];

        $task = $this->taskService->createTask($data);

        return response()->json([
            'data' => $task,
            'message' => 'Task created successfully',
        ]);
    }

    public function update(TaskUpdateRequest $request, $id){

        $data = [
            'title'       => $request->title,
            'description' => $request->description,
            'due_date'    => $request->due_date,
            'status' => $request->status
        ];

        $this->taskService->updateTask($id,$data, Auth::id());
        
         return response()->json([
            'message' => 'task updated successfully!'
         ]);
    }

    public function show($id){
        $task = $this->taskService->getTask($id);

        return response()->json([
            'message' => 'task returned successfully',
            'data' => $task
        ]);
    }
}
