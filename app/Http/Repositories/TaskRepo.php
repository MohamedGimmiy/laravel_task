<?php

namespace App\Http\Repositories;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskRepo implements ITaskRepo {

    public function getAll($request){

        return Task::when($request->from && $request->to,function($query)use($request){
        $query->whereDate('due_date', '>', $request->from)
        ->whereDate('due_date', '<=', $request->to);
        })
        ->when($request->status, function($query)use($request){
            $query->where('status', $request->status);
        })
        ->when($request->sort && $request->sortType,function($query)use($request){
            $query->orderBy($request->sort, $request->sortType);
        })
        ->get();
    }

    public function getUserTasks($userId)
    {
        return Task::where('user_id', $userId)->get();
    }

    public function getById($id)
    {
        return Task::where('id', $id)->first();
    }

    public function create(array $data)
    {
        return Task::create([
            'title'       => $data['title'],
            'description' => $data['description'] ?? null,
            'due_date'    => $data['due_date'],
            'status'      => $data['status'] ?? 'Pending',
            'user_id'     => Auth::id(),
        ]);
    }

    public function update($id, array $data, $userId)
    {
        $task = $this->getById($id, $userId);

        if (!$task) {
            return null;
        }

        $task->update([
            'title'       => $data['title'] ?? $task->title,
            'description' => $data['description'] ?? $task->description,
            'due_date'    => $data['due_date'] ?? $task->due_date,
            'status'      => $data['status'] ?? $task->status,
        ]);

        return $task;
    }

    public function delete($id, $userId)
    {
        $task = $this->getById($id, $userId);
        if (!$task) {
            return false;
        }

        return $task->delete();
    }
}