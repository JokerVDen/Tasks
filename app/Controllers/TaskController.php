<?php

namespace App\Controllers;

use App\Services\TaskService;
use App\Session;

/**
 * Class MainController
 * @package App\Controllers
 */
class TaskController extends CoreController
{
    /**
     * @var TaskService
     */
    private $taskService;
    /**
     * @var Session
     */
    private $session;

    /**
     * MainController constructor.
     */
    public function __construct()
    {
        $this->taskService = new TaskService();
        $this->session = Session::getInstance();

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

        $order = $this->taskService->getRightOrderFromRequest();
        if (!$order) {
            return abort();
        }

        $paginate = $this->taskService->getPaginate($perPage, $currentPage);
        if (!$paginate) {
            return abort();
        }
        $orderForPaginate = $this->taskService->getOrderForPaginate($order);

        $tasks = $this->taskService->getAllWithOrder($perPage, $currentPage, $order);

        $ordersForSelect = $this->taskService->getListOrdersForSelect();

        $pageTitle = "Список задач";
        return view('main.index', compact([
            'perPage',
            'tasks',
            'paginate',
            'order',
            'orderForPaginate',
            'ordersForSelect',
            'pageTitle'
        ]));
    }

    /**
     * Store new task
     */
    public function store()
    {
        $validateResult = $this->taskService->checkInputForNewTask($_POST);
        if ($validateResult->isNotValid()) {
            back(true, $validateResult->getMessages());
        }

        $this->taskService->createTask($validateResult->getValues());

        set_success('Данные сохранены');
        return back();
    }
}