<?php

namespace App\Controllers;

use App\Repositories\TaskRepository;
use App\Services\TaskService;

/**
 * Class MainController
 * @package App\Controllers
 */
class MainController extends CoreController
{
    /**
     * @var TaskRepository
     */
    private $taskRepository;
    /**
     * @var TaskService
     */
    private $taskService;

    /**
     * MainController constructor.
     */
    public function __construct()
    {
        $this->taskRepository = new TaskRepository();
        $this->taskService = new TaskService();
    }

    /**
     * Index tasks page
     *
     * @return \Illuminate\Contracts\View\View|\Jenssegers\Blade\Blade
     */
    public function index() {
        $perPage = 3;

        $currentPage = $this->taskService->getPageFromRequest();

        $order = $this->taskService->getOrderFromRequest();
        if(!$order) {
            return abort();
        }

        $paginate = $this->taskRepository->getPaginate($perPage, $currentPage);
        if(!$paginate) {
            return abort();
        }

        $tasks = $this->taskRepository->getAllWithOrder($perPage, $currentPage, $order['orderBy'], $order['direction']);

        return view('main.index', compact([
            'perPage',
            'tasks',
            'paginate',
            'order'
        ]));
    }
}