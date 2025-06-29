<?php

namespace App\Http\Repositories;

interface ITaskRepo
{

    function getAll($request);

    function getUserTasks($userId);

    function getById($id);

    function create(array $data);

    function update($id, array $data, $userId);

    function delete($id, $userId);

    function updateStatus($id, array $data, $userId);

}
