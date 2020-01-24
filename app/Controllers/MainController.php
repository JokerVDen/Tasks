<?php

namespace App\Controllers;

use App\Repositories\TaskRepository;

/**
 * Class MainController
 * @package App\Controllers
 */
class MainController
{
    /**
     * @var TaskRepository
     */
    private $taskRepository;

    /**
     * MainController constructor.
     */
    public function __construct()
    {
        $this->taskRepository = new TaskRepository();
    }

    /**
     * @return string
     */
    public function index() {
        return "asdfasdf";
    }
}