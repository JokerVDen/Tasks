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
    public function index()
    {
        $perPage = 3;

        $currentPage = $this->taskService->getPageFromRequest();
        if (!$currentPage) {
            return abort();
        }

        $order = $this->taskService->getOrderFromRequest();
        if (!$order) {
            return abort();
        }

        $paginate = $this->taskRepository->getPaginate($perPage, $currentPage);
        if (!$paginate) {
            return abort();
        }
        $orderForPaginate = $this->taskService->getOrderForPaginate($order);

        $tasks = $this->taskRepository->getAllWithOrder($perPage, $currentPage, $order['orderBy'], $order['direction']);

        $ordersForSelect = $this->taskService->getOrdersForSelect();

        return view('main.index', compact([
            'perPage',
            'tasks',
            'paginate',
            'order',
            'orderForPaginate',
            'ordersForSelect',
        ]));
    }


    public function store()
    {
        $validateResult = $this->taskService->checkInputForNewTask();
        if ($validateResult->isNotValid()) {
            back(true, $validateResult->getMessages());
        }

        $this->taskRepository->create($validateResult->getValues());

        setSuccess('Данные сохранены');
        return back();
    }
}