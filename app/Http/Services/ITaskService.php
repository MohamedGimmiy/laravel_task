<?php

namespace App\Http\Services;


interface ITaskService {

    public function getUserTasks($userId);

    public function createTask(array $data);

    public function updateTask($id, array $data, $userId);

    public function deleteTask($id, $userId);

    public function getTask($id);
}