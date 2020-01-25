<?php


namespace App\Services;


use App\Models\Task;

class TaskService
{
    /**
     * @var Task
     */
    private $task;

    public function __construct()
    {
        $this->task = new Task();
    }

    public function getOrderFromRequest()
    {
        $orderBy = $_POST['orderBy'] ?? $_GET['orderBy'] ?? "";
        if ($orderBy == "") {
            $direction = "";
        } else {
            $direction = strtolower($_POST['orderBy'] ?? $_GET['direction'] ?? "");
        }
        $order = [
            'orderBy'   => $orderBy,
            'direction' => $direction,
        ];

        $allowed = $this->task->getAllowedOrders();

        $isAllowedOrderBy = !in_array($order['orderBy'], $allowed) && $order['orderBy'] != "";
        $isAllowedDirection = !in_array($order['direction'], ['asc', 'desc']) && $order['direction'] != "";
        if ($isAllowedOrderBy && $isAllowedDirection)
            return false;

        return $order;
    }

    public function getPageFromRequest()
    {
        $page = (int)($_GET['page'] ?? 1);
        if (strval($page) != $_GET['page'])
            return false;

        return $page;
    }

}