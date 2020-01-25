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
     * @param string $orderBy
     * @param string $direction
     * @return \Illuminate\Support\Collection
     */
    public function getAllWithOrder($perPage = 3, $currentPage = 1, $orderBy = 'created_at', $direction = 'desc')
    {
        $orderBy = $orderBy ?: 'created_at';
        if ($orderBy == 'created_at' && $direction == "") {
            $direction = 'desc';
        } else {
            $direction = $direction ?: 'asc';
        }

        $offset = ($currentPage - 1) * $perPage;

        $tasks = $this->model
            ->select(['id', 'name', 'email', 'task', 'performed'])
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

    public function getPaginate($perPage, $currentPage)
    {
        $countItems = $this->countAll();
        $countPages = intdiv($countItems, $perPage);
        $countPages = $countPages * $perPage < $countItems ? $countPages + 1 : $countPages;

        if ($countPages < $currentPage)
            return false;

        $back = $currentPage > 1 && $countPages > 1 ? $currentPage - 1 : false;
        $next = $currentPage + 1 <= $countPages ? $currentPage + 1 : false;

        $paginate = [
            'isPaginated' => $countPages > 1,
            'countItems'  => $countItems,
            'countPages'  => $countPages,
            'current'     => $currentPage,
            'back'        => $back,
            'next'        => $next,
        ];

        return $paginate;
    }

}