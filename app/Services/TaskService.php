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
        $orderBy = $_GET['orderBy'] ?? "";
        if ($orderBy == "") {
            $direction = "";
        } else {
            $direction = strtolower($_GET['direction'] ?? "");
        }

        $orderBy = $orderBy ?: 'performed';
        $direction = $direction ?: 'asc';

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
        $isNotHavePage = !isset($_GET['page']) ||
            (isset($_GET['page']) && $_GET['page'] == "");

        if ($isNotHavePage)
            return 1;

        $page = (int)$_GET['page'];

        if (strval($page) != $_GET['page'])
            return false;

        return $page;
    }

    public function getOrderForPaginate($inputOrder = [])
    {
        $order = $inputOrder ?: $this->getOrderFromRequest();

        $order['orderBy'] = $order['orderBy'] != 'performed' ? $order['orderBy'] : "";
        $order['direction'] = $order['direction'] != 'asc' ? $order['direction'] : "";

        return $order;
    }

    public function getOrdersForSelect()
    {
        return [
            'name'      => 'По имени',
            'email'     => 'По email',
            'performed' => 'По статусу'
        ];
    }

}