<?php


namespace App\Repositories;


use App\Models\Task;

class TaskRepository extends BaseRepository
{

    public function __construct()
    {
        parent::__construct();
    }

    protected function getClass(): string
    {
        return Task::class;
    }

    /**
     * Get all tasks with some order
     *
     * @param int $perPage
     * @param int $currentPage
     * @param array $order
     * @return \Illuminate\Support\Collection
     */
    public function getAllWithOrder($perPage = 3, $currentPage = 1, array $order = [])
    {
        $orderBy = $order['orderBy'] ?? 'performed';
        $direction = $order['direction'] ?? 'asc';
        $offset = ($currentPage - 1) * $perPage;

        $tasks = $this->model
            ->select(['id', 'name', 'email', 'task', 'status', 'performed'])
            ->orderBy($orderBy, $direction)
            ->limit($perPage)
            ->offset($offset)
            ->toBase()
            ->get();
        return $tasks;
    }

    /**
     * Return the number of all tasks
     *
     * @return int
     */
    public function countAll()
    {
        $count = $this->model
            ->count();
        return $count;
    }

}