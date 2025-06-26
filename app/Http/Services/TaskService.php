<?php

namespace App\Http\Services;

use App\Http\Repositories\ITaskRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TaskService implements ITaskService {


    protected $taskRepo;

    public function __construct(ITaskRepo $taskRepo)
    {
        $this->taskRepo = $taskRepo;
    }   
    
    public function getTask($id)
    {
        $task =  $this->taskRepo->getById($id);
        if(empty($task)){
            abort(404, 'Not found');
        }
        return $task;
    }
    public function getUserTasks($userId)
    {
        return $this->taskRepo->getAll($userId);
    }

    public function createTask(array $data)
    {
        return $this->taskRepo->create($data);
    }

    public function updateTask($id, array $data, $userId)
    {
        $task = $this->taskRepo->getById($id, Auth::id());
        if(empty($task)){
            abort(404, 'Not Found');
        }

        if(!empty($data['status']) && $data['status'] == 'Completed' && $task->status != 'InProgress'){
            abort(400, 'Bad Request');
        }
        return $this->taskRepo->update($id, $data, $userId);

    }

    public function deleteTask($id, $userId)
    {
        return $this->taskRepo->delete($id, $userId);
    }


}

