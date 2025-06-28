<?php

namespace App\Http\Services;


interface ITaskService {

    function getAll($request);

    function getUserTasks($userId);

    function createTask(array $data);

    function updateTask($id, array $data, $userId);

    public function updateTaskStatus($id, array $data, $user_id);

    function deleteTask($id, $userId);

    function getTask($id);
}